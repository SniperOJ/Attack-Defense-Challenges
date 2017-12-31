<?php

class BaseController extends Controller {

	public function __construct()
    {

    }

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

        View::share('currentUser', Auth::user());
	}

    public function authorOrAdminPermissioinRequire($author_id)
    {
        if (! Entrust::can('manage_contents') && $author_id != Auth::user()->id)
        {
            App::abort(403, 'Unauthorized action.');
        }
    }
}
