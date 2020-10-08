@extends('pages.auth.app')

@section('content')
<div id="wrapper" class="d-flex align-items-center justify-content-center">
  <div class="auth-box register">
    <div class="content">
      <div class="header">
        <div class="logo text-center">
          <h3>LOGO</h3>
        </div>
        <p class="lead">Create an account</p>
      </div>
      <form class="user form-auth-small" method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="form-group">
          <input type="text" name="name" class="form-control form-control-user {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Full name" value="{{ old('name') }}" required>

          <!-- error -->
          @if($errors->has('name'))
            <small class="text-danger">
              {{ $errors->first('name') }}
            </small>
          @endif
        </div>
        <div class="form-group">
          <input type="email" name="email" class="form-control form-control-user {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email Address" value="{{ old('email') }}" required>

          <!-- error -->
          @if($errors->has('email'))
            <small class="text-danger">
              {{ $errors->first('email') }}
            </small>
          @endif
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-user {{ $errors->has('password') ? 'is-invalid' : '' }}" id="" placeholder="Password" required>

          <!-- error -->
          @if($errors->has('password'))
            <small class="text-danger">
              {{ $errors->first('password') }}
            </small>
          @endif
        </div>
        <div class="form-group">
          <input type="password" name="confirm_password" class="form-control form-control-user {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="" placeholder="Confirm Password" required>

          <!-- error -->
          @if($errors->has('confirm_password'))
            <small class="text-danger">
              {{ $errors->first('confirm_password') }}
            </small>
          @endif
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
          Register Account
        </button>
      </form>      
    </div>
  </div>
</div>
@endsection