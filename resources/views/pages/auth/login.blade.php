@extends('pages.auth.app')

@section('content')
<div id="wrapper" class="d-flex align-items-center justify-content-center">
  <div class="auth-box ">
    <div class="left">
      <div class="content">
        <div class="header">
          <div class="logo text-center">
            <h3>LOGO</h3>
          </div>
          <p class="lead">Login to your account</p>
        </div>
        @include('base.layouts.alert')
        <form class="form-auth-small" method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="form-group">
            <label for="signin-email" class="control-label sr-only">Email</label>
            <input type="email" name="email" class="form-control" id="signin-email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="signin-password" class="control-label sr-only">Password</label>
            <input type="password" name="password" class="form-control" id="signin-password" placeholder="Password">
          </div>
          <div class="form-group">
            <label class="fancy-checkbox element-left custom-bgcolor-blue">
              <input type="checkbox">
              <span class="text-muted">Remember me</span>
            </label>
          </div>
          <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
          <div class="bottom">
            <span class="helper-text d-block">Don't have an account? <a href="{{ route('register') }}">Register</a></span>
            <!-- <span class="helper-text"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span> -->
          </div>
        </form>
      </div>
    </div>
    <div class="right">
      <div class="overlay"></div>
      <div class="content text">
        <h1 class="heading">{{ env('APP_NAME') }}</h1>
        <p>by The Develovers</p>
      </div>
    </div>
  </div>
</div>
@endsection