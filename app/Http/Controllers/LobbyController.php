<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class LobbyController extends Controller
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
public function LobbyInfo()
{
    return $this->Response( $this->userModel->lobbyInfo(),'success!',200 );
}

public function UserCountingConnectionInfo()
{$user=$this->userModel;
    $data=[
        'online'=>$user->onlineCount(),
        'offline'=>$user->offlineCount()
    ];
    return $this->Response( $data,'success!',200 );
}

} //end
