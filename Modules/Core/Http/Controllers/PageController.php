<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\App;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $pages = Page::with('app')->get();
        $data = ['pages' => $pages];

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
        $apps = App::all();
        $data = ['apps' => $apps];

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
            $data['state'] = "A";
            $data['page_id'] = 0;
            Page::create($data);

            return redirect()->route('core.page.index')
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
    public function show(Page $page)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Page $page)
    {
        $apps = App::all();
        $data = ['apps' => $apps, 'page' => $page];

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
    public function update(Request $request,  Page $page)
    {
        try {
            $data = $request->all();
            $page->update($data);

            return redirect()->route('core.page.index')
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
}
