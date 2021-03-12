@extends('_partials.master')

@section('meta')
    <meta name="description" content="@lang('home.meta_desription')">
    <link rel="home" href="{{ url()->current() }}" />
@stop

@section('title') Step by step tutorials @parent @stop

@section('stylesheets')
@stop

@section('body_class') body-home @stop

@section('content')
    <homepage></homepage>
@stop
