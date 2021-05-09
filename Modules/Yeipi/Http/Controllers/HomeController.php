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
            auth()->user()->roles()->sync($role->id);
        }

        return view('yeipi::home.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($yeipi)
    {
        switch ($yeipi) {
            case 'pedir':
                $action = 'bg-primary';
                break;
            case 'entregar':
                $action = 'bg-danger';
                break;
            case 'proveer':
                $action = 'bg-info';
                break;
            default:
                $action = 'bg-default';
                break;
        }
        $people = auth()->user()->people;
        $form = [
            'route' => 'yeipi.home.store', 
            'method' => 'post', 
        ];
        $data = ['people' => $people, 'action' => $action, 'form' => $form, 'yeipi' => $yeipi];
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
            $people = auth()->user()->people ?? People::firstOrNew($request->except(['_token', 'action', 'profile', 'anverso', 'reverso']));
            if($people->isDirty()) $people->tipo = 'HUM';
            $people->sex = $request->sex;
            $people->phone = $request->phone;
            $people->documentNumber = $request->documentNumber;
            $people->save();

            if(auth()->user()->people == null)
            {
                $user = auth()->user();
                $user->people_id = $people->id;
                $user->save();
            }

            switch ($request->action) {
                case 'pedir':
                    $role_name = 'YEIPI-CUSTOMER';
                    Customer::firstOrCreate(['people_id' => $people->id]);
                    break;
                case 'entregar':
                    $role_name = 'YEIPI-DELIVERY';
                    Delivery::firstOrCreate(['people_id' => $people->id, 'puntuacion' => '3', 'valoracion' => '']);
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
}
