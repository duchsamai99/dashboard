@extends('dashboard.base')
@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
@endsection
@section('content')
  <!--  -->
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Create New user</h4></div>
            <div class="card-body">
            @if(Session::has('message_success'))
              <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
            @elseif(Session::has('message_fail'))
              <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
            @endif
              <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>Name:</strong>
                        <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autofocus>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>Email:</strong>
                        <input class="form-control" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>Password:</strong>
                        <input class="form-control input-group-addon" type="password" id="password" placeholder="{{ __('Password') }}" name="password" required>
                        <input type="checkbox" id="toggle-password">Show Password
                      </div>   
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>User role:</strong>
                    <select class = "form-control" name="role" id="">
                      <option value="user" selected>user</option>
                      <option value="admin" >admin</option>
                      <option value="guest">guest</option>
                    </select>
                  </div>    
                </div>
                <button class="btn btn-info"type="submit">Save</button>
                <a class="btn btn-warning text-white" href="{{ route('users.index') }}">Return</a>    
              </form>
            </div>
          </div>
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