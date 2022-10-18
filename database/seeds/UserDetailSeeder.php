<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\UserDetail;
use App\User;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( Faker $faker)
    {
       
        $user_ids = User::pluck('id')->toArray();

        foreach($user_ids as $id){
            $new_user_detail = new UserDetail();

            $new_user_detail->user_id = $id;
            $new_user_detail->paypal = $faker->email();
            $new_user_detail->residence = $faker->address();
            $new_user_detail->phone = $faker->phoneNumber();
            $new_user_detail->language = $faker->text(25);

            $new_user_detail->save();
        }
    }
}