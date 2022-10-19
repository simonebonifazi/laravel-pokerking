<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('admins');
        foreach($users as $user){

            $new_user = new User();
            
            $new_user->name = $user['name'];
            $new_user->email = $user['email'];
            $new_user->password = bcrypt("password");
            
            $new_user->save();
        }
        
       
    }
}