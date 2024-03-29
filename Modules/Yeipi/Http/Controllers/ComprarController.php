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

class ComprarController extends Controller
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
     * @Get("/comprar/iniciar", "yeipi.comprar.preparar", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un formulario de solicitud de ubicación del consumidor
     * @return Renderable
     */
    public function preparar()
    {
        $customer = auth()->user()->people->customer;
        $form = ['route' => 'yeipi.comprar.iniciar', 'method' => 'post'];
        $data = ['customer' => $customer, 'form' => $form];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/comprar/iniciar", "yeipi.comprar.iniciar", 'access:YEIPI-CUSTOMER')
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

            return redirect()->route('yeipi.comprar.index');
            
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Get("/comprar/index", "yeipi.comprar.index", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un listado de productos disponibles para la compra
     * @return Renderable
     */
    public function index()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Undelivered()->firstOrCreate(['customer_id' => $customer->id]);
        $details = $order ? $order->details()->get() : collect();
        $stocks = Stock::select('product_id')->groupBy('product_id')->get();
        $routes = [
            'location' => route('yeipi.comprar.preparar'),
            'cart' => route('yeipi.comprar.cart'),
            'shop' => url('yeipi/comprar/shop'),
            'count' => route('yeipi.comprar.count'),
            'current' => route('yeipi.comprar.current'),
        ];
        $formProduct = ['method' => 'post', 'class' => 'form-product'];
        $formDetail = ['route' => 'yeipi.comprar.detail.store', 'method' => 'post', 'id' => 'form-detail'];
        $data = compact('customer', 'order', 'details', 'stocks', 'routes', 'formProduct', 'formDetail');
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Get("/comprar/search/{search}", "yeipi.comprar.search", 'access:YEIPI-CUSTOMER')
     * 
     * Busca un producto por su nombre a traves de una solicitud ajax
     * @param String $search
     * @return JsonResponse
     */
    public function search($search)
    {
        if ($search == '*') {
            $stocks = Stock::select('product_id')->groupBy('product_id')->get();
        } else {
            $stocks = Stock::where(function($query) use ($search) {
                $query->product()->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })->select('product_id')->groupBy('product_id')->get();
        }

        $products = Product::whereIn('id', $stocks->pluck('product_id'))->get();
        return response()->json($products);
    }

    /**
     * @Get("/comprar/cart", "yeipi.comprar.cart", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra un listado de productos en el carrito de compras a traves de una solicitud ajax
     * @return JsonResponse
     */
    public function cart()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Undelivered()->firstOrCreate(['customer_id' => $customer->id]);
        $details = $order ? $order->details()->with('stock.product')->get() : collect();
        $data = ['details' => $details];
        return response()->json($data);
    }

    /**
     * @Get("/comprar/shop/{product}", "yeipi.comprar.shop", 'access:YEIPI-CUSTOMER')
     * 
     * Muestra lista de shops quienes ofrecen el producto solicitado
     * @param Product $product
     * @return JsonResponse
     */
    public function shop(Product $product)
    {
        if(request()->ajax()){
            $shops = $product->shops()->wherePivot('stock', '>', '0')->withPivot('precio')->get();
            return response()->json(['success' => 'Resource loaded.', 'shops' => $shops]);
        }
    }

    /**
     * @Post("/comprar/detail", "yeipi.comprar.store", 'access:YEIPI-CUSTOMER')
     * 
     * Almacena un detalle de la orden actual a traves de una peticion Ajax
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
                
                // Validar que no se pueda comprar más de lo que hay en stock
                if ($stock->stock < $request->cantidad) {
                    return response()->json(['error' => 'No hay suficiente stock para realizar el pedido.'], 422);
                }

                // Validar que no se puede comprar mas de 5 productos
                if ($order->details()->count() >= 5) {
                    return response()->json(['error' => 'No puedes comprar más de 5 productos.'], 422);
                }

                $detail = $order->details()->inPreparation()->firstOrNew(['order_id' => $order->id, 'stock_id' => $stock->id]);
                $detail->cantidad = $request->cantidad;
                $detail->descripcion = $request->descripcion ?? '';
                $detail->precio = $stock->precio;
                $detail->save();

                // Actualizar el stock
                $stock->stock -= $request->cantidad;
                $stock->save();

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
     * @get("/comprar/count", "yeipi.comprar.count", 'access:YEIPI-CUSTOMER')
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
     * @Get("/comprar/history", "yeipi.comprar.history", 'access:YEIPI-CUSTOMER')
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
     * @Get("/comprar/data/history", "yeipi.comprar.data.history", 'access:YEIPI-CUSTOMER')
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
     * @Get("/comprar/current", "yeipi.comprar.current", 'access:YEIPI-CUSTOMER')
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
                return redirect()->route('yeipi.comprar.index');
            }
            
            // Si no solicitó un pedido, generar formulario de solicitud
            if ($order->fechaSolicitud == null) {
                $formPedido = ['route' => 'yeipi.comprar.solicitar', 'method' => 'post'];
                $text = 'Solicitar';
            }
            // Si ya solicitó un pedido, generar formulario de cancelacion
            else {
                $formPedido = ['route' => 'yeipi.comprar.cancelar', 'method' => 'delete'];
                $text = 'Cancelar';
            }
            // Si ya se completó el pedido, generar formulario de calificación de servicio
            if ($order->fechaEntrega != null) {
                $formPedido = ['route' => 'yeipi.comprar.calificar', 'method' => 'post'];
                $text = 'Calificar';
            }

            $formDetalle = ['url' => '/yeipi/comprar/detail', 'method' => 'post', 'id' => 'form-detail'];

            $routes = [
                'dataCurrent' => route('yeipi.comprar.data.current'),
                'current' => route('yeipi.comprar.current'),
                'delete' => route('yeipi.comprar.detail.delete'),
            ];

            $data = compact('order', 'details', 'formPedido', 'formDetalle', 'text', 'routes');
            return view('dashboard', $this->GetInfo($data));
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @Get("/comprar/data/index/{order}", "yeipi.comprar.data.detail", 'access:YEIPI-CUSTOMER')
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
     * @Post("/comprar/solicitar", "yeipi.comprar.solicitar", 'access:YEIPI-CUSTOMER')
     * 
     * Solicita la orden completa para el delivery
     * @param Request $request
     * @return RedirectResponse
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

            return redirect()->route('yeipi.comprar.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
   
    /**
     * @Post("/comprar/cancelar", "yeipi.comprar.cancelar", 'access:YEIPI-CUSTOMER')
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

            // Actualizar el stock de los productos solicitados
            $details = $order->details()->get();
            foreach ($details as $detail) {
                $stock = $detail->stock;
                $stock->cantidad = $stock->cantidad + $detail->cantidad;
                $stock->save();
            }
            
            return redirect()->route('yeipi.comprar.history')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
    
    /**
     * @Update("/comprar/detail", "yeipi.comprar.update", 'access:YEIPI-CUSTOMER')
     * 
     * Actualiza el detalle de la orden
     * @param Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {
            if ($request->ajax()) {
                $customer = auth()->user()->people->customer;
                $order = $customer->orders()->lastest()->Undelivered()->firstOrFail();
                $detail = $order->details()->where('id', $request->id)->firstOrFail();

                // Validar que no se pueda comprar más de lo que hay en stock
                $stock = $detail->stock;
                if ($stock->stock < $request->cantidad) {
                    return response()->json(['message' => 'No se puede comprar más de lo que hay en stock.']);
                }

                // Actualizar el stock de los productos solicitados
                $stock->stock = $stock->stock - $detail->cantidad;
                $stock->save();

                $detail->cantidad = $request->cantidad;
                $detail->save();
                return response()->json(['success' => 'Detalle actualizado']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => 'error']);
        }
    }

    /**
     * @Delete("/comprar/detail", "yeipi.comprar.delete", 'access:YEIPI-CUSTOMER')
     * 
     * Elimina el detalle de la orden
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
     * @Get("/comprar/qualify", "yeipi.comprar.qualify", 'access:YEIPI-CUSTOMER')
     * 
     * Retorna la vista de calificacion de la orden
     * @return Renderable
     */
    public function qualify()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->Delivered()->firstOrFail();
        $form = ['route' => 'yeipi.comprar.qualify', 'method' => 'post'];
        $data = ['customer' => $customer, 'form' => $form, 'order' => $order];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * @Post("/comprar/qualify", "yeipi.comprar.qualify", 'access:YEIPI-CUSTOMER')
     * 
     * Guarda la calificacion de la orden
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
            return redirect()->route('yeipi.comprar.history')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}