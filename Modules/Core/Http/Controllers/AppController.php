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
        $apps = App::with(['user','statuses'])->get();
        return Datatables::of($apps)
            ->addIndexColumn()
            ->addColumn('status', function ($app) {
                return $app->latestStatus();
            })
            ->addColumn('status_date', function ($app) {
                return $app->latestStatus() != null ? $app->latestStatus()->created_at->format('d/m/Y H:i') : '';
            })
            ->setRowClass(function ($app) {
                switch ($app->status) {
                    case 'approved':
                        return 'context-menu-approved';
                        break;
                    case 'pending':
                    case 'rejected':
                    default:
                        return 'context-menu-reject';
                        break;
                }
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $form = ['route' => 'core.app.store', 'method' => 'POST'];
        $data = ['form' => $form, 'crud' => '/core/app'];
        return $this->layout($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = ['route' => 'core.app.store', 'method' => 'POST'];
        $data = ['form' => $form];
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
            $app = App::create($data);
            $app->setStatus(App::STATUS_PENDING);

            if ($request->ajax())
                return response()->json(['success' => true, 'message' => 'App was successfully inserted.']);

            return redirect()
                ->route('core.app.index')
                ->with('success_message', 'App was successfully added.');
        } catch (Exception $exception) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'App was not successfully inserted.']);

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

            if ($request->ajax())
                return response()->json(['success' => true, 'message' => 'App was successfully updated.']);

            return redirect()->route('core.app.index')->with('success_message', 'App was successfully added.');
        } catch (Exception $exception) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'App was not successfully updated.']);
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

            if ($request->ajax())
                return response()->json(['success' => true, 'message' => 'App was successfully deleted.']);

            return redirect()->route('core.app.index')->with('success_message', 'App was successfully deleted.');
        } catch (Exception $exception) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'App was not successfully deleted.']);

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Approve the specified resource from storage.
     * @param App $id
     * @return Renderable
     */
    public function approve(Request $request, App $app)
    {
        try {
            $app->approve();
            if ($request->ajax())
                return response()->json(['success' => true, 'message' => 'App was successfully approved.']);

            return redirect()->route('core.app.index')->with('success_message', 'App was successfully approved.');
        } catch (Exception $exception) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'App was not successfully approved.']);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Reject the specified resource from storage.
     * @param App $id
     * @return Renderable
     */
    public function reject(Request $request, App $app)
    {
        try {
            $app->reject();

            if ($request->ajax())
                return response()->json(['success' => true, 'message' => 'App was successfully blocked.']);

            return redirect()->route('core.app.index')->with('success_message', 'App was successfully added.');
        } catch (Exception $exception) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'App was not successfully blocked.']);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
