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
        for ($i=0; $i <= 10; $i++) {
            DB::table('users')->insert([
                'username' =>"admin{$i}",
                'name' =>"admin{$i}",
                'score' =>0,
                'user_conections' =>'offline',
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
