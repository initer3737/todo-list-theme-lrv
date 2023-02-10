<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSettingController extends Controller
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

// function helper end
public function UserSettingInfo()
{
    $data=$this->userModel::where('id',Auth::user()->id)->get();
    return $this->Response($data,'success',200);
}
public function UserSetting(\App\Http\Requests\UserSettingRequest $request)
{
       //update data
}

} //end