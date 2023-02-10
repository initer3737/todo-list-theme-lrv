<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function __construct(User $user)
    {
        $this->userModel=$user;
    }
            // function helper start
    protected function Response($data=null,$msg=null,$statusCode=404,$type=null,$token=null){
        $res=[
            'status'=>$statusCode,
            'message'=>$msg,
            'token'=>$token,
            'type'=>$type,
            'data'=>$data,
        ];
            return response()->json($res);
    }

    private function session(){
        return Auth::user();
     }

    private function loginAttempt($credentials){
       return Auth::attempt($credentials);
     }
    private function loginAttemptResponse(){
            //digunakkan untuk meng generate token ketika user sukses dalam melakukan login
            $token=$this->session()->createToken('login')->accessToken;
            $this->userModel::find($this->session()->id)::update(['user_conections'=>'online']);
        return $this->Response(null,'login succesfully',200,'Bearer',$token);
     }

// function helper end

    public function Register(
        \App\Http\Requests\registerRequest $request
        )
    {
            $datas=$request->validated();
            $datas['name']='';
            $datas['user_conections']='offline';
            $datas['score']=0;
            $datas['password'] = Hash::make($datas['password']);
            // Hash::make($datas->password);
        $inserted=$this->userModel::create($datas);
        if(!$inserted){
            return $this->Response(null,'register failed',409);
        }
            // return $this->Response(null,'registered succesfully',200);
            return $this->loginAttemptResponse(); 
    }

    public function Login(
        \App\Http\Requests\loginRequest $request
        )
    {
        if(!$this->loginAttempt($request->validated())){
           return $this->Response(null,'username atau password salah',403);
        }
       return $this->loginAttemptResponse(); 
    }

    public function Reset(
        \App\Http\Requests\resetRequest $request
        )
    {
        return $this->userModel::find($request->username)->update($request->validated());
    //    return $this->loginAttemptResponse(); 
    }

    public function Logout()
    {
        $this->userModel::find($this->session()->id)::update(['user_conections'=>'offline']);
        Auth::user()->token()->revoke();
        return $this->Response(null,'logout succesfully',200);
    }

    public function Scope()
    {
        $data=$this->userModel->lobbyInfo();
        return $this->Response($data,'ok',200);
    }

    public function Lists()
    {
        $data=Auth::user();
        return $this->Response($data,'ok',200);
    }
} //end
