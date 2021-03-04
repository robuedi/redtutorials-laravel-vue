@extends('_partials.master')

@section('content')

    <main class="page-content"  >

        <section class="top-section content-parent" style='background-image: url("/images/assets/img/contact_us.jpg?w=1200&fit=contain")'>
            <div class="default-background-color"></div>
            <h1 class="content default-page-header">@yield('main_header')</h1>
        </section>

        <section class="main-section content-parent">
            <div class="content @yield('content_classes')">
                @yield('main_content')
            </div>
        </section>
    </main>

@stop