@extends('_partials.standard-page')

@section('meta')
    <meta name="description" content="User Profile">
@stop

@section('title') Profile @parent @stop

@section('main_header') {{$user->first_name.' '.$user->last_name}} @stop

@section('content_classes') text-center user-profile @stop

@section('main_content')

    <section class="choose-action" data-role="choose-action">
        <div>
            <h2 class="active" data-action="progress">
                Progress
            </h2>
            <h2 data-action="profile-info">
                Profile Info
            </h2>
        </div>
    </section>

    <form class="section-container form-item profile-info-content inactive" data-role="choose-action-container" data-type="profile-info" enctype="application/x-www-form-urlencoded" action="/profile/update-profile" method="POST">
        {{ csrf_field() }}
        <section class="form-input">
            <label>First name <span class="required-status"></span></label>
            <input type="text" name="first_name"  value="{{old('first_name', $user->first_name)}}">
        </section>

        <section class="form-input">
            <label>Last name <span class="required-status"></span></label>
            <input type="text" name="last_name"  value="{{old('last_name', $user->last_name)}}">
        </section>

        <section class="form-input">
            <label>Email <span class="required-status"></span></label>
            <input type="text" name="email" value="{{old('email', $user->email)}}">
        </section>

        <h4 class="password-main-label" data-self-add-class="active" >Update password</h4>
        <section class="password-change-section">
            <section class="form-input">
                <label>Old password <span class="required-status"></span></label>
                <input type="password" name="old_password" autocomplete="off">
            </section>

            <section class="form-input">
                <label>New password <small>(minimum 6 characters)</small><span class="required-status"></span></label>
                <input type="password" name="password" autocomplete="off">
            </section>

            <section class="form-input">
                <label>Confirm New Password <span class="required-status"></span></label>
                <input type="password" name="password_confirmation" autocomplete="off">
            </section>
        </section>

        <section  class="form-input user-profile-btns">
            <a class="btn-s-one float-left profile-btn" href="/logout"  >Log Out</a>
            <button class="btn-s-one float-right profile-btn">Update profile</button>
        </section>
    </form>

@stop
