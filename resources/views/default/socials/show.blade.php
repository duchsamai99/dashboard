@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View social</h4></div>
            <div class="card-body">
                <p><b>Id: </b>{{$social->socAutoID}}</p>
                <p><b>Title: </b>{{$social->socTitle}}</p>
                <p><b>Follower: </b>{{$social->socFollower}}</p>
                <p><b>Sign: </b>{{$social->socSign}}</p>
                <p><b>Status: </b>{{$social->socStatus}}</p>
                <p>
                  <p><b>Image: </b></p>
                  <img src="/uploads/{{$social->socImage }}" alt="hh">
                </p>
                <a class="btn btn-info" href="{{ route('socials.index') }}">Return</a>
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