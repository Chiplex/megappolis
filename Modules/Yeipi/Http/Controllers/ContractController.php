<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Yeipi\Entities\Contract;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Delivery;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $contracts = Contract::all();
        $data = ['contracts' => $contracts];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $shops = Shop::pluck('nombre', 'id')->all();
        $deliveries = Delivery::with('people')->doesntHave('contracts')->get()->pluck('people.name', 'id');
        $form = ['route' => 'yeipi.contract.store', 'method' => 'post'];
        $inputs = $this->getInputs($shops, $deliveries, null);
        $data = ['shops' => $shops, 'deliveries' => $deliveries, 'form' => $form, 'collection' => $inputs];
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
            Contract::firstOrCreate($request->except('_token'));

            return redirect()->route('yeipi.contract.index')
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
    public function edit($id)
    {
        return view('yeipi::edit');
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

    public function getInputs($shops, $deliveries, $contract)
    {
        return [
                [
                    'tipo' => 'form.select',
                    'elementos' => ['name' => 'shop_id', 'title' => 'Proveedor', 'list' => $shops, 'selected' => $contract->shop_id ?? null]
                ],
                [
                    'tipo' => 'form.select',
                    'elementos' => ['name' => 'delivery_id', 'title' => 'Delivery', 'list' => $deliveries, 'selected' => $contract->delivery_id ?? null]
                ],
                [
                    'tipo' => 'form.date',
                    'elementos' => ['name' => 'empieza', 'title' => 'Empieza', 'value' => $contract->empieza ?? null]
                ],
                [
                    'tipo' => 'form.date',
                    'elementos' => ['name' => 'acaba', 'title' => 'Acaba', 'value' => $contract->acaba ?? null]
                ]
            ];
    }
}
