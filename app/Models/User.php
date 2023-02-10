<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'avatar',
        'country',
        'status',
        'gender',
        'user_conections',
        'score',
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
            // experimental purpose!!!
    protected function scopeBlyat(){
        return 'halo blyat!!';
    }
//====================================
    //===============scope function that do the job done!
    protected function scopeOnlineCount(){
        return User::select('user_conections')->where('user_conections','online')->count();
    }

    protected function scopeOfflineCount(){
        return User::select('user_conections')->where('user_conections','offline')->count();
    }
    protected function scopeLobbyInfo(){
            $datas=DB::table('users')
                    ->select(DB::raw('name,avatar,score,ROW_NUMBER() OVER(order by score desc) as ranking'))->limit(10)->get();
                return $datas ;
    }
}
