@extends('dashboard.base')
@section('css') 
  <!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
@endsection
@section('content')
  <div id="body">
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-4"></div>
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-4">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> {{ __('Edit') }} {{ $user->name }}
              </div>
              <div class="card-body">
                <!-- <form id="submit" method="POST" action="/users/{{ $user->id }}"> -->
                <form id="submit" >

                  <!-- @csrf
                  @method('PUT') -->
                  <!-- <input class="form-control" type="text" id="menuroles" placeholder="{{ __('Name') }}" name="menuroles" value="{{$user->name }}" required autofocus> -->
                  @if (strpos(Auth::user()->menuroles, 'admin') !== false)
                    <div class="form-group">
                        <!-- <div class="input-group-prepend">
                            <span class="input-group-text">
                              <svg class="c-icon c-icon-sm">
                                  <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                              </svg>
                            </span>
                        </div> -->
                        <strong>Username:</strong>
                        
                        <input class="form-control" type="text" id="name" placeholder="{{ __('Name') }}" name="name" value="{{$user->name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <!-- <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div> -->
                        <strong>Email:</strong>
                        <input class="form-control" type="text" id="email" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ $user->email }}" required>
                    </div>
                  <div class="form-group">
                      <strong>Password:</strong>
                      <input class="form-control" type="password" id="password" value="{{$user->password}}"  placeholder="{{ __('Password') }}" name="password" required>
                      <input type="checkbox" id="toggle-password">Show Password
                  </div>
                @endif
                  <div class="form-group">
                    <strong>Change Profile:</strong>
                    <input type="file" name="image" id="profileImage" class="form-control image" placeholder="Change profile">
                  </div>
                  <button class="btn  btn-success" type="submit">{{ __('Save') }}</button>
                  <a href="{{ route('users.index') }}" class="btn  btn-warning text-white">{{ __('Return') }}</a> 
                </form>
              </div>
            </div>
            <!-- modal -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                          <div class="col-md-2"></div>
                          <div class="col-md-4">
                              <img class="img" id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                          </div>
                          <div class="col-md-1"></div>

                          <div class="col-md-3">
                              <div class="preview"></div>
                          </div>
                          <div class="col-md-2"></div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="crop">Crop</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
            <!--endModal -->
          </div>
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-4"></div>
        </div>
      </div>
    </div>
  </div>

  <style>
  /* #body{
    font-size: 11px;
  } */
  .img {
    display: block;
    max-width: 100%;
  }
  .preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
  }
  .modal-lg{
    max-width: 40% !important;
    max-height: 100rem !important;

  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  var $modal = $('#modal');
  var image = document.getElementById('image');
  
  var cropper;
  var getData;
  $("#toggle-password").click(function(){
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  });
  $("#body").on("change", ".image", function(e){
      var files = e.target.files;
      var done = function (url) {
        image.src = url;
        $modal.modal('show');
      };
      var reader;
      var file;
      var url;

      if (files && files.length > 0) {
        file = files[0];

        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) {
          reader = new FileReader();
          reader.onload = function (e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
  });

  $modal.on('shown.bs.modal', function () {
      cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      preview: '.preview'
      });
  }).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
  });

  $("#crop").click(function(){
      canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 500,
        });
      canvas.toBlob(function(blob) {
          url = URL.createObjectURL(blob);
          var reader = new FileReader();
          reader.readAsDataURL(blob); 
          reader.onloadend = function() {
              var base64data = reader.result;	
              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "/users/crop",
                  data: {'_token': $('meta[name="_token"]').attr('content'), 'profileImage': base64data},
                  success: function(data){
                  getData = data;
                    console.log(data);
                      $modal.modal('hide');
                      // location.replace('/slide/create');
                  }
              });
          }
      });
  });
  tinymce.init({
    selector: 'textarea#description',
    menubar: false
  });
  // sumite all data to store method in controller
  $('#submit').on('submit',function(e){
    e.preventDefault();
    var name = $("#name").val();
    var email= $("#email").val();
    var password = $('#password').val();

    $.ajax({
      url: "/users/{{ $user->id }}",
      type:"PUT",
      dataType: 'json',
      data:{
        "_token": "{{ csrf_token() }}",
        name:name,
        email:email,
        password:password,
        image:getData.data
      },
      success:function(response){
        location.replace('/users');
      }
      });
  });
  
  
  
</script>
@endsection

@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection