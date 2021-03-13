<nav id="main_navigation">

    <div class="nav-inner">
        <a href="/" class="logo-txt">
            <span class="red">Red</span><span class="tutorial">Tutorial</span>
        </a>

        <div class="trigger-sidebar" ></div>

        <ul class="navigation-links">
            @foreach($courses as $course)
                <li>
                    <a class=" option @if(url()->current() === url('/'.$course->slug)) active @endif" href="/{{$course->slug}}">
                        {{$course->name}} Tutorial
                    </a>
                </li>
            @endforeach
            @if($user_logged)
                <li><a href="/profile" class=" option @if(url()->current() === url('/profile')) active @endif" ><i class="far fa-user-circle"></i> {{$user_first_name}}</a></li>
            @else
                <li><a href="/register" class=" option @if(url()->current() === url('/register')) active @endif" >Register / Login</a></li>
            @endif
            <li><a href="/contact-us" class="option @if(url()->current() === url('/contact-us')) active @endif" >Contact Us</a></li>
            <li class="display-inline-block" ><a href="https://twitter.com/_redtutorial" aria-label="Twitter" target="_blank" rel="noopener" class="twitter-account option" ><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
</nav>
