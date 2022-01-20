@extends('dashboard.base')
@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
@endsection
@section('content')

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
              <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <h1>{{ __('Create new user') }}</h1>
                <!-- <p class="text-muted">Create your account</p> -->
                <div class="form-group">
                  <strong>Name:</strong>
                  <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="form-group">
                  <strong>Email:</strong>
                  <input class="form-control" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                  <strong>Password:</strong>
                  <input class="form-control input-group-addon" type="password" id="password" placeholder="{{ __('Password') }}" name="password" required>
                  <input type="checkbox" id="toggle-password">Show Password
                  
                </div>
                <div class="form-group">
                  <strong>User role:</strong>
                  <select class = "form-control" name="role" id="">
                    <option value="User" selected>User</option>
                    <option value="Admin" >Admin</option>
                    <option value="guest">guest</option>
                  </select>
                </div>
                <button class="btn btn-info" type="submit">{{ __('Save') }}</button>
                <a class="btn btn-warning text-white" href="{{ route('users.index') }}">Return</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script>
    $("#toggle-password").click(function(){
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    });
  </script>
@endsection

@section('javascript')

@endsection