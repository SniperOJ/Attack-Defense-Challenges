<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 50) as $index)
        {
            $user = new User;
            $user->username     = $faker->userName()  . $index;
            $user->email        = $faker->email() . $index;
            $user->display_name = $user->username;
            $user->confirmed    = true;
            $user->password     = 'admin';
            $user->password_confirmation = 'admin';
            $user->confirmation_code = md5(uniqid(mt_rand(), true));

            if(! $user->save()) {
              Log::info('Unable to create user '.$user->username, (array)$user->errors());
            } else {
              Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
            }
        }
    }
}
