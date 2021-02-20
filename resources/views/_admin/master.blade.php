<!DOCTYPE html>
<html lang="en-us">
    @include('_admin.master_inc.head')
    <body class="{{config('theme.custom.body')}}">
        <x-admin.header></x-admin.header>
        <x-admin.nav></x-admin.nav>
        @include('_admin.master_inc.main')
        @include('_admin.master_inc.footer')
        @include('_admin.master_inc.scripts')
    </body>
</html>
