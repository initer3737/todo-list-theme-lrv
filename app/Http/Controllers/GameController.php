<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\gameRequest;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
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
public function GameGetScore()
    {
        // $data=Auth::user()->id;
        $data=$this->userModel::select('score')->where('username',Auth::user()->username)->get();
        return $this->Response($data,'ok',200);
    }

public function GameUpdateScore( gameRequest $req )
    {
        $data=Auth::user()->id;
        $data=$this->userModel::where('username',Auth::user()->username)->update($req->validated());
        return $this->Response('','update success!!',200);
    }






} //end
