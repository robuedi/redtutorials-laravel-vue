@extends('_partials.standard_page')

@section('meta')
    <meta name="description" content="Feedback message">
@stop

@section('title') {{$title}} @parent @stop

@section('main_header') {{$title}}  @stop

@section('main_content')

    <p class="info-paragraph txt-lg">
        {!! $msg !!}
    </p>

@stop


