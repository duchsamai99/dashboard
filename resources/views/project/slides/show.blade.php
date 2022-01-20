@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail slide</h4></div>
            <div class="card-body">
                <p><b>Id: </b>{{$slide->id}}</p>
                <p><b>Name: </b>{{$slide->sliName}}</p>
                <p><b>Slide Link: </b>{{$slide->sliLink}}</p>
                <p><b>Description: </b>{!!$slide->description!!}</p>
                <p><b>Order Slide: </b>{{$slide->sliOrder}}</p>
                <img src="/uploads/{{$slide->sliImage }}" class="rounded-circle" alt="SitImage1">
                <br>
                <a class="btn btn-info" href="{{ route('slides.index') }}">Return</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')


@endsection