@extends('layouts.default')

@section('title')
{{ lang('User Profile') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('Update Profile') }}</h3>
    {{ Form::model($currentUser, ['route' => ['users.update', $currentUser->id], 'method' => 'patch']) }}
        @include('layouts.partials.errors')
        <div class="form-group">
            <label for="display_name">{{ lang('Display Name:') }}</label>

           {{ Form::text('display_name', Input::old('display_name') ? : null, ['class' => 'form-control', 'placeholder' => lang('Add your display name')]) }}
        </div>
        <hr>
        <div class="form-group">
            <button tabindex="3" type="submit" class="btn btn-primary">{{ lang('Update') }}</button>
        </div>
    {{ Form::close() }}
</div>
<div class="clearfix"></div>
@stop
