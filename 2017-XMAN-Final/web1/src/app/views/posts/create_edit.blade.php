@extends('layouts.default')

@section('title')
    @if (isset($post))
        {{ lang('Edit Post') }} - @parent
    @else
        {{ lang('Create Post') }} - @parent
    @endif
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="/assets/editor/simditor.css" />
    <link rel="stylesheet" type="text/css" href="/assets/editor/jquery.tagsinput.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/editor/simditor-emoji.css" />
@stop

@section('content')

    @include('layouts.partials.errors')

    @if (isset($post)) {{ Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) }}
    @else {{ Form::open(['route' => 'posts.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
      {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => lang('Title goes here')]) }}
    </div>

    <div class="form-group">
      {{ Form::select('category_id', $category_selects , Input::old('category_id'), ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::select('template', Array("1.tpl"=>"Template 1","2.tpl"=>"Template 2","3.tpl"=>"Template 3") , Input::old('template'), ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
      {{ Form::text('tags', isset($post) ? $post->tagList : null, ['class' => 'form-control', 'style' => "width: 100%; height: 45px;"]) }}
    </div>

    <div class="form-group">
      {{ Form::textarea('body', null, ['class' => 'form-control',
                                        'rows' => 20,
                                        'style' => "overflow:hidden",
                                        'id' => 'editor',
                                        'autofocus' => 'autofocus',
                                        'placeholder' => lang('Please Enter some text...')]) }}
    </div>

    <div class="form-group status-post-submit">
        {{ Form::submit(lang('Publish'), ['class' => 'btn btn-primary', 'id' => 'topic-create-submit']) }}

        @if (isset($post))
            <a class="btn btn-default" href="{{ route('posts.show', $post->id) }}" target="_blank">{{ lang('view original article') }}</a>
        @endif
    </div>

    {{ Form::close() }}

@stop

@section('scripts')
    <script type="text/javascript" src="{{ cdn('/assets/editor/simditor-all.js') }}"></script>
    <script type="text/javascript" src="{{ cdn('/assets/editor/marked.js') }}"></script>
    <script type="text/javascript" src="{{ cdn('/assets/editor/simditor-marked.js') }}"></script>
    <script type="text/javascript" src="{{ cdn('/assets/editor/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn('/assets/editor/simditor-emoji.js') }}"></script>

    <script>

    $(document).ready(function(){
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('posts.upload_image') }}',
                params: null,
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: 'File uploading, will be cancel if you leave the page.'
            },
            pasteImage: true,
            defaultImage: "/assets/editor/no-preview.jpg",
            toolbar: ['bold', 'italic', 'underline', 'strikethrough', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'indent', 'outdent', 'marked', 'emoji'],
            emoji: {
                imagePath: '/assets/editor/images/emoji/'
            }
        });

        $('input[name="tags"]').tagsInput({
            maxTags: 5,
            trimValue: true,
            allowDuplicates: false
        });

    });

    </script>

@stop
