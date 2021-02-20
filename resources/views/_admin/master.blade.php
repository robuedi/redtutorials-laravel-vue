<!DOCTYPE html>
<html lang="en-us">
    @include('_admin.master_inc.head')
    <body class="{{config('theme.custom.body')}}">
        @include('_admin.master_inc.header')
        @include('_admin.master_inc.nav', array('config_menu' => \App\Services\Menu\MenuAdmin::getMenu()))
        @include('_admin.master_inc.main')
        @include('_admin.master_inc.footer')
        @include('_admin.master_inc.scripts')
    </body>
</html>
