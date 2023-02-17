<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInfoController extends Controller
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

    protected function filterData(string $q,object $datas){
        foreach ($datas as $data) {
            if($data->username == $q){
                return $data; 
            }
        }
}

// function helper end
public function UserInfoSession()
    {
        $data=$this->userModel::select('score','avatar','username')->where('username',Auth::user()->username)->get();
        return $this->Response($data,'ok',200);
    }

public function UserInfo(Request $request)
{//UserInfo
    
        $datas=$this->userModel->userInformation();
        $username=$request->username;
            $resData=$this->filterData($username,$datas);
      if(!$resData){
        return $this->Response($resData,'not found 404',404);
      }    
            return $this->Response($resData,'success',200);
}




} //end
