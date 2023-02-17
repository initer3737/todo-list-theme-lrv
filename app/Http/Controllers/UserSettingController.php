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
{       $selected=['password','avatar','name','username','country','status','gender','user_conections','score'];
    $data=$this->userModel::select($selected)->where('id',Auth::user()->id)->get();
    return $this->Response($data,'success',200);
}

/**
 * 
 */
public function UserSetting(\App\Http\Requests\UserSettingRequest $request)
{
    $data=$this->userModel::find(Auth::user()->id);
    $avatar=$request->avatar;
    $formdata=$request->validated();
            //foto profile avatar
        if( !is_null($avatar) ){
            //name of foto
                /**foto lawas di delete lalu ganti dengan yang baru */
            $foto=Auth::user()->username.\substr(uniqid(),3,-4).'.'.$avatar->extension();
                $image_path ="/public/avatar/{$data['avatar']}";
                if(Storage::exists($image_path))Storage::delete($image_path);
            $path=$avatar->storeAs("avatar",$foto,['disk'=>'public']);
            $formdata['avatar']=$foto;
        }
            //form data
                //hash password
               $formdata['password']=hash::make($formdata['password']); 
            if(is_null($formdata['username']))$formdata['username']=$data->username;
            if(is_null($formdata['name']))$formdata['name']=$data->name;
            if(is_null($formdata['country']))$formdata['country']=$data->country;
            if(is_null($formdata['status']))$formdata['status']=$data->status;
            if(is_null($formdata['gender']))$formdata['gender']=$data->gender;
            if(is_null($formdata['password']))$formdata['password']=$data->password;
            if(is_null($formdata['avatar']))$formdata['avatar']=$data->avatar;
       $data->update($formdata);  

       if(!$data)return $this->Response(null,'failed to update',200);
       return $this->Response(null,'update data success',200);
    }

} //end


//https://youtu.be/7Fn0ZSydCNk