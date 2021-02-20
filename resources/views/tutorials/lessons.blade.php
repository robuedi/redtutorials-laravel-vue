@extends('_partials.master')

@section('meta')
    <meta name="description" content="{{$meta['description']}}">
    <link rel="canonical" href="https://redtutorial.com/{{$chapter->course_slug}}" />           
@stop

@section('title') {{$chapter->course_name.' '.$chapter->chapter_name}} @parent @stop

@section('stylesheets')
@stop

@section('scripts')
@stop

@section('content')

    <main class="chapters-section" >
        <section class="header-section" @if($course_image) style='background-image: url("/images/{{$course_image->url}}?w=1000&fit=contain&filt=greyscale")' @endif>
            <div class="subtitle">
                <p class="inner-container">
                    <a href="/{{$chapter->course_slug}}"><i class="fas fa-angle-left"></i> Chapters</a>
                </p>
            </div>
            <div class="heading-inner-container">
                <h1>
                    <span class="course">{!! $chapter->course_name !!}</span>
                    {!! $chapter->chapter_name !!}
                </h1>
            </div>
        </section>

        <section class="lessons-container">

            <div class="lesson-choosing">
                @foreach($lessons as $index => $lesson)
                    <article class="option-container">
                        <a href="/{{$chapter->course_slug.'/'.$chapter->chapter_slug.'/'.$lesson->slug}}" class="option" >
                            <header class="top-txt" >
                                <h2>{!! $lesson->name !!}</h2>
                            </header>
                            @if($lesson->completion_status&&$lesson->completion_status > 0)
                                <span class="lesson-completion">@if($lesson->completion_status == 100)<i class="fas fa-check"></i>@else{{$lesson->completion_status}}%@endif</span>
                            @endif
                            <footer class="go-link" >
                                <span class="lesson-number">
                                    {{\App\Libraries\NumericLib::numberToRomanRepresentation($index+1)}}
                                </span>
                                <i class="fas fa-chevron-circle-right"></i>
                            </footer>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

@stop