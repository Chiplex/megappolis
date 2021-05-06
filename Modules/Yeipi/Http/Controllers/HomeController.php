<?php

namespace Modules\Yeipi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Core\Entities\People;
use Modules\Core\Entities\Role;
use Modules\Yeipi\Entities\Customer;
use Modules\Yeipi\Entities\Delivery;
use Modules\Yeipi\Entities\Provider;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        if(auth()->user()->roles()->count() == 0)
        {
            $role = Role::firstWhere('name', 'YEIPI-GUEST');
            auth()->user()->roles()->syncWithoutDetaching($role->id);
        }  
        
        
        $data = [];
        return view('yeipi::home.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($yeipi)
    {
        $people = auth()->user()->people;
        $form = [
            'route' => 'yeipi.home.store', 
            'method' => 'post', 
        ];
        $data = ['people' => $people, 'action' => $yeipi, 'form' => $form];
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
            $people = auth()->user()->people;
            $people->phone = $request->phone;
            $people->save();

            switch ($request->action) {
                case 'pedir':
                    $role_name = 'YEIPI-CUSTOMER';
                    Customer::firstOrCreate(['people_id' => $people->id]);
                    break;
                case 'entregar':
                    $role_name = 'YEIPI-DELIVERY';
                    Delivery::firstOrCreate(['people_id' => $people->id]);
                    break;
                case 'proveer':
                    $role_name = 'YEIPI-PROVIDER';
                    Provider::firstOrCreate(['people_id' => $people->id]);
                    break;
            }
            $role = Role::firstWhere('name', $role_name);
            auth()->user()->roles()->syncWithoutDetaching($role->id);

            return redirect()->route('yeipi.'.$request->action.'.iniciar')
                ->with('success_message', 'information was successfully added.');
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
}
