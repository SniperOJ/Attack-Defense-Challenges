<?php

class TagsController extends \BaseController
{
	public function show($slug)
	{
        $tag = Tag::whereNormalized($slug)->first();
        $posts = $tag->posts()->recent()->paginate(10);

        return View::make('posts.index', compact('tag', 'posts'));
	}
}
