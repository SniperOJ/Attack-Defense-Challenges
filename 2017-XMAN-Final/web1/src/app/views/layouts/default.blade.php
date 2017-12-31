<!doctype html>
<html class="no-js">

  <head>
    <meta charset="utf-8">
    <title>@section('title')Baby Blog @show</title>
    <meta name="keywords" content="@section('keywords') Baby,Blog @show" />
    <meta name="description" content="@section('description') Baby Blog is a blog application written for XMan 2017 A&D game. @show">

    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="/favicon.ico">

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/styles/bootstrap.css">
    <link rel="stylesheet" href="/assets/styles/main.css">

    <script>
        Config = {
            'cdnDomain': '{{ getCdnDomain() }}',
            'user_id': {{ $currentUser ? $currentUser->id : 0 }},
            'routes': {
            },
            'token': '{{ csrf_token() }}',
        };
    </script>

    @yield('styles')

  </head>

  <body>
    <!--[if lt IE 10]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="container main">

        @include('layouts.partials.topnav')

        @include('flash::message')

        <div class="content">

            @yield('content')
        </div>

        <div class="footer">
            <p>
                <span class="glyphicon glyphicon-heart"></span> L0ve XMan
                <span class="pull-right">
                    <i class="fa fa-github" style="font-size:15px"></i> <a href="https://github.com/summershrimp" target="_blank">Guess Who</a>.
                </span>
            </p>
        </div>

    </div>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.js"></script>

    <script src="/assets/scripts/jquery.pjax.js"></script>
    <script src="/assets/scripts/jquery.scrollUp.js"></script>
    <script src="/assets/scripts/nprogress.js"></script>
    <script src="/assets/scripts/main.js"></script>

    @yield('scripts')

</body>
</html>
