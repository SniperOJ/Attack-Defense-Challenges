<?php

use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();

        $users = User::lists('id');
        $categories = Category::lists('id');

		foreach(range(1, 100) as $index)
		{
			Post::create([
                'title'         => $faker->sentence(),
                'slug'          => $faker->slug() . $index,
                'body'          => $faker->text(),
                'user_id'       => $faker->randomElement($users),
                'category_id'   => $faker->randomElement($categories),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
			]);
		}
	}
}
