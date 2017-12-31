@extends('layouts.default')

@section('title')
{{ lang('Login') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('User Login') }}</h3>
    <form method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        @if (Session::get('error'))
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-group">
            <input class="form-control" tabindex="1" placeholder="{{{ lang('Email OR Username') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <input class="form-control" tabindex="2" placeholder="{{{ lang('password') }}}" type="password" name="password" id="password" value="{{{ Input::old('password') }}}">
        </div>
        <div class="checkbox">
            <label>
              <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> {{ lang('Remember') }}
            </label>
        </div>
        <div class="form-group">
            <button tabindex="3" type="submit" class="btn btn-default">{{{ lang('Submit') }}}</button>
            <small>
                <a href="{{{ URL::to('/users/forgot_password') }}}">{{{ lang('forget password?') }}}</a>
            </small>
        </div>
    </form>
</div>
<div class="clearfix"></div>
@stop
