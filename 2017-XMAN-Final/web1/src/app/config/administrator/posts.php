<?php

return [

    'title' => lang('Post'),
    'single' => lang('Post'),
    'model' => 'Post',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'title' => [
            'title' => lang('Title'),
        ],
        'body' => [
            'title' => lang('Content'),
            'sortable' => false,
            'output' => function($value)
            {
                return make_excerpt($value);
            },
        ],
        'user_name' => [
            'title' => lang("Author"),
            'relationship' => 'user', //this is the name of the Eloquent relationship method!
            'select' => "(:table).username",
        ],
        'category_name' => [
            'title' => lang("Category"),
            'relationship' => 'category', //this is the name of the Eloquent relationship method!
            'select' => "(:table).name",
        ],
        'comments_count' => [
            'title' => 'Comments Count'
        ],
        'created_at',
    ],

    'edit_fields' => [
        'title' => [
            'title' => lang('Title'),
            'type' => 'text'
        ],
        'category' => array(
            'type' => 'relationship',
            'title' => lang('Category'),
            'name_field' => 'name',
        )
    ],

    'filters' => [
        'title' => [
            'title' => lang('Title'),
        ]
    ],

    'link' => function($model)
    {
        return URL::route('posts.edit', $model->id);
    },


];
