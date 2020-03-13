<?php

namespace App\Http\Controllers\Auth;

use App\Publication;
use App\Publication_inv;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use Session;
use Redirect;
use Carbon\Carbon;

class RegisterPubController extends Controller
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

    public function showRegistrationForm()
    {
        return view('auth.registerpub');
    }

    public function register(Request $request)
    {
        $checked = [];
        $namesChecked = [];
        $names = Session::get('names_inv');
        $nameses = Session::get('extinv');
        $request = request();
        for($i = 0; $i < count($names); $i++){
            $s = strval('check' . strval($i));
            if(request($s, $default = null) != null){
                $checked[] = $i;
            }
        }
        if(count($checked) == 0){
            return Redirect::back()->with('failedinv', 'Selecciona por lo menos un investigador')->withInput($request->input());
        }
        foreach ($checked as $ch) {
            $namesChecked[] = $names[$ch];
        }
        if($nameses != null){
            foreach ($nameses as $name) {
                $namesChecked[] = $name;
            }
        }

        $this->validate($request, [
        'title' => 'required|string|unique:publications',
        'title2'  => 'nullable|string',
        'revact'  => 'string|string',
        ]);

        event(new Registered($user = $this->create($request->all())));
        event(new Registered($pro_inv = $this->createPub_inv($request->all(), $namesChecked)));

        session()->flash('pub_success', 'La publicación fue ingresada correctamente');

        return redirect($this->redirectPath());
    }

    public function registerpubinv(Request $request){

        if ($this->validator($request->all())->fails()) {
            $errors = $this->validator($request->all())->errors()->getMessages();            
            $clientErrors = array();
            foreach ($errors as $key => $value) {
                $clientErrors[$key] = $value[0];
            }
            $response = array(
                'status' => 'error',
                'response_code' => 201,
                'errors' => $clientErrors
            );           
        }else {
            $this->validator($request->all())->validate();
            $response = array(
                'status' => 'success',
                'response_code' => 200,
                'name' => $request->name,
                'passportnumber' => $request->passportnumber
            );
        }
        //echo json_encode($response);
        return $response;
    }

    public function addextinv(Request $request){
        Session::put('extinv', $request->extinv);
        Session::put('assinv', $request->assinv);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s[a-zA-ZáéíóúÁÉÍÓÚ]+\s([a-zA-ZáéíóúÁÉÍÓÚ]+\s?)+$/', 'unique:investigators'],
            'passportnumber' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Publication::create([
            'title' => strtoupper($data['title']),
            'title2' => strtoupper($data['title2']),
            'revact' => strtoupper($data['revact']),
            'date' => $data['date'],
            'pubtype' => $data['pubtype'],
            'subpubtype' => $data['subpubtype'],
            'proy' => $data['proy'],
        ]);
    }

    protected function createPub_inv(array $data, array $names){
        for($i = 0; $i < count($names); $i++){
            Publication_inv::create([
                'title_inv' => strtoupper($data['title']),
                'nameinv' => $names[$i],
            ]);
        }
    }
}
