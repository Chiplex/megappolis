<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Carbon\Carbon;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Order;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Product;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Detail;
use Datatables;

class PedirController extends Controller
{
    /**
     * @Get("/pedir/data/index/{order}", "yeipi.pedir.data.detail", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna los detalles de los pedidos como Datatables
     * @param Order $Order
     * @return Datatables
     */
    public function dataDetail(Order $order)
    {
        $details = $order->details()->with(['stock.product','stock.shop']);
        return Datatables::of($details)
            ->setRowClass('{{ "context-menu" }}')
            ->addColumn('subtotal', function ($detail){
                return $detail->cantidad * $detail->precio;
            })
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @Get("/pedir/data/history", "yeipi.pedir.data.history", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna el historico de los pedidos como Datatables
     * @param Order $Order
     * @return Datatables
     */
    public function dataHistory()
    {
        $customer = auth()->user()->people->customer;
        $orders = $customer->orders();
        return Datatables::of($orders)
            ->setRowClass('{{ "context-menu" }}')
            ->addColumn('delivery', function ($order){
                return $order->delivery? $order->delivery->people->getNameComplete():'';
            })
            ->addColumn('products', function ($order){
                $product = '';
                $details = $order->details;
                $first = $details->first();
                $last = $details->last();
                foreach ($details as $detail) {
                    if ($detail->is($first)) $product = $product . $detail->stock->product->descripcion;
                    else if($detail->is($last))  $product = $product . ', ' . $detail->stock->product->descripcion;
                    else $product = $product . ', ' . $detail->stock->product->descripcion;
                }
                return $product;
            })
            ->addColumn('total', function ($order){
                return $order->details()->count();
            })
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @Get("/pedir/iniciar", "yeipi.pedir.preparar", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un formulario de ubicación del consumidor
     * @return Renderable
     */
    public function preparar()
    {
        $customer = auth()->user()->people->customer;
        $form = ['route' => 'yeipi.pedir.iniciar', 'method' => 'post'];
        $data = ['customer' => $customer, 'form' => $form];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/pedir/iniciar", "yeipi.pedir.iniciar", 'access:YEIPI-CUSTOMER')
     * 
     * Actualiza la ubicacion del consumidor
     * @param Request $request
     * @return RedirectResponse
     */
    public function iniciar(Request $request)
    {
        try {
            $customer = auth()->user()->people->customer;
            $customer->direccion = $request->direccion;
            $customer->latitud = $request->latitud;
            $customer->longitud = $request->longitud;
            $customer->save();

            return redirect()->route('yeipi.pedir.index')
                ->with('success_message', 'information was successfully added.');
            
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
    
    /**
     * @Get("/pedir/index", "yeipi.pedir.index", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra lista de stock de productos que el usuario puede pedir
     * @return Renderable
     */
    public function index()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->sinSolicitar()->firstOrCreate(['customer_id' => $customer->id]);
        $details = $order ? $order->details()->get() : \collect();
        $stocks = Stock::all();
        $data = ['customer' => $customer, 'details' => $details, 'stocks' => $stocks, 'order' => $order];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/pedir/register", "yeipi.pedir.store", 'access:YEIPI-CUSTOMER')
     * 
     * Actualiza la ubicacion del consumidor
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try { 
            if ($request->ajax()) {
                $customer = auth()->user()->people->customer;
                $order = Order::where(['id' => $request->order_id, 'customer_id' => $customer->id])->firstOrCreate(['customer_id' => $customer->id]);
                $stock = Stock::firstWhere($request->except(['_token', 'cantidad', 'descripcion', 'order_id']));

                $detail = Detail::preparando()->firstOrNew(['order_id' => $order->id, 'stock_id' => $stock->id]);
                $detail->cantidad = $request->cantidad;
                $detail->descripcion = $request->descripcion ?? '';
                $detail->precio = $stock->precio;
                $detail->save();

                $data = ['success' => 'Detail was successfully added.', 'detail' => $detail->load('stock.product')];
                return response()->json($data);
            }
        } catch (\Exception $exception) {
            dd($exception);
            if ($request->ajax()) {
                return response()->json(['error' => 'Unexpected error occurred while trying to process your request.'], 422);
            }
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

     /**
     * @Get("/pedir/register/{order}", "yeipi.pedir.edit", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra los detalles del pedido del consumidor
     * @param Order $Order
     * @return Renderable
     */
    public function edit(Order $order)
    {
        $details = $order->details()->get();
        $form = ['route' => 'yeipi.pedir.solicitar', 'method' => 'post'];
        $data = ['order' => $order, 'details' => $details, 'form' => $form];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/pedir/solicitar", "yeipi.pedir.solicitar", 'access:YEIPI-CUSTOMER')
     * 
     * Solicita el pedido para el delivery
     * @param Request $request
     * @return Renderable
     */
    public function solicitar(Request $request)
    {
        try { 
            $customer = auth()->user()->people->customer;
            $order = Order::where(['id' => $request->order_id, 'customer_id' => $customer->id])->firstOrFail();

            if ($order->details()->count() == 0) {
                return back()
                    ->withErrors(['message' => 'No tiene nada que pedir']);           
            }

            $order->fechaSolicitud = Carbon::now();
            $order->save();

            return redirect()->route('yeipi.pedir.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Order $order
     * @return Renderable
     */
    public function update(Request $request, Order $order)
    {
        try { 
            if ($order->details()->count() == 0) {
                return back()
                    ->withErrors(['message' => 'No tiene nada que pedir']);           
            }

            $order->fechaSolicitud = Carbon::now();
            $order->save();

            return redirect()->route('yeipi.pedir.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
 
    public function producto(Request $request)
    {
        dd($request);
    }

    public function shop(Product $product)
    {
        if(request()->ajax()){
            $shops = $product->shops()->wherePivot('stock', '>', '0')->get();
            return response()->json(['success' => 'Product was successfully added.', 'shops' => $shops], 200);
        }
    }

    public function count()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->noDelivered()->firstOrCreate(['customer_id' => $customer->id]);
        $data = ['details_count' => $order->details()->count()];
        return response()->json($data);
    }

    public function history()
    {
        $customer = auth()->user()->people->customer;
        $orders = $customer->orders()->get();
        $data = ['customer' => $customer, 'orders' => $orders];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = [];
        return view('dashboard', $this->GetInfo($data));
    }

    
}


// el delivery debe ver aquellos pedidos que has sido solicitados
// solo se puede pedir si la ultima orden ha sido entregada
// crear modal para editar el pedido 
// lo mejor seria que una vez solicitada solamente puede ver el estado de su pedido y no pedir