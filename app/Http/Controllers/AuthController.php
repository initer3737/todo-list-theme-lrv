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
                $session=$this->session();
            $token=$session->createToken('login')->accessToken;
            $this->userModel::where('username',$session->username)->update(['user_conections'=>'online']);
        return $this->Response(null,'login succesfully',200,'Bearer',$token);
     }

// function helper end

    public function Register(
        \App\Http\Requests\registerRequest $request
        )
    {
            $datas=$request->validated();
            $datas['name']='your name';
            $datas['user_conections']='offline';
            $datas['score']=0;
            $datas['status']='status';
            $datas['password'] = Hash::make($datas['password']);
            // Hash::make($datas->password);
        $inserted=$this->userModel::create($datas);
        if(!$inserted){
            return $this->Response(null,'register failed',409);
        }
            // return $this->Response(null,'registered succesfully',200);
                $this->loginAttempt($request->only(['username','password'])) ;
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
        $request->password=Hash::make($request->password);
        $reset_action=$this->userModel::where('username',$request->username)->update(['password'=>$request->password]);
            if(!$reset_action)$this->Response(null,'username tidak ditemukan!',404);
          return $this->Response(null,'reset successfully!',200); 
        // $this->loginAttempt($request->only(['username','password'])) ;
        //     return $this->loginAttemptResponse();  
    }

    public function Logout()
    { $session=$this->session();
        $this->userModel::where('username',$session->username)->update(['user_conections'=>'offline']);
        $session->token()->revoke();
        return $this->Response(null,'logout succesfully',200);
    }

    public function Scope()
    {
        $data=$this->userModel->lobbyInfo();
        return $this->Response($data,'ok',200);
    }

    
} //end
