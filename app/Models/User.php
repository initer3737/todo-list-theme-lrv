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
        // 'password',
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
      private function RankingUserInfo(string $selectQuery){
            $emblem="case when ROW_NUMBER() over(order by score desc) <=3 then 'godong gedang'
                        when ROW_NUMBER() over(order by score desc) <=6 then 'not bad noobs!'
                        when ROW_NUMBER() over(order by score desc) <=8 then 'not yet mature'
                        else 'rotten egg'
                    END as emblem";
          return DB::raw("{$selectQuery}, ROW_NUMBER() OVER(order by score desc) as ranking,{$emblem}");
        }
    protected function scopeLobbyInfo(){
                $queriSelectColumn='name,avatar,score';
            $datas=DB::table('users')
                    ->select($this->RankingUserInfo($queriSelectColumn))->limit(10)->get();
                return $datas ;
    }
    protected function scopeTop3PlayerInfo(){
            $queriSelectColumn='name,avatar,score';
        $datas=DB::table('users')
                ->select($this->RankingUserInfo($queriSelectColumn))->limit(3)->get();
                return $datas ;
    }

    protected function scopeUserInformation(){
            $queriSelectColumn='username,name,avatar,country,status,gender,user_conections,score,ROW_NUMBER() OVER(order by score desc) as ranking';
        $datas=DB::table('users')
                ->select($this->RankingUserInfo($queriSelectColumn))->get();
                return $datas ;
    }
}
