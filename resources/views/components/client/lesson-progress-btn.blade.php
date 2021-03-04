@if($type === 'quiz')
    <span title="Quiz" class="@if($status === 2) pre-active @elseif($status === 1) active @endif quiz-sign">
        <i>?</i>
    </span>
@elseif($type === 'text')
    <span @if(!empty($name)) title="{{$name}}" @endif class="@if($status === 2) pre-active @elseif($status === 1) active @endif text-sign">
        <i class="fas fa-caret-right"></i>
    </span>
@endif
