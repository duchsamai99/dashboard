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
            <div class="card-header"><h4>Edit Slide</h4></div>
              <div class="card-body">
                  @if(Session::has('message'))
                      <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                  @endif
                <form id="submit">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Title:</span>
                        <input type="text" name="socTitle" id="socTitle" class="form-control" placeholder="Title" value="{{$social->socTitle}}">
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Image:</span>
                        <input type="file" name="socImage" id="socImage" class="form-control image" placeholder="Social Image" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Follower:</span>
                        <input type="text" name="socFollower" id="socFollower" class="form-control" placeholder="Follower" value="{{$social->socFollower}}">
                      </div>   
                    </div>  
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Sign:</span>
                        <input type="text" name="socSign" id="socSign" class="form-control" placeholder="Sign" value="{{$social->socSign}}">
                      </div>   
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Order:</span>
                        <input type="number" name="socOrder" id="socOrder" class="form-control" placeholder="Order" value="{{$social->socOrder}}">
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span>Status</span>
                        <select class="form-control" name="socStatus" id="socStatus" aria-label="Default select example">
                          @if( $social->socStatus== 1)
                            <option selected value="0">Active</option>
                            <option value="1">Inactive</option>
                          @else
                            <option selected value="1">Inactive</option>
                            <option  value="0">Active</option>
                          @endif
                          
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <span class="text-secondary">Description:</span>
                        <textarea class="form-control" type="text" id="socDescription" name="socDescription">{{$social->socDescription}}</textarea>
                      </div>   
                    </div>  
                  </div>
                  <button class="btn btn-info"type="submit">Save</button>
                  <a class="btn text-white btn-warning" href="{{ route('socials.index') }}">Return</a>
                
                </form>
              </div>
            </div>
            <!-- modal -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="crop">Crop</button>
                  </div>
                </div>
              </div>
            </div>
            <!--endModal -->
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
                  url: "/socials/crop",
                  data: {'_token': $('meta[name="_token"]').attr('content'), 'socImage': base64data},
                  success: function(data){
                  getData = data;
                    console.log(data);
                      $modal.modal('hide');
                      // location.replace('/slides/create');
                  }
              });
          }
      });
  });
  tinymce.init({
    selector: 'textarea#socDescription',
    menubar: false
  });
  // sumite all data to store method in controller
  $('#submit').on('submit',function(e){
    var ed = tinyMCE.get('socDescription');
    e.preventDefault();
    var socTitle = $("#socTitle").val();
    var socOrder= $("#socOrder").val();
    var socSign= $("#socSign").val();
    var socFollower= $("#socFollower").val();
    var socStatus= $("#socStatus").val();
    var socDescription= ed.getContent();
    var socImage = getData;
    $.ajax({
      url: "/socials/{{ $social->socAutoID }}",
      type:"PUT",
      dataType: 'json',
      data:{
        "_token": "{{ csrf_token() }}",
        socTitle:socTitle,
        socDescription:socDescription,
        socOrder:socOrder,
        socFollower:socFollower,
        socSign:socSign,
        socStatus:socStatus,
        socImage:socImage.data
      },
      success:function(response){
        console.log(response);
        location.replace('/socials');
      }
      });
  });
  
  
  
</script>
@endsection

@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection
