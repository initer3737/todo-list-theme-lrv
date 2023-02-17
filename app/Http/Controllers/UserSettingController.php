<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

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
{       $selected=['password','name','username','country','status','gender','user_conections','score'];
    $avatar=$this->userModel::find(Auth::user()->id)->avatar;
    $data=$this->userModel::select($selected)->where('id',Auth::user()->id)->get();
        $data['avatar_link']="http://localhost:8000/storage/avatar/{$avatar}";
    return $this->Response($data,'success',200);
}

public function UserSetting(\App\Http\Requests\UserSettingRequest $request)
{
    $data=$this->userModel::find(Auth::user()->id);
            //foto profile avatar
        if( !is_null($request->avatar) ){
            $avatar=$request->avatar;
            //name of foto
                /**foto lawas di delete lalu ganti dengan yang baru */
            $foto=Auth::user()->username.\substr(uniqid(),3,-4).'.'.$avatar->extension();
                $image_path ="/public/avatar/{$data['avatar']}";
                if(Storage::exists($image_path))Storage::delete($image_path);
            $data->update(['avatar'=>$foto]);
            $path=$avatar->storeAs("avatar",$foto,['disk'=>'public']);
        }
        if(is_null($data->avatar))$link=null;
        if(!is_null($data->avatar))$link="http://localhost:8000/storage/avatar/{$data->avatar}";
            //https://youtu.be/7Fn0ZSydCNk
    $data=[
        // 'foto'=>Storage::exists("public/avatar/{$data['avatar']}") ,
        // 'url'=>$image_path
    ];
    return $this->Response($data,'success',200);
}

} //end