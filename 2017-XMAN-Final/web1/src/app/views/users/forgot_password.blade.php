@extends('layouts.default')

@section('title')
{{ lang('Forget Password') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('Settings') }}</h3>
    <form method="POST" action="{{ URL::to('/users/forgot_password') }}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <div class="input-append input-group">
                <input class="form-control" placeholder="{{ lang('Your Registered Email') }}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                <span class="input-group-btn">
                    <input class="btn btn-primary" type="submit" value="{{ lang('Submit') }}">
                </span>
            </div>
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
    </form>
</div>
@stop
