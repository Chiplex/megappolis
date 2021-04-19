<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Order;
use Modules\Yeipi\Entities\Detail;

class EntregarController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $orders = Order::withCount('details')->whereNull(['fechaSalida', 'delivery_id'])->whereNotNull('fechaSolicitud')->get();
        $data = ['orders' => $orders];
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
        //
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
        if (empty($order->fechaRecepcion) && empty($order->fechaEntrega)) {
            $form = [
                'route' => ['yeipi.entregar.update', $order->id], 
                'method' => 'put', 
                'name' => 'Recepcionar',
                'show' => true
            ];
        }
        if (isset($order->fechaRecepcion) && empty($order->fechaEntrega)) {
            $form = [
                'route' => ['yeipi.entregar.ahora', $order->id], 
                'method' => 'put', 
                'name' => 'Entregar',
                'show' => true
            ];
        }
        if (isset($order->fechaRecepcion) && isset($order->fechaEntrega)) {
            $form = [
                'route' => ['yeipi.entregar.ahora', $order->id], 
                'method' => 'put', 
                'name' => 'Entregar',
                'show' => false
            ];
        }
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
            if(auth()->user()->people->delivery->orders()->whereNull(['fechaEntrega'])->count() > 0){
                return back()
                    ->withErrors(['message' => 'Tiene entregas pendientes']);
            }

            $order->delivery_id = auth()->user()->people->delivery->id;
            $order->fechaRecepcion = \Carbon::now();
            $order->save();

            return redirect()->route('yeipi.entregar.edit', ['order'=> $order->id])
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

    public function conseguido(Detail $detail)
    {
        try {
            $detail->fechaConseguido = \Carbon::now();
            $detail->save();
            
            $detail->order->fechaSalida = \Carbon::now();
            $detail->order->save();

            return redirect()->route('yeipi.entregar.edit', ['order'=> $detail->order->id])
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function noConseguido(Detail $detail)
    {
        try {
            $detail->fechaNoConseguido = \Carbon::now();
            $detail->save();

            $detail->order->fechaSalida = \Carbon::now();
            $detail->order->save();

            return redirect()->route('yeipi.entregar.edit', ['order'=> $detail->order->id])
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function ahora(Request $request, Order $order)
    {
        try {
            $order->fechaEntrega = \Carbon::now();
            $order->save();

            return redirect()->route('yeipi.entregar.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
