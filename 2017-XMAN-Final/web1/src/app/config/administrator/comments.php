<?php

return [

    'title' => lang('Comment'),
    'single' => lang('Comment'),
    'model' => 'Comment',

    'action_permissions'=> [
        'delete' => function($model)
        {
            return true;
        },
        'create' => function($model)
        {
            return false;
        }
    ],

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'body' => [
            'title' => lang('Body'),
            'sortable' => false,
        ],
        'user_name' => [
            'title' => lang("Author"),
            'relationship' => 'user', //this is the name of the Eloquent relationship method!
            'select' => "(:table).username",
        ],
        'post_title' => [
            'title' => lang("Post Title"),
            'relationship' => 'post',
            'select' => "(:table).title",
        ],
    ],

    'edit_fields' => [
        'body' => [
            'title' => lang('Body'),
            'type' => 'text'
        ],
    ],

    'filters' => [
        'body' => [
            'title' => lang('Body'),
        ]
    ],

];
