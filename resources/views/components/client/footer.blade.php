<footer id="footer-container">
    <ul class="footer-links">
        @foreach($static_menu as $page)
            <li>
                <a href="/info/{{$page->slug}}" class="@if(url()->current() === url('/info/'.$page->slug)) active @endif" >{{$page->name}}</a>
            </li>
        @endforeach
    </ul>
    <p class="copyright-container">
        Copyright &copy; 2019 RedTutorial.com
    </p>
</footer>
