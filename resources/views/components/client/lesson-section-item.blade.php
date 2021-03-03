<div data-text="{{$lesson_sections_status[$lesson_section->id]}}" class="lesson-container @if($lesson_sections_status[$lesson_section->id] === 1) active @endif" @if($lesson_section->type === 'quiz' && $lesson_section->publicLessonSectionOptions->isNotEmpty()) data-type="q" @else data-type="t" @endif>
   {{$lesson_section_content}}
</div>
