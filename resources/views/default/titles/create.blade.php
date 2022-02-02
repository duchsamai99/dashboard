@extends('dashboard.base')
@section('css') 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
@endsection
@section('content')
<div id="body">
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header"><h4>Create new title</h4></div>
              <div class="card-body">
                @if(Session::has('message_success'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                  <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                <form id="submit">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Title:</span>
                        <input type="text" name="titTitle" id="titTitle" class="form-control" placeholder="Title" required>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Alias:</span>
                        <input type="text" name="titAlias" id="titAlias" class="form-control" placeholder="Alias" required>
                      </div>   
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Description:</span>
                        <textarea class="form-control" type="text" id="titDescription" name="titDescription"></textarea>
                      </div>   
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span>Status</span>
                        <select class="form-control" name="titStatus" id="titStatus" aria-label="Default select example">
                          <option selected value="0">Active</option>
                          <option value="1">Inactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-info"type="submit">Save</button>
                  <a class="btn text-white btn-warning" href="{{ route('titles.index') }}">Return</a>
                
                </form>
              </div>
            </div>
          </div>
        </div>
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
  tinymce.init({
    selector: 'textarea#titDescription',
    menubar: false
  });
  // sumite all data to store method in controller
  $('#submit').on('submit',function(e){
    var ed = tinyMCE.get('titDescription');
    e.preventDefault();
    var titTitle = $("#titTitle").val();
    var titAlias= $("#titAlias").val();
    var titStatus= $("#titStatus").val();
    var titDescription= ed.getContent();
    $.ajax({
      url: "/titles",
      type:"POST",
      dataType: 'json',
      data:{
        "_token": "{{ csrf_token() }}",
        titTitle:titTitle,
        titDescription:titDescription,
        titAlias:titAlias,
        titStatus:titStatus,
      },
      success:function(response){
        console.log(response);
        if(response == true){
          location.replace('/titles');

        }else{
          location.replace('/titles/create');

        }
      }
      });
  });
  
  
  
</script>
@endsection

@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection
