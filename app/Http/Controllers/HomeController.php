<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Entities\People;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $app = $user->apps()->where('name', request()->segment(1) ?? 'core')->first();
        if($app == null){
            return 'no aprobo su email';
        }
        return view('dashboard', $this->GetInfo([]));
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
                'dateBirth' => 'required|date',
                'country' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'sex' => 'required',
                'documentoNumero' => 'required',
            ]);

            $people = new People;
            $people->name = $validate['name'];
            $people->otherName = $validate['otherName'];
            $people->lastName = $validate['lastName'];
            $people->otherLastName = $validate['otherLastName'];
            $people->dateBirth = $validate['dateBirth'];
            $people->country = $validate['country'];
            $people->city = $validate['city'];
            $people->phone = $validate['phone'];
            $people->sex = $validate['sex'];
            $people->tipo = 'HUM';
            $people->save();

            return redirect()->route('core.index')
                ->with('success_message', 'Attribute was successfully added.');
        } catch (Exception $exception) {
            dd($exception);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
