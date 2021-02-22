@extends('_partials.master')

@section('meta')
    <meta name="description" content="{{$meta_description}}">
@stop

@section('title') {{$course->name}} Tutorial @parent @stop

@section('stylesheets')
@stop

@section('scripts')
@stop

@section('content')

    <main class="courses-section" >
        <section class="header-section content-parent" @if($course->mediaFilesMain->isNotEmpty()) style='background-image: url("/images/{!! $course->mediaFilesMain->pluck('url')[0] !!}?w=1000&fit=contain&filt=greyscale")' @endif>
            <div class="background-color" style="
                    background: linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -moz-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -o-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -webkit-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    ">
            </div>
            <div class="heading-inner-container content">
                <h1>{!! $course->name !!} Tutorial</h1>
                @if($course->description)
                    <div class="course-description">
                        {!! $course->description !!}
                    </div>
                @endif
            </div>
        </section>

        <section class="tutorial-content content-parent" >

            <div class="list-container content">

                <ol class="chapters-list">
                @foreach($course->publicChapters as $index => $chapter)
                    <li class=" chapter-option">
{{--                    <li class="{{\App\Libraries\StatusChecker::checkStatus($chapter->completion_percentage)}} chapter-option">--}}
                        <span class="option" >
                            <span class="course-number">
{{--                                {{\App\Libraries\NumericLib::numberToRomanRepresentation($index+1)}}--}}
                            </span>
                            <div class="top-level" >
                                <h2>{!! $chapter->name !!}</h2>
                                <span class="line-completion-indicator" style="width: {{$chapter->completion_percentage ?? 0}}%;"></span>
                                <span class="dot-completion-indicator" style="left: {{$chapter->completion_percentage ?? 0}}%;"></span>
                                <span class="route">
                                    <span class="inner-route"></span>
                                </span>
                                @if(isset($status_chapters[$chapter->id])&& $status_chapters[$chapter->id] > 0)
                                    <span class="completion-percentage" >{{$status_chapters[$chapter->id]}}%</span>
                                @endif
                            </div>
                        </span>
                        @if($chapter->publicLessons)
                        <section class="lessons-container">

                            <div class="lesson-choosing">
                                @foreach($chapter->publicLessons as $index => $lesson)
                                    <article class="option-container">
                                        <a href="/{{$course->slug.'/'.$chapter->slug.'/'.$lesson->slug}}" class="option" >
                                            <header class="top-txt" >
                                                <h2>{!! $lesson->name !!}</h2>
                                            </header>
                                            @if(isset($status_lessons[$lesson->id])&&$status_lessons[$lesson->id] > 0)
                                                <span class="lesson-completion">@if($status_lessons[$lesson->id] == 100)<i class="fas fa-check"></i>@else{{$status_lessons[$lesson->id]}}%@endif</span>
                                            @endif
                                            <footer class="go-link" >
                                            <span class="lesson-number">
{{--                                                {{\App\Libraries\NumericLib::numberToRomanRepresentation($index+1)}}--}}
                                            </span>
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </footer>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                        @endif
                    </li>
                @endforeach
                </ol>
            </div>

        </section>

    </main>

@stop
