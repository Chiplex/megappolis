<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Shop;

class ProveerController extends Controller
{
    public function preparar()
    {
        $provider = auth()->user()->people->provider;
        $shops = $provider->shops;
        if($shops->count() > 1){
            //enviar al menu de shops del proveedor
        }
        $form = ['route' => 'yeipi.proveer.iniciar', 'method' => 'post'];
        $data = ['provider' => $provider, 'form' => $form, 'provider' => $provider, 'shop' => $shops->first()];
        return view('dashboard', $this->GetInfo($data));
    }

    public function iniciar(Request $request)
    {
        try {
            $provider = auth()->user()->people->provider;
            $shop = Shop::make($request->all());
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
        $orders = auth()->user()->people()->customer()->get();
        $data = ['apps' => $orders];
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
    public function edit(Shop $shop)
    {
        $form = ['route' => ['yeipi.proveer.update', $shop->id], 'method' => 'put'];
        $data = ['shop' => $shop, 'form' => $form];
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

    public function delivery(Shop $shop)
    {
        $deliveries = Delivery::doesntHave('contracts')->get();
        $data = ['shop' => $shop, 'deliveries' => $deliveries];
        return view('dashboard', $this->GetInfo($data));
    }
}
