@extends('layouts.default')

@section('title')
{{ lang('Register') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('Create new account') }}</h3>
    <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Email') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Password Confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ lang('Submit') }}}</button>
        </div>
    </form>
</div>
<div class="clearfix"></div>
@stop
