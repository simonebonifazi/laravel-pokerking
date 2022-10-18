<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = new User();

        $user->name = "simo admin";
        $user->email = "iamsimonebonifazi@gmail.com";
        $user->password = bcrypt("originalpwd");
        
        $user->save();
        
        for($i = 0; $i < 9; $i++)
        {
            $user = new User();
            $user->name = $faker->firstName();
            $user->email = $faker->email();
            $user->password = bcrypt("personalpassword");
            $user->save();
        }
    }
}