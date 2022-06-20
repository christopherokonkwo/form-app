<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} ― Dashboard</title>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Karla&family=Merriweather:wght@400;700&display=swap">

    @if(enabledDarkMode($jsVars['user']['dark_mode']))
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.5.0/build/styles/sunburst.min.css">
    @else
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.5.0/build/styles/github.min.css">
    @endif

    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.5.0/build/highlight.min.js"></script>
</head>
<body class="mb-5" @if(enabledDarkMode($jsVars['user']['dark_mode'])) data-theme="dark" @endif @if(usingRightToLeftLanguage($jsVars['user']['locale'])) data-lang="rtl" @endif>


    <div id="dashboard">
        <router-view></router-view>
    </div>

    <script>
        window.Dashboard = @json($jsVars);

    </script>

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
