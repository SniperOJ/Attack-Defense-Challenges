<?php

use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
            $word = $faker->word;
			Category::create([
                'name' => $word,
                'slug' => $word . $index,
			]);
		}
	}

}
