<?php

namespace Modules\Core\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Modules\Core\Entities\App;
use DataTables;

class AppController extends Controller
{
    /**
     * Show data for Datatables
     */
    public function data()
    {
        $apps = App::with('user')->get();
        return Datatables::of($apps)
            ->addIndexColumn()
            ->setRowClass('{{ "context-menu" }}')
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = [];
        return $this->layout($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = [];
        return $this->layout($data);
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
            $data['user_id'] = auth()->user()->id;
            App::create($data);

            return redirect()
                ->route('core.app.index')
                ->with('success_message', 'App was successfully added.');
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(App $app)
    {
        $data = ['app_' => $app];
        return $this->layout($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(App $app)
    {
        $data = ['app_' => $app];
        return $this->layout($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, App $app)
    {
        try {
            $data = $request->all();
            $app->update($data);

            return redirect()->route('core.app.index')
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
    public function destroy(App $app)
    {
        try {
            $app->delete();

            return redirect()->route('core.app.index')
                ->with('success_message', 'App was successfully deleted.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function approve(App $app)
    {
        try {
            $app->approved_at = Carbon::now();
            $app->blocked_at = null;
            $app->save();

            return redirect()->route('core.app.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function block(App $app)
    {
        try {
            $app->blocked_at = Carbon::now();
            $app->approved_at = null;
            $app->save();

            return redirect()->route('core.app.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
