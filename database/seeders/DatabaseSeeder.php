<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
        

    public function run()
    {
        $randomize=fn(array $arrayData)=>$arrayData[array_rand($arrayData)];
        // \App\Models\User::factory(10)->create();
        for ($i=1; $i <= 100; $i++) {
            DB::table('users')->insert([
                'username' =>"admin{$i}",
                'name' =>"admin{$i}",
                'score' =>\rand(0,500),
                'user_conections' =>$randomize(['offline','online']),
                'gender' =>$randomize(['male','female']),
                'status' =>$randomize(['i am ok thank kyu!!','better run!','runing into the night']),
                'country' =>$randomize(['indonesia','japan','rusia','malaysia','china','north korea']),
                'avatar' =>null,
                'email' =>"admin{$i}@gmail.com",
                'password' => Hash::make("admin{$i}"),
            ]);
        }
    }
}
