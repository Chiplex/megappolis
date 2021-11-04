<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Product;
use Datatables;

class ProveerController extends Controller
{
    /**
     * @Get("/proveer/iniciar", "yeipi.proveer.preparar", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un formulario que prepara la ubicación del proveedor para la compra de productos
     * @return Renderable
     */
    public function preparar()
    {
        $provider = auth()->user()->people->provider;
        $shop = $provider->shop;
        if(isset($shop)){
            return redirect()->route('yeipi.proveer.index');
        }
        $form = ['route' => 'yeipi.proveer.iniciar', 'method' => 'post'];
        $data = ['provider' => $provider, 'form' => $form, 'provider' => $provider];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/proveer/iniciar", "yeipi.proveer.iniciar", 'access:YEIPI-CUSTOMER')
     * 
     * Crea o actualiza una tienda para el proveedor
     * @return Renderable
     */
    public function iniciar(Request $request)
    {
        try {
            $provider = auth()->user()->people->provider;
            $shop = Shop::firstOrNew($request->except('_token'));
            $shop->provider_id = $provider->id;
            $shop->save();

            return redirect()->route('yeipi.proveer.index');
            
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Get("/proveer/index", "yeipi.proveer.index", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra una lista de productos que se pueden comprar solo si el proveedor tiene una tienda
     * @return Renderable
     */
    public function index()
    {
        $shop = auth()->user()->people->provider->shop;
        if(!isset($shop)){
            return redirect()->route('yeipi.proveer.preparar');
        }
        $ordersDelivered = $shop->sales()->ordersDelivered()->get();
        $ordersNoDelivered = $shop->sales()->ordersNoDelivered()->get();
        $totalSales = $this->totalSales($shop->sales()->ordersDelivered());
        $stock = $shop->stock()->get();
        $data = compact('shop', 'ordersDelivered', 'ordersNoDelivered', 'totalSales', 'stock');
        return view('dashboard', $this->GetInfo($data));
    }

    public function data(Shop $shop)
    {
        $query = $shop->products();

        return Datatables::of($query)
            ->setRowClass('{{ "context-menu" }}')
            ->make(true);
    }

    public function dataStock()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shop;
        $stocks = $shops->stocks()->with('product');

        return Datatables::of($stocks)
            ->setRowClass('{{ "context-menu-stock" }}')
            ->addIndexColumn()
            ->make(true);
    }

    public function dataCustomer()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shop;
        $orders = $shops->sales()->ordersDelivered()->with(['customer.people', 'delivery.people']);

        return Datatables::of($orders)
            ->setRowClass('{{ "context-menu-customer" }}')
            ->addColumn('customer', function ($order){
                return $order->delivery? $order->delivery->people->getNameComplete():'';
            })
            ->addColumn('delivery', function ($order){
                return $order->customer? $order->customer->people->getNameComplete():'';
            })
            ->addIndexColumn()
            ->make(true);
    }

    

    

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('yeipi::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try { 
            Stock::create($request->all());

            if ($request->ajax()) {
                
                return response()->json(['success' => 'Product was successfully added.'], 200);
            }
            return redirect()->route('yeipi.product.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Product $product)
    {
        if($request->ajax()){
            return $product->shop()->wherePivot('stock', '>', '0')->get();
        }
        return view('yeipi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Shop $shop)
    {
        $form = ['route' => 'yeipi.proveer.store', 'method' => 'post', 'id' => 'frmProducto'];
        $products = Product::all()->pluck('descripcion_marca', 'id');
        $data = ['shop' => $shop, 'form' => $form, 'products' => $products];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Stock $stock)
    {
        try { 
            $stock->update($request->all());

            if ($request->ajax()) {
                
                return response()->json(['success' => 'Product was successfully added.'], 200);
            }
            return redirect()->route('yeipi.product.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
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

    public function delivery(Shop $shop)
    {
        $deliveries = Delivery::doesntHave('contracts')->get();
        $data = ['shop' => $shop, 'deliveries' => $deliveries];
        return view('dashboard', $this->GetInfo($data));
    }

    public function totalSales($details)
    {
        $total = 0;
        foreach ($details as $detail) {
            $subtotal = ($detail->cantidad * $detail->precio);
            $total = $total + $subtotal;
        }
        return $total;
    }
    
}
