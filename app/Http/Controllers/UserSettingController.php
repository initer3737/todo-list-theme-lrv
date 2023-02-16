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
{       $selected=['password','name','avatar','username','country','status','gender','user_conections','score'];
    $data=$this->userModel::select($selected)->where('id',Auth::user()->id)->get();
    return $this->Response($data,'success',200);
}

public function UserSetting(\App\Http\Requests\UserSettingRequest $request)
{
        //file yang diupload user adalah foto jadi validasi dulu apakah foto user sudah diperbarui? 
       //update 
        if( !is_null($request->avatar) ){
            //lakukan update
        }
       return dd($request);
    //    $this->userModel::where('id',Auth::user()->id)->update($request->validated());
}

} //end
