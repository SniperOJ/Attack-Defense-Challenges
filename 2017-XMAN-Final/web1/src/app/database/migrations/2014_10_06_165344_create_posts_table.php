<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->index();
			$table->string('slug')->unique();
            $table->string('template')->default("1.tpl");
			$table->text('body');
			$table->text('body_original')->nullable();
			$table->integer('user_id')->index();
			$table->integer('category_id')->index();
			$table->integer('comments_count')->index()->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
