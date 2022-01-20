@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail sidebar</h4></div>
            <div class="card-body">
                <p><b>Id: </b>{{$viewSidebar->id}}</p>
                <p><b>Name: </b>{{$viewSidebar->name}}</p>
                <p><b>Status: </b>{{$viewSidebar->status}}</p>
                <p><b>Order: </b>{{$viewSidebar->order}}</p>

                <a class="btn btn-primary" href="{{ route('sidebar.menu.index') }}">Return</a>
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