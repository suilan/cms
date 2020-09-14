<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @if(View::hasSection('title'))
            @yield('title')
        @else
            Cartórios de Protesto MA
        @endif 
    </title>
    <link rel="stylesheet" href="{{asset('default/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('default/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('ieptbma/css/template-ieptbma.css')}}" />
    <link rel="stylesheet" href="{{asset('ieptbma/css/remodal.css')}}" />
    <link rel="stylesheet" href="{{asset('ieptbma/css/remodal-default-theme.css')}}" />
    @yield('styles')
    @yield('metas')
    
    <link rel="icon" href="{{asset('ieptbma/img/favicon.png')}}">
<!--    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=.1" />-->
    <meta name="viewport" content="width=device-width, user-scalable=no" />
</head>
