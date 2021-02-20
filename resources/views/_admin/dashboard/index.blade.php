@extends('_admin.master')

@section('title') Dashboard @parent @stop


@section('breadcrumbs')
    <li><a href="{{URL::to('/'.config('app.admin_route'))}}">Home</a></li>
    <li>Dashboard</li>
@stop

@section('scripts')
    <script src="/assets/_admin/js/tree-view-section.js"></script>
@stop

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/assets/_admin/css/tree-view-section.css">
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-calendar fa-fw "></i>
                Dashboard
            </h1>
        </div>
    </div>

{{--    {!! \App\Libraries\UIMessage::get() !!}--}}

    <section id="widget-grid" class="">

        <div class="row">

            <div class="col-md-6">
                <div class="jarviswidget" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>@lang('admin_dashboard.courses_numbers')</h2>
                    </header>

                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <div class="table-responsive">

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" >#</th>
                                            <th>Category</th>
                                            <th>Public</th>
                                            <th>Draft</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="txt-color-green">
                                            <td class="text-center" ><h3>1.</h3></td>
                                            <td>
                                                <h3 >
                                                    <a class="editable-click txt-color-green" href="/{{config('app.admin_route')}}/courses">Courses</a>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click txt-color-green" href="/{{config('app.admin_route')}}/courses?is_public=1">{{$public_courses}}</a>
                                                    <small>({{abs($public_courses-$total_courses)}})</small>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click txt-color-green" href="/{{config('app.admin_route')}}/courses?is_draft=1">{{$draft_courses}}</a>
                                                    <small>({{abs($draft_courses-$total_courses)}})</small>
                                                </h3>
                                            </td>
                                            <td><h3>{{$total_courses}}</h3></td>
                                        </tr>
                                        <tr class="txt-color-magenta">
                                            <td class="text-center" ><h3>2.</h3></td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click txt-color-magenta" href="/{{config('app.admin_route')}}/chapters">Chapters</a>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click txt-color-magenta" href="/{{config('app.admin_route')}}/chapters?is_public=1">{{$public_chapters}}</a>
                                                    <small>({{abs($public_chapters-$total_chapters)}})</small>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click txt-color-magenta" href="/{{config('app.admin_route')}}/chapters?is_draft=1">{{$draft_chapters}}</a>
                                                    <small>({{abs($draft_chapters-$total_chapters)}})</small>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>{{$total_chapters}}</h3>
                                            </td>
                                        </tr>
                                        <tr class="text-primary">
                                            <td class="text-center" ><h3>3.</h3></td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click text-primary" href="/{{config('app.admin_route')}}/lessons">Lessons</a>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click text-primary" href="/{{config('app.admin_route')}}/lessons?is_public=1">{{$public_lessons}}</a>
                                                    <small>({{abs($public_lessons-$total_lessons)}})</small>
                                                </h3>
                                            </td>
                                            <td>
                                                <h3>
                                                    <a class="editable-click text-primary" href="/{{config('app.admin_route')}}/lessons?is_draft=1">{{$draft_lessons}}</a>
                                                    <small>({{abs($draft_lessons-$total_lessons)}})</small>
                                                </h3>
                                            </td>
                                            <td><h3>{{$total_lessons}}</h3></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
            </div>

            <div class="col-md-6">
                <x-admin.admin-courses-map></x-admin.admin-courses-map>
            </div>

        </div>

    </section>

@stop
