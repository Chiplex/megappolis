<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Product;
use Modules\Yeipi\Entities\Order;
use Datatables;

class ProveerController extends Controller
{
    /**
     * @Get("/proveer/iniciar", "yeipi.proveer.preparar", 'access:YEIPI-PROVIDER')
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
     * @Post("/proveer/iniciar", "yeipi.proveer.iniciar", 'access:YEIPI-PROVIDER')
     * 
     * Actualiza la ubicacion del shop del proveedor
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
     * @Get("/proveer/index", "yeipi.proveer.index", 'access:YEIPI-PROVIDER')
     * 
     * Muestra la pagina principal del proveedor
     * @return Renderable
     */
    public function index()
    {
        $shop = auth()->user()->people->provider->shop;

        // Si el proveedor no tiene una tienda, se redirecciona a la pagina de preparacion
        if(!isset($shop)){
            return redirect()->route('yeipi.proveer.preparar');
        }
        
        // Obtener las ordenes entregadas y no entregadas del proveedor
        
            
        if($shop->sales->isEmpty()){
            $ordersDelivered = collect();
            $ordersUndelivered = collect();
            $totalSales = 0;
        }else{
            $ordersDelivered = Order::delivered()->with(['stocks'=> function ($query) use ($shop){
                $query->where('shop_id', $shop->id);
            }])->get();
            $ordersUndelivered = Order::unDelivered()->with(['stocks'=> function ($query) use ($shop){
                $query->where('shop_id', $shop->id);
            }])->get();
            $totalSales = $this->totalSales($ordersDelivered);
        }
        
        $stock = $shop->stocks;

        // Generar un formulario para agregar un producto
        $form = ['route' => 'yeipi.proveer.stock.store', 'method' => 'POST', 'id' => 'frmProducto'];
        
        $data = compact('shop', 'ordersDelivered', 'ordersUndelivered', 'totalSales', 'stock', 'form');
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Obtiene el total de las ventas
     * @return int
     */
    private function totalSales($sales)
    {
        $total = 0;
        foreach ($sales as $sale) {
            $subtotal = ($sale->cantidad * $sale->precio);
            $total = $total + $subtotal;
        }
        return $total;
    }

    /**
     * @Get("/proveer/product", "yeipi.pedir.product", 'access:YEIPI-PROVIDER')
     * 
     * Muestra una lista de productos que se agregaran al stock del proveedor
     * @return JsonResponse
     */
    public function product()
    {
        if(request()->ajax()){
            $shop = auth()->user()->people->provider->shop;
            $stock = $shop->stocks;
            $products = Product::all();
            return response()->json(['success' => 'Resource loaded.', 'products' => $products]);
        }
    }

    /**
     * @Post("/proveer/stock", "yeipi.proveer.stock", 'access:YEIPI-PROVIDER')
     * 
     * Agrega un producto al stock del proveedor
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try { 
            Stock::create($request->all());

            if ($request->ajax()) 
                return response()->json(['success' => 'Product was successfully added.'], 200);
            
            return redirect()->route('yeipi.product.index');
        } catch (Exception $exception) {
            if ($request->ajax()) 
                return response()->json(['error' => 'Unexpected error occurred while trying to process your request.'], 500);
            
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Put("/proveer/stock/{stock}", "yeipi.proveer.stock", 'access:YEIPI-PROVIDER')
     * 
     * Actualiza un producto del stock del proveedor
     * @param Stock $stock
     * @return Renderable
     */
    public function update(Stock $stock, Request $request)
    {
        try { 
            $stock->update($request->all());

            if ($request->ajax()) 
                return response()->json(['success' => 'Product was successfully updated.'], 200);
            
            return redirect()->route('yeipi.product.index');
        } catch (Exception $exception) {
            if ($request->ajax()) 
                return response()->json(['error' => 'Unexpected error occurred while trying to process your request.'], 500);
            
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Get("/proveer/stock/", "yeipi.proveer.stock", 'access:YEIPI-PROVIDER')
     * 
     * Muestra la página de los productos en stock
     * @return Renderable
     */
    public function stock()
    {
        $shop = auth()->user()->people->provider->shop;
        $stock = $shop->stocks;
        $breadcrumb = ['title' => 'Stock', 'url' => route('yeipi.proveer.stock')];
        $form = ['route' => 'yeipi.proveer.stock.store', 'id' => 'form-stock'];
        $data = compact('shop', 'stock', 'form');
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Get("/proveer/data/stock", "yeipi.proveer.data.stock", 'access:YEIPI-PROVIDER')
     * 
     * Retorna una lista de productos en stock como DataTable
     * @return Datatables
     */
    public function dataStock()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shop;
        $stocks = $shops->stocks()->with('product');

        return Datatables::of($stocks)
            ->setRowClass('context-menu-stock')
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @Get("/proveer/customer", "yeipi.proveer.customer", 'access:YEIPI-PROVIDER')
     * 
     * Muestra la página de los clientes
     * @return Renderable
     */
    public function customer()
    {
        $shop = auth()->user()->people->provider->shop;
        $orders = Order::delivered()->with(['customer.people', 'delivery.people'])->whereRelation('stocks', 'shop_id', $shop->id);
        $data = compact('shop', 'orders');
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Get("/proveer/data/customer", "yeipi.proveer.data.customer", 'access:YEIPI-PROVIDER')
     * 
     * Retorna una lista de clientes con el delivery y su estado como DataTable
     * @return Datatables
     */
    public function dataCustomer()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shop;

        // Trer las ordenes entregadas y no entregadas solo si el proveedor tiene una ventas
        if($shops->sales->isEmpty()){
            $orders = collect();
        }else{
            $orders = $shops->sales->order()->delivered()->with(['customer.people', 'delivery.people']);
        }

        return Datatables::of($orders)
            ->setRowClass('context-menu-customer')
            ->addColumn('customer', function ($order){
                return $order->delivery? $order->delivery->people->getNameComplete(): '';
            })
            ->addColumn('delivery', function ($order){
                return $order->customer? $order->customer->people->getNameComplete(): '';
            })
            ->addIndexColumn()
            ->make(true);
    }
}
