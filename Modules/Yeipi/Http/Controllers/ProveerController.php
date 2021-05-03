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
    public function data(Shop $shop)
    {
        $query = $shop->products();

        return Datatables::of($query)
            ->setRowClass('{{ "context-menu" }}')
            ->make(true);
    }

    public function preparar()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shop;
        if(isset($shops)){
            //enviar al menu de shops del proveedor
        }
        $form = ['route' => 'yeipi.proveer.iniciar', 'method' => 'post'];
        $data = ['provider' => $provider, 'form' => $form, 'provider' => $provider];
        return view('dashboard', $this->GetInfo($data));
    }

    public function iniciar(Request $request)
    {
        try {
            $provider = auth()->user()->people->provider;
            $shop = Shop::firstOrNew($request->except('_token'));
            $shop->provider_id = $provider->id;
            $shop->save();

            return redirect()->route('yeipi.proveer.edit', ['shop' => $shop->id])
                ->with('success_message', 'information was successfully added.');
            
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $shop = auth()->user()->people->provider->shop;
        $ordersDelivered = $shop->sales()->ordersDelivered()->get();
        $ordersNoDelivered = $shop->sales()->ordersNoDelivered()->get();
        $totalSales = $shop->sales();
        $data = compact('ordersDelivered', 'ordersNoDelivered');
        return view('dashboard', $this->GetInfo($data));
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

    
}
