@extends('_partials.master')

@section('meta')
    <meta name="description" content="{{$meta['description']}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('title') {{$lesson->course_name.' Tutorial: '.$lesson->lesson_name}} @parent @stop

@section('scripts')
@stop

@section('content')
    <main class="lesson-main-container">

        <section class="header-section content-parent" @if($course_image) style='background-image: url("/images/{{$course_image->url}}?w=1000&fit=contain&filt=greyscale")' @endif>
            <div class="background-color" style="
                    background: linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -moz-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -o-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    background: -webkit-linear-gradient(to left top , rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7), rgba({{rand(200, 255).', '.rand(200, 255).', '.rand(200, 255)}},0.7));
                    ">
            </div>
            <div class="heading-inner-container content">
                <h1>
                    <small>{!! $lesson->course_name !!} Tutorial </small>
                    {!! $lesson->lesson_name !!}
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
                        @foreach($lesson_sections as $index => $lesson_section)
                            @if($lesson_section->type == 'quiz')
                                <span title="Quiz" class="@if($lesson_section->completion_status == 1) active @elseif($lesson_section->completion_status == 2) pre-active @endif quiz-sign"><i>?</i></span>
                            @elseif($lesson_section->type == 'text')
                                <span @if(!empty($lesson_section->name)) title="{{$lesson_section->name}}" @endif class="@if($lesson_section->completion_status == 1) active @elseif($lesson_section->completion_status == 2) pre-active @endif text-sign"><i class="fas fa-caret-right"></i></span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="lessons-list" id="lessons_list" data-role="lessons-list">
                    @foreach($lesson_sections as $index => $lesson_section)
                        <div data-text="{{$lesson_section->completion_status}}" class="lesson-container @if($lesson_section->completion_status == 1) active @endif" @if($lesson_section->type == 'quiz' && isset($quiz_answers[$lesson_section->id])) data-type="q" @else data-type="t" @endif>
                            @if(!empty($lesson_section->name))
                                <h2>{!! $lesson_section->name !!}</h2>
                            @endif
                            {!! $lesson_section->content !!}

                            @if($lesson_section->type == 'quiz' && isset($quiz_answers[$lesson_section->id]))
                            <div class="quiz-form" data-quiz="{{$lesson_section->id}}">
                                @foreach($quiz_answers[$lesson_section->id] as $quiz_answer)
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
                    <button type="button" data-next-lesson="/{{$lesson->course_slag}}" class="lesson-nav-btn next-load">Next</button>
                </div>
            </div>
        </section>
    </main>

@stop
