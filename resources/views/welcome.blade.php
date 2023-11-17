<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Creditaco</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('css/app/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
@routes
<div id="root">
    <app-vue></app-vue>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
