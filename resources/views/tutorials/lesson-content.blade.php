@extends('_partials.master')

@section('meta')
    <meta name="description" content="{{$meta_description}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('title') {{$lesson->course_name.' Tutorial: '.$lesson->lesson_name}} @parent @stop

@section('scripts')
@stop

@section('content')
    <main class="lesson-main-container">

        <section class="header-section content-parent" style='background-image: url("/images/{{$lesson->publicChapter->publicCourse->mediaFilesMain->first()->url}}?w=1000&fit=contain&filt=greyscale")'>
            <x-client.random-gradient-container :classes="'background-color'"></x-client.random-gradient-container>
            <div class="heading-inner-container content">
                <h1>
                    <small>{!! $lesson->publicChapter->publicCourse->name !!} Tutorial </small>
                    {!! $lesson->name !!}
                </h1>
            </div>
        </section>

        <section class="tutorial-container content-parent" id="lessons_content" data-role="lessons-content">
            <div class="content">

                @if(!$user)
                    <p class="register-here-label"><a class="link" href="/user/sign-in">Register here</a> to save your progress</p>
                @endif

                <div class="lesson-progress-container"  >
                    <div class="lesson-progress" data-role="lesson-progress">
                        @foreach($lesson->publicLessonSections as $index => $lesson_section)
                            <x-client.lesson-progress-btn :id="(int)$lesson_section->id" :name="$lesson_section->name" :type="$lesson_section->type" :progress="$lesson_sections_progress" ></x-client.lesson-progress-btn>
                        @endforeach
                    </div>
                </div>
                <div class="lessons-list" id="lessons_list" data-role="lessons-list">
                    @foreach($lesson->publicLessonSections as $index => $lesson_section)
                        <div data-text="{{$lesson_sections_progress->getFor($lesson_section->id)}}" class="lesson-container @if($lesson_section_status->checkCurrentlyActive($lesson_section->id)) active @endif" @if($lesson_section->type === 'quiz' && $lesson_section->publicLessonSectionOptions->isNotEmpty()) data-type="q" @else data-type="t" @endif>
                            @if(!empty($lesson_section->name))
                                <h2>{!! $lesson_section->name !!}</h2>
                            @endif
                            {!! $lesson_section->content !!}

                            @if($lesson_section->type === 'quiz' && $lesson_section->publicLessonSectionOptions->isNotEmpty())
                            <div class="quiz-form" data-quiz="{{$lesson_section->id}}">
                                @foreach($lesson_section->publicLessonSectionOptions as $quiz_answer)
                                        <label class="input-container">
                                            <input name="quiz_{{$lesson_section->id}}" type="{{$lesson_section->options_type}}" value="{{$quiz_answer->value}}">
                                            <div class="input-label">
                                                <span class="input-selection"></span>
                                                {{$quiz_answer->label}}
                                            </div>
                                        </label>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endforeach
                    <button type="button" class="lesson-nav-btn prev-load"><i class="fas fa-chevron-left"></i></button>
                    @if($next_lesson)
                        <button type="button" data-next-lesson="/{{$lesson->publicChapter->publicCourse->slug.'/'.$lesson->publicChapter->slug.'/'.$next_lesson->slug}}" class="lesson-nav-btn next-load">Next</button>
                    @else
                        <button type="button" data-next-lesson="/{{$lesson->publicChapter->publicCourse->slug}}" class="lesson-nav-btn next-load">Next</button>
                    @endif
                </div>
            </div>
        </section>
    </main>

@stop
