<?php

class Category extends \Eloquent
{
	protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->hasMany('Post');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
