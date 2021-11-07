<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Carbon\Carbon;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Order;
use Modules\Yeipi\Entities\Detail;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Product;
use Datatables;

class PedirController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * @Get("/pedir/iniciar", "yeipi.pedir.preparar", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un formulario que solicita la ubicación del consumidor para realizar una orden
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
     * Actualiza la ubicación del consumidor para realizar una orden
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
     * Muestra lista de stock de productos unicos de multiples shops donde el consumidor puede pedir
     * @return Renderable
     */
    public function index()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Undelivered()->firstOrCreate(['customer_id' => $customer->id]);
        $details = $order ? $order->details()->get() : collect();
        $stocks = Stock::whereNotIn('shop_id', $details->pluck('id'))->select('product_id')->groupBy('product_id')->get();
        $data = ['customer' => $customer, 'details' => $details, 'stocks' => $stocks, 'order' => $order];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Get("/pedir/search/{buscar}", "yeipi.pedir.search", 'access:YEIPI-CUSTOMER')
     * 
     * Busca atraves de una solicitud AJAX productos unicos de multiples shops donde el consumidor puede pedir 
     * @param String $buscar
     * @return Renderable
     */
    public function search($buscar)
    {
        if ($buscar == '*') {
            $stocks = Stock::select('product_id')->groupBy('product_id')->get();
        } else {
            $stocks = Stock::where(function($query) use ($buscar) {
                $query->product()->where('name', 'like', '%' . $buscar . '%')
                    ->orWhere('description', 'like', '%' . $buscar . '%');
            })->select('product_id')->groupBy('product_id')->get();
        }
    }

    /**
     * @Post("/pedir/register", "yeipi.pedir.store", 'access:YEIPI-CUSTOMER')
     * 
     * Almacena un detalle de la orden actual atraves de una peticion Ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try { 
            if ($request->ajax()) {
                $customer = auth()->user()->people->customer;
                $order = $customer->orders()->lastest()->Undelivered()->firstOrCreate(['customer_id' => $customer->id]);
                $stock = Stock::firstWhere($request->except(['_token', 'cantidad', 'descripcion', 'order_id']));
                
                // Validar que no se pueda pedir más de lo que hay en stock
                if ($stock->stock < $request->cantidad) {
                    return response()->json(['error' => 'No hay suficiente stock para realizar el pedido.']);
                }

                // Validar que no se puede pedir mas de 5 productos
                if ($order->details()->count() >= 5) {
                    return response()->json(['error' => 'No puedes pedir más de 5 productos.']);
                }

                $detail = $order->details()->inPreparation()->firstOrNew(['order_id' => $order->id, 'stock_id' => $stock->id]);
                $detail->cantidad = $request->cantidad;
                $detail->descripcion = $request->descripcion ?? '';
                $detail->precio = $stock->precio;
                $detail->save();

                $data = ['success' => 'Detail was successfully added.', 'detail' => $detail->load('stock.product')];
                return response()->json($data);
            }
        } catch (\Exception $exception) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unexpected error occurred while trying to process your request.'], 422);
            }
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @get("/pedir/count", "yeipi.pedir.count", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna la cantidad de productos que tiene el consumidor en el carrito
     * @return JsonResponse
     */
    public function count()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Undelivered()->firstOrCreate(['customer_id' => $customer->id]);
        $data = ['details_count' => $order->details()->count()];
        return response()->json($data);
    }

    /**
     * @Get("/pedir/history", "yeipi.pedir.history", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra el historial de las ordenes del consumidor
     * @return Renderable
     */
    public function history()
    {
        $customer = auth()->user()->people->customer;
        $orders = $customer->orders()->get();
        $data = ['customer' => $customer, 'orders' => $orders];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Get("/pedir/data/history", "yeipi.pedir.data.history", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna el historico de las ordenes como Datatables
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
     * @Get("/pedir/current", "yeipi.pedir.current", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna la orden actual
     * @param Request $request
     * @return Renderable
     */
    public function current()
    {
        try { 
            $customer = auth()->user()->people->customer;
            $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();
            $details = $order->details()->get();

            // Si no ha solicitado ningun producto, redireccionar a index
            if ($details->count() == 0) {
                return redirect()->route('yeipi.pedir.index');
            }
            
            // Si no solicitó un pedido, generar formulario de solicitud
            if ($order->fechaSolicitud == null) {
                $form = ['route' => 'yeipi.pedir.solicitar', 'method' => 'post'];
                $text = 'Solicitar';
            }
            // Si ya solicitó un pedido, generar formulario de cancelacion
            else {
                $form = ['route' => 'yeipi.pedir.cancelar', 'method' => 'delete'];
                $text = 'Cancelar';
            }

            $data = ['order' => $order, 'details' => $details, 'form' => $form, 'text' => $text];
            return view('dashboard', $this->GetInfo($data));
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Get("/pedir/data/index/{order}", "yeipi.pedir.data.detail", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna los detalles de las ordenes como Datatables
     * @param Order $Order
     * @return Datatables
     */
    public function dataCurrent()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();
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
     * @Post("/pedir/solicitar", "yeipi.pedir.solicitar", 'access:YEIPI-CUSTOMER')
     * 
     * Solicita la orden para el delivery
     * @param Request $request
     * @return Renderable
     */
    public function solicitar(Request $request)
    {
        try { 
            $customer = auth()->user()->people->customer;
            $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();

            // Si la orden no tiene productos, redireccionar a index con un mensaje de error
            if ($order->details()->count() == 0) {
                return back()
                    ->withErrors(['unexpected_error' => 'No se puede solicitar un pedido sin productos.']);
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
     * @Post("/pedir/cancelar", "yeipi.pedir.cancelar", 'access:YEIPI-CUSTOMER')
     * 
     * Cancela el pedido solo si no esta en proceso de entrega
     * @param Request $request
     * @return Renderable
     */
    public function cancelar(Request $request)
    {
        try { 
            $customer = auth()->user()->people->customer;
            $order = Order::where(['id' => $request->order_id, 'customer_id' => $customer->id])->firstOrFail();

            if ($order->fechaEntrega) {
                return back()
                    ->withErrors(['message' => 'No se puede cancelar un pedido que ya fue entregado']);           
            }

            //$order->fechaCancelacion = Carbon::now();

            return redirect()->route('yeipi.pedir.history')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
    
    /**
     * @Update("/pedir/register", "yeipi.pedir.register", 'access:YEIPI-CUSTOMER')
     * 
     * Actualiza un detalle del pedido actual atraves de una peticion Ajax
     * @param Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {
            if ($request->ajax()) {
                $customer = auth()->user()->people->customer;
                $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();
                $detail = $order->details()->where('id', $request->detail_id)->firstOrFail();
                $detail->cantidad = $request->cantidad;
                $detail->precio = $request->precio;
                $detail->save();
                return response()->json(['success' => 'Pedido actualizado']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => 'error']);
        }
    }

    /**
     * @Delete("/pedir/register", "yeipi.pedir.register", 'access:YEIPI-CUSTOMER')
     * 
     * Actualiza un detalle del pedido actual atraves de una peticion Ajax
     * @param Request $request
     * @return Renderable
     */
    public function delete(Request $request)
    {
        try {
            if ($request->ajax()) {
                $customer = auth()->user()->people->customer;
                $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();
                $detail = $order->details()->where('id', $request->detail_id)->firstOrFail();
                $detail->delete();

                // Devolver el stock
                $stock = $detail->stock;
                $stock->cantidad = $stock->cantidad + $detail->cantidad;
                $stock->save();

                // Si no quedan detalles, eliminar la orden
                if ($order->details()->count() == 0) {
                    $order->delete();
                }
                
                return response()->json(['success' => 'Detalle eliminado']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => 'error']);
        }
    }

    /**
     * @Get("/pedir/qualify", "yeipi.pedir.qualify", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna la vista de calificacion de un pedido
     * @return Renderable
     */
    public function qualify()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Delivered()->firstOrFail();
        $form = ['route' => 'yeipi.pedir.qualify', 'method' => 'post'];
        $data = ['customer' => $customer, 'form' => $form, 'order' => $order];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/pedir/qualify", "yeipi.pedir.qualify", 'access:YEIPI-CUSTOMER')
     * 
     * Guarda la calificacion de un pedido
     * @param Request $request
     * @return Renderable
     */
    public function qualifyStore(Request $request)
    {
        try {
            $customer = auth()->user()->people->customer;
            $order = $customer->orders()->lastest()->Delivered()->firstOrFail();
            $order->calificacion = $request->calificacion;
            $order->save();
            return redirect()->route('yeipi.pedir.history')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}