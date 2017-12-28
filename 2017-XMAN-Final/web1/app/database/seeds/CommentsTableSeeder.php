<?php

use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();

        $users = User::lists('id');
        $posts = Post::lists('id');

		foreach(range(1, 100) as $index)
		{
			Comment::create([
                'body' => $faker->sentence(),
                'user_id' => $faker->randomElement($users),
                'post_id' => $faker->randomElement($posts),
			]);
		}
	}

}
