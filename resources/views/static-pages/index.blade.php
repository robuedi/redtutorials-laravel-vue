@extends('_partials.master')

@section('meta')
    <meta name="description" content="{{$page->meta_description}}">
@stop

@section('title') {{$page->head_title}} @parent @stop

@section('stylesheets')
@stop

@section('scripts')
@stop

@section('content')

    <main id="static_page" >
        <header>
            <h1>{{$page->heading}}</h1>
        </header>
        <section class="contenta">
            {!! $page->content !!}
        </section>

    </main>

@stop

