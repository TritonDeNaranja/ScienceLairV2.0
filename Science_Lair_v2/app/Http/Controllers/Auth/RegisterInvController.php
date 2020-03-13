<?php

namespace App\Http\Controllers\Auth;

use App\Investigator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterInvController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showRegistrationForm()
    {
        return view('auth.registerinv');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s([a-zA-ZáéíóúÁÉÍÓÚ]+\s?)+$/|max:255|unique:investigators',
        'passportnumber'  => 'required|string'
        ]);


        event(new Registered($user = $this->create($request->all())));

        session()->flash('inv_success', 'El investigador fue ingresado correctamente');

        return redirect($this->redirectPath());
    }
    public function edit(Request $request){
        $inv = Investigator::findOrFail($request->input("id"));

        $uniqueValidation = strcmp($request->input("name"), $inv->name) == 0 ? "" : "unique:investigators";
        $request->validate([
            'name' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s([a-zA-ZáéíóúÁÉÍÓÚ]+\s?)+$/|max:255|'.$uniqueValidation,
            'passportnumber'  => 'required|string'
            ]);

        $inv->name = $request->input("name");
        $inv->passportnumber = $request->input("passportnumber");
        $inv->state = $request->input("state");
        $inv->associatedunit = $request->input("associatedunit");
        $inv->save();
        return back();
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Investigator::create([
            'name' => strtoupper($data['name']),
            'passportnumber' => $data['passportnumber'],
            'state' => $data['state'],
            'associatedunit' => $data['associatedunit'],
        ]);
    }
}
