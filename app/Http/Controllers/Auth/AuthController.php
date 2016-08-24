<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Model\Corretores;
use App\Model\Role;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = 'auth/login';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectAfterLogout = route('auth.login');
        $this->redirectTo = route('cotacao.cotar');

        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
        #$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }


    /**
     * overwrite the getCredentials to add the active user param..
     * */
    protected function getCredentials(Request $request)
    {

        $request['idstatus'] = 1;
        return $request->only($this->loginUsername(), 'password', 'idstatus');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {

        $data['cpfcnpj']= getDataReady($data['cpfcnpj']);


        $corretor = Corretores::whereCorrcpfcnpj($data['cpfcnpj'])->first();

        if($corretor){
            return Validator::make($data, [
                'nome' => 'required|max:255',
                'email' => 'required|email|max:255|unique:usuarios',
                'password' => 'required|min:6|confirmed',
                'cpfcnpj' => 'required|min:11|max:14',
            ]);
        } else{

            $data['telfixo']= getDataReady($data['telfixo']);
            $data['cel']= getDataReady($data['cel']);
            $data['cep']= getDataReady($data['cep']);

            return Validator::make($data, [
                'nome' => 'required|max:255',
                'email' => 'required|email|max:255|unique:usuarios',
                'password' => 'required|min:6|confirmed',
                'cpfcnpj' => 'required|min:11|max:14',
                'nomerazao' => 'required|',
                'susep' => 'alpha_num',
                'dddfixo'=>'required|integer',
                'telfixo'=>'required|integer',
                'dddcel'=>'integer',
                'cel'=>'integer',
                'corretora-email'=>'required|email',
                'cep'=>'required',
                'logradouro'=>'required|',
                'endnumero'=>'required|',
                'cidade'=>'required|',
                'comissao'=>'required|integer',

            ]);
        }


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */


    protected function create(array $data)
    {
        $data['cpfcnpj']= getDataReady($data['cpfcnpj']);
        $corretor = Corretores::whereCorrcpfcnpj($data['cpfcnpj'])->first();

        if($corretor){

            if($corretor->usuarios->count()){
                $role = Role::find(3);
                $user = User::create([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'idstatus' => 2,
                    'idcorretor' => $corretor->idcorretor,
                    'password' => bcrypt($data['password']),
                ]);
                $user->attachRole($role);

            }else{
                $role = Role::find(2);
                $user = User::create([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'idstatus' => 2,
                    'idcorretor' => $corretor->idcorretor,
                    'password' => bcrypt($data['password']),
                ]);
                $user->attachRole($role);
            }


        } else {

            $corretor = Corretores::create([
                'corrcpfcnpj'=> $data['cpfcnpj'],
                'corrnomerazao'=> $data['nomerazao'],
                'corresusep'=> $data['susep'],
                'corrdddfone'=> $data['dddfixo'],
                'corrnmfone'=> getDataReady($data['telfixo']),
                'corrdddcel'=> $data['dddcel'],
                'corrnmcel'=> getDataReady($data['cel']),
                'corremail'=> $data['corretora-email'],
                'corrcep'=> getDataReady($data['cep']),
                'corrnmend'=> $data['logradouro'],
                'corrnumero'=> $data['endnumero'],
                'correndcomplet'=> $data['complemento'],
                'corrnmcidade'=> $data['cidade'],
                'corrcduf'=> $data['uf'],
                'corrcomissaopadrao'=> $data['comissao'],
            ]);

            $role = Role::find(2);
            $user = User::create([
                'nome' => nomeCase($data['nome']),
                'email' => $data['email'],
                'idstatus' => 2,
                'idcorretor' => $corretor->idcorretor,
                'password' => bcrypt($data['password']),
            ]);
            $user->attachRole($role);
        }
        return $user ;
    }


    public function register(Request $request)
    {


        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return redirect($this->redirectPath())->with('sucesso','Cadastro relaizado com sucesso! Aguardando aprovação do administrador');
    }

    public function getCorretor(Request $request)
    {
        $corretor = $corretor = Corretores::whereCorrcpfcnpj($request->cpfcnpj)->first();



        if($corretor){
            $retorno = [
                'nomerazao'=> nomeCase($corretor->corrnomerazao),
                'susep'=>1,
                'dddfixo'=>1,
                'telfixo'=>1,
                'dddcel'=>1,
                'cel'=>1,
                'corretora-email'=>1,
                'cep'=>1,
                'logradouro'=>1,
                'endnumero'=>1,
                'complemento'=>1,
                'cidade'=>1,
                'uf'=>1,
                'comissao'=>1,
                'status' => true
            ];

        }else{
            $retorno = [ 'status' => false];
        }

        return response()->json($retorno);
    }

}
