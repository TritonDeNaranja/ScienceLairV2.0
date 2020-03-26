<?php

namespace App\Http\Controllers\Auth;

use App\Project;
use App\Project_Inv;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Calendar;
use Session;
use Redirect;
use Carbon\Carbon;
class RegisterProjectController extends Controller
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

    public function showRegistrationForm()
    {
        return view('auth.registerproject');
    }


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function register(Request $request)
    {

        // $datestart = strtotime($request['datestart']);
        // $dateend = strtotime($request['dateend']);
        // $datestart = new DateTime($request['datestart']);
        // $dateend = new DateTime($request['dateend']);
        $datestart = Carbon::createFromFormat('d/m/Y', $request['datestart']);
        $dateend = Carbon::createFromFormat('d/m/Y', $request['dateend']);



        if($datestart > $dateend){
            return Redirect::back()->with('faileddate', 'Selecciona una fecha de término posterior a la fecha de inicio')->withInput($request->input());
        }

        $checked = [];
        $namesChecked = [];
        $names = Session::get('names');
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
        
        $this->validate($request, [
        'name_project' => 'required|string|max:255|unique:projects',
        'code' => 'nullable|string|max:255',
        ]);


        event(new Registered($pro = $this->create($request->all())));
        event(new Registered($pro_inv = $this->createProj_inv($request->all(), $namesChecked)));

        session()->flash('proj_success', 'El proyecto fue ingresado correctamente');

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Project::create([
            'name_project' => strtoupper($data['name_project']),
            'code' => $data['code'],
            'state' => $data['state'],
            'date_start' => $data['datestart'],
            'date_end' => $data['dateend'],
        ]);
    }
    public function edit(Request $request){
        $proy = Project::findOrFail($request->id);
        

        $uniqueValidation = strcmp($request->input("project"), $proy->name_project) == 0 ? "" : "unique:project";
        
        $proy->name_project = $request->input("name_project");
        $proy->code = $request->input("code");
        $proy->state = $request->input("state");
        $proy->date_start = $request->input("date_start");
        $proy->date_end = $request->input("date_end");
        $proy->save();

        return back();
    }


    protected function createProj_inv(array $data, array $names){
        for($i = 0; $i < count($names); $i++){
            Project_Inv::create([
                'namepro' => strtoupper($data['name_project']),
                'name_inv' => $names[$i],
            ]);
        }
    }

    protected function delProj_inv(array $data, array $names){
        for($i = 0; $i < count($names); $i++){
            Project_Inv::find($data['name_project'])->delete();
        }
    }
}
