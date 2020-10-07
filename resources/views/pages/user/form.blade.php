@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    Create a New User
  </div>
  <form action="{{ $user->id == '' ? route('user.store') : route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($user->id != '')
      @method('put')
    @endif
    <div class="card-body">
      <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $user->name != '' ? $user->name : old('name') }}">

        <!-- error -->
        @if($errors->has('name'))
          <small class="text-danger">
            {{ $errors->first('name') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ $user->email != '' ? $user->email : old('email') }}">

        <!-- error -->
        @if($errors->has('email'))
          <small class="text-danger">
            {{ $errors->first('email') }}
          </small>
        @endif
      </div>

      @if($user->id == '')
        <div class="form-group">
          <label for="">Password</label>
          <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" value="{{ $user->password }}">

          <!-- error -->
          @if($errors->has('password'))
            <small class="text-danger">
              {{ $errors->first('password') }}
            </small>
          @endif
        </div>
      @else
        <div class="form-group">
          <label for="">
            <input type="checkbox" name="change_password" class="change_password"> Change password
          </label>
          <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} hide" value="" placeholder="Password">

          <!-- error -->
          @if($errors->has('password'))
            <small class="text-danger">
              {{ $errors->first('password') }}
            </small>
          @endif
        </div>
      @endif
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Submit</button>
      <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('script')
<script>
  $(function(){
    $('.change_password').on('click', function(){
      if($(this).is(':checked')){
        $('input[name=password]').removeClass('hide');
      }else{
        $('input[name=password]').addClass('hide');
      }
    });
  });
</script>
@endpush