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

class PedirController extends Controller
{
    public function preparar()
    {
        $customer = auth()->user()->people->customer;
        $form = ['route' => 'yeipi.pedir.iniciar', 'method' => 'post'];
        $data = ['customer' => $customer, 'form' => $form];
        return view('dashboard', $this->GetInfo($data));
    }

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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $customer = auth()->user()->people->customer;
        $order = $customer->orders()->lastest()->sinSolicitar()->first();
        $details = $order ? $order->details()->get() : \collect();
        $stocks = Stock::all();
        $data = ['customer' => $customer, 'details' => $details, 'stocks' => $stocks];
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

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try { 
            if (auth()->user()->people->customer->orders()->noDeliveries()->count() > 0) {
                return back()
                    ->withErrors(['message' => 'Tiene una orden pendiente']);           
            }
            $values = $request->all();
            $order = Order::create($values);

            return redirect()->route('yeipi.pedir.edit', ['order' => $order->id])
                ->with('success_message', 'Attribute was successfully added.');
        } catch (\Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('yeipi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Order $order)
    {
        $details = $order->details()->get();
        $form = ['route' => ['yeipi.pedir.update', $order->id], 'method' => 'put'];
        $data = ['order' => $order, 'details' => $details, 'form' => $form];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
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
 
    public function product(Request $request)
    {
            
    }

    public function shop(Product $product)
    {
        if(request()->ajax()){
            $shops = $product->shops()->wherePivot('stock', '>', '0')->get();
            return response()->json(['success' => 'Product was successfully added.', 'shops' => $shops], 200);
        }
    }
}
