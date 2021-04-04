<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Role;

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

        $page = request()->attributes->get('page');
        $permissions = request()->attributes->get('permissions');
        $info = ['view' => $page, 'permissions' => $permissions, 'data'=> $data];

        return view('dashboard', $info);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = [];

        $page = request()->attributes->get('page');
        $permissions = request()->attributes->get('permissions');
        $info = ['view' => $page, 'permissions' => $permissions, 'data'=> $data];

        return view('dashboard', $info);
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
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role)
    {
        $data = ['role' => $role];

        $page = request()->attributes->get('page');
        $permissions = request()->attributes->get('permissions');
        $info = ['view' => $page, 'permissions' => $permissions, 'data'=> $data];

        return view('dashboard', $info);
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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function user(Role $role)
    {
        $roles = Role::all();
        $data = ['users' => $role->users()->get()];

        $page = request()->attributes->get('page');
        $permissions = request()->attributes->get('permissions');
        $info = ['view' => $page, 'permissions' => $permissions, 'data'=> $data];
        
        return view('dashboard', $info);
    }
}
