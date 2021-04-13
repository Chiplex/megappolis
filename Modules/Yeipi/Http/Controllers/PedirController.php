<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Order;
use Modules\Yeipi\Entities\Shop;

class PedirController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $customer = auth()->user()->people()->first()->customer()->first();
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

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try { 
            $values = $request->all();
            $order = Order::create($values);

            return redirect()->route('yeipi.pedir.update', ['order' => $order->id])
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
        $data = ['order' => $order, 'details' => $details];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}
