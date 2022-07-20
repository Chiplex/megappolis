<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Entities\App;
use Modules\Core\Entities\People;
use Modules\Core\Entities\Input;

class HomeController extends Controller
{
    public function index()
    {
        $apps = App::all();
        return view('home', compact('apps'));
    }

    public function create()
    {
        $form = ['route' => 'passport.store', 'method' => 'post', 'files' => true];
        return view('passport', \compact('form'));
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|max:50',
                'otherName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'otherLastName' => 'max:50',
                'birth' => 'required|date',
                'country' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'sex' => 'required',
                'document' => 'required',
            ]);

            $people = new People;
            $people->name = $validate['name'];
            $people->otherName = $validate['otherName'];
            $people->lastName = $validate['lastName'];
            $people->otherLastName = $validate['otherLastName'];
            $people->birth = $validate['birth'];
            $people->country = $validate['country'];
            $people->city = $validate['city'];
            $people->phone = $validate['phone'];
            $people->sex = $validate['sex'];
            $people->document = $validate['document'];
            $people->tipo = 'HUM';
            $people->save();

            return redirect()->route('core.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
