<?php

namespace App\Http\Controllers\Auth;

use App\Group;
use App\Country_unit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use Session;

class RegisterGestionarGruposController extends Controller
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
    private $img_name = null;

    public function showRegistrationForm()
    {
        return view('auth.customgroups');
    }
    
    public function upload(Request $request)
    {
        $u = $request->unidades;
        $p = $request->paises;
        Session::put('uni', $u);
        Session::put('pai', $p);
        $this->validate($request, [
        'name' => 'required|string|max:255|unique:groups',
        'select_file'  => 'nullable|image|mimes:jpeg,jpg,png',
        'unidades.*' => 'required|string',
        'paises.*' => 'required|string'
        ]);
        
        $image = $request->file('select_file');
        session()->flash('gr_success', 'El grupo fue añadido correctamente');
        if($image == null){
            event(new Registered($user = $this->create($request->all(), 'null')));
            event(new Registered($user = $this->createA($u, $p, $request->name)));
            return redirect($this->redirectPath());
        }
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        event(new Registered($user = $this->create($request->all(), $new_name)));
        event(new Registered($user = $this->createA($u, $p, $request->name)));    
        $image->move(public_path('images'), $new_name);
        $this->img_name = $new_name;
        return redirect($this->redirectPath())->with('path', $new_name);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, string $img_name)
    {
        if($img_name == 'null'){
            return Group::create([
                'name' => strtoupper($data['name']),
            ]);
        }
        return Group::create([
                'name' => strtoupper($data['name']),
                'path' => $img_name,
            ]);

    }

    protected function createA(array $unit, array $country, string $name)
    {
        for($i = 0; $i < count($unit); $i++){
            Country_unit::create([
                'namegroup' => strtoupper($name),
                'unit' => strtoupper($unit[$i]),
                'country' => strtoupper($country[$i]),
            ]);
        }
    }

}
