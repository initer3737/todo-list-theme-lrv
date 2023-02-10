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
public function UserInfo(Request $request)
{
        $datas=DB::table('users')->select(DB::raw(' username,name,avatar,country,status,gender,user_conections,score,ROW_NUMBER() OVER(order by score desc) as ranking'))->get();
        $username=$request->username;
            $resData=$this->filterData($username,$datas);
      if(!$resData){
        return $this->Response($resData,'not found 404',404);
      }      
            return $this->Response($resData,'success',200);
}

} //end
