<?php
namespace App\Http\Controllers\Auth;
use App\GenericClass;
use App\Libraries\Repositories\GeneralRepository;
use App\Model\Empresa;
use App\Model\Conexion;
use App\Model\Usuario;
use App\Model\UsuarioSucursal;
use App\Model\UsuarioWeb;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Contracts\Auth\Guard;
use App\Services\Registrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;
    protected $redirectTo = '/home';

    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'logout']);
    }
    public function showLoginForm()
    {

        $view = property_exists($this, 'loginView')? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login');
    }
    public function login(Request $request)
    {
        $input = $request->all();
        $workspace = isset($input["workspace"]) && $input["workspace"]!=''? $input["workspace"]:null;
        $loginPath = '/login';
        if(isset($workspace) && $workspace!="") {
            $licencia = DB::connection("ryv_admin")->table("licencias")->where("clave",$workspace)->first();
            if($licencia){
                $loginPath = '/login/'.$workspace;
                $request->session()->put('workspace', $workspace);
                if ($licencia->activo == '0') {
                    return redirect($loginPath)
                        ->withInput($request->only('name', 'remember'))
                        ->withErrors([
                            'name' => "Su licencia no se encuentra activo",
                        ]);
                }
                $fecha = date('Y-m-d');
                if ($fecha >= $licencia->vence) {
                    return redirect($loginPath)
                        ->withInput($request->only('name', 'remember'))
                        ->withErrors([
                            'name' => "Su licencia se encuentra vencida [".$licencia->vence."]"
                        ]);
                }
            }
            else{
                return redirect($loginPath)
                    ->withInput($request->only('name', 'remember'))
                    ->withErrors([
                        'name' => "No se encontró su estacion de trabajo",
                    ]);

            }
            if(GenericClass::setConnectionByLicencia($workspace)) {
                $this->validate($request, [
                    'email' => 'required', 'password' => 'required',
                ]);
                $credentials = $request->only('email', 'password');

                $usuario = User::where("email", $input["email"])->first();

                if($usuario) {
                    //if ($this->auth->attempt($credentials, $request->has('remember'))) {
                    if ($this->auth->attempt($credentials, false)) {

                        $user = $this->auth->user();

                        if ($licencia->id != $user->licencia_id) {
                            return redirect($loginPath)
                                ->withInput($request->only('name', 'remember'))
                                ->withErrors([
                                    'name' => "Hay un problema con su usuario. Favor de reportarlo",
                                ]);

                        }

                        $request->session()->put('user_id', $user->id);
                        $request->session()->put('licencia_id', $user->licencia_id);
                        $request->session()->put('licencia', $workspace);
                        $request->session()->put('tipo', "user");

                        //return redirect($this->redirectTo);
                        return redirect()->intended($this->redirectTo);
                    } else {
                        if(isset($input["_token"])) {
                            return redirect($loginPath)
                                ->withInput($request->only('name', 'remember'))
                                ->withErrors([
                                    'name' => "Su contraseña es incorrecta.",
                                ]);
                        }
                        else{
                            $this->redirectTo = url('/login');
                            return redirect()->intended($this->redirectTo);
                        }

                    }
                }
                else{
                    return redirect($loginPath)
                        ->withInput($request->only('name', 'remember'))
                        ->withErrors([
                            'name' => "No se encuentra el usuario registrado.",
                        ]);

                }
            }
            else{
                return redirect($loginPath)
                    ->withInput($request->only('name', 'remember'))
                    ->withErrors([
                        'name' => "No se encontró conexion a su espacio de trabajo.",
                    ]);

            }

        }
        else{
            return redirect($loginPath)
                ->withInput($request->only('name', 'remember'))
                ->withErrors([
                    'name' => "No ingresó su espacio de trabajo.",
                ]);

        }

        //return $this->sendFailedLoginResponse($request);

    }
    public function logout(){
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
