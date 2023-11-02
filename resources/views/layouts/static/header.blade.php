<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    @include('layouts.components.styles')

    <title>{{setting('speed_site_title'). ' | '}} @yield('title')</title>
    <meta name="description" content="@yield('description')">

</head>
<body>
    @include('layouts.menu.top')

