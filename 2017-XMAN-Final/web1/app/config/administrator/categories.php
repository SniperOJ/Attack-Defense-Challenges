<?php

return [

    'title' => lang('Category'),
    'single' => lang('Category'),
    'model' => 'Category',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => lang('Name'),
        ],
        'slug' => [
            'title' => lang('Slug (use for URI)'),
            'sortable' => false,
        ],
        'created_at',
    ],

    'edit_fields' => [
        'name' => [
            'title' => lang('Name'),
            'type' => 'text'
        ],
        'slug' => [
            'title' => lang('Slug (use for URI)'),
            'type' => 'text'
        ]
    ],

    'filters' => [
        'name' => [
            'title' => lang('Name'),
        ]
    ],


];
