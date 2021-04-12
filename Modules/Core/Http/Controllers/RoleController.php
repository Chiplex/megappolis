<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\App;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();
        $data = ['roles' => $roles];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $apps = App::all();
        $data = ['apps' => $apps];
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
            $data = $request->all();
            Role::create($data);

            return redirect()->route('core.role.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            dd($exception);
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
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role)
    {
        $apps = App::all();
        $data = ['apps' => $apps, 'role' => $role];
        return view('dashboard', $this->GetInfo($data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Role $role)
    {
        try {
            $data = $request->all();
            $role->update($data);

            return redirect()->route('core.role.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            dd($exception);
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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function user(Role $role)
    {
        $data = ['user' => $role->with("user")->get()];
        return view('dashboard', $this->GetInfo($data));
    }
}
