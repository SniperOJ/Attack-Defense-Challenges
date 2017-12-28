<?php

return [

    'title' => lang('User'),
    'single' => lang('User'),
    'model' => 'User',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'username' => [
            'title' => lang('User Name'),
        ],
        'display_name' => [
            'title' => lang('Display Name'),
        ],
        'email' => [
            'title' => lang('Email'),
        ],
        'created_at',
    ],

    'edit_fields' => [
        'username' => [
            'title' => lang('User Name'),
            'type' => 'text'
        ],
        'display_name' => [
            'title' => lang('Display Name'),
            'type' => 'text'
        ],
        'email' => [
            'title' => lang('Email'),
            'type' => 'text'
        ],
        'password' => [
            'title' => lang('Password'),
            'type' => 'password'
        ],
    ],

    'filters' => [
        'id' => [
            'title' => lang('User ID'),
        ],
        'username' => [
            'title' => lang('User Name'),
        ],
        'display_name' => [
            'title' => lang('Display Name'),
        ],
        'email' => [
            'title' => lang('Email'),
        ],
    ],
];
