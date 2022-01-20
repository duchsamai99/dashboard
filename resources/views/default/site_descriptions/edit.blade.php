@extends('dashboard.base')
@section('css') 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
          @if(Session::has('message'))
            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
          @endif
          <form id="submit">
            <div class="card">
              <div class="card-header">Site Description</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                      <div class="card-body">
                        <div class="form-group">
                          <span>Image:</span>
                          <input type="file" name="sitImage1" id="sitImage1" class="form-control image btn btn-block" placeholder="Slide Image">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                      <div class="card-body">
                        <div class="form-group">
                          <span>Image:</span>
                          <input type="file" name="sitImage2" id="sitImage2" class="form-control image btn btn-block" placeholder="Slide Image">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                      <div class="card-body">
                        <div class="form-group">
                          <span>Image:</span>
                          <input type="file" name="SitImage3" id="sitImage3" class="form-control image btn btn-block" placeholder="Slide Image" >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <img src="/uploads/{{$sit_description->SitImage1 }}" class="rounded-circle" alt="SitImage1">
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <img src="/uploads/{{$sit_description->SitImage2 }}" alt="SitImage2">
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4">
                    <img src="/uploads/{{$sit_description->SitImage3 }}" alt="SitImage3">
                  </div>

                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <span class="text-secondary">Site Name:</span>
                      <input type="text" name="sitName" id="sitName" class="form-control w3-input" value="{{$sit_description->SitName}}">
                    </div>   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <span class="text-secondary">Copy Right:</span>
                      <input type="text" name="sitCopyRight" id="sitCopyRight" class="form-control w3-input" value="{{$sit_description->SitName}}">
                    </div>   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <span class="text-secondary">ReciverMail:</span>
                      <input type="text" name="sitReceiverMail" id="sitReceiverMail" class="form-control w3-input" value="{{$sit_description->SitReceiverMail}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <span class="text-secondary">Phone number:</span>
                      <input type="text" name="sitPhoneNumber" id="sitPhoneNumber" class="form-control w3-input" value="{{$sit_description->SitPhoneNumber}}">
                    </div>   
                  </div>
                </div>
                <button class="btn btn-info"type="submit">Save</button>
                <a class="btn text-white btn-warning" href="{{ route('site-descriptions.index') }}">Return</a>
              </div>
            </div>       
          </form>
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
                  url: "/site-descriptions/crop",
                  data: {'_token': $('meta[name="_token"]').attr('content'), 'sitImage1': base64data},
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
  // sumite all data to store method in controller
  $('#submit').on('submit',function(e){
    e.preventDefault();
    var sitImage1 = $("#sitImage1").val();
    var sitName= $("#sitName").val();
    var sitCopyRight= $("#sitCopyRight").val();
    var sitReceiverMail= $("#sitReceiverMail").val();
    var sitPhoneNumber= $("#sitPhoneNumber").val();
    var sitImage1 = getData.data;
    $.ajax({
      url: "/site-descriptions",
      type:"POST",
      dataType: 'json',
      data:{
        "_token": "{{ csrf_token() }}",
        sitName:sitName,
        sitCopyRight:sitCopyRight,
        sitReceiverMail:sitReceiverMail,
        sitPhoneNumber:sitPhoneNumber,
        sitImage1:sitImage1
      },
      success:function(response){
        console.log(response);
        location.replace('/site-descriptions/'+1+'/edit');
      }
      });
  });
  
  
  
</script>
@endsection

@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection
