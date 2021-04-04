<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $permissions = Permission::with(['page.app'])->get();
        $data = ['permissions' => $permissions];

        $page = request()->attributes->get('page');
        $permission = request()->attributes->get('permissions');
        $info = ['view' => $page, 'permissions' => $permission, 'data'=> $data];

        return view('dashboard', $info);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $pages = Page::all();
        $roles = Role::all();
        $data = ['pages' => $pages, 'roles' => $roles];

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
        try {
            $data = $request->all();
            Permission::create($data);

            return redirect()->route('core.permission.index')
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
    public function edit(Permission $permission)
    {
        $pages = Page::all();
        $roles = Role::all();
        $data = ['pages' => $pages, 'roles' => $roles, 'permission' => $permission];

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
}
