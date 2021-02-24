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
            <x-client.random-gradient-container :classes="'background-color'"></x-client.random-gradient-container>
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
                    <x-client.chapter-status-wrapper :status="$status_chapters[$chapter->id] ?? 0">
                        <x-slot name="chapter_content">
                            <span class="option" >
                                <span class="course-number">
                                    <x-client.number-to-roman-number :number="$index+1"></x-client.number-to-roman-number>
                                </span>
                                <div class="top-level" >
                                    <h2>{!! $chapter->name !!}</h2>
                                    <span class="line-completion-indicator" style="width: {{$status_chapters[$chapter->id] ?? 0}}%;"></span>
                                    <span class="dot-completion-indicator" style="left: {{$status_chapters[$chapter->id] ?? 0}}%;"></span>
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
                                                    <x-client.number-to-roman-number :number="$index+1"></x-client.number-to-roman-number>
                                                </span>
                                                        <i class="fas fa-chevron-circle-right"></i>
                                                    </footer>
                                                </a>
                                            </article>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        </x-slot>
                    </x-client.chapter-status-wrapper>
                @endforeach
                </ol>
            </div>

        </section>

    </main>

@stop
