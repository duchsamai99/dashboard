@extends('dashboard.base')
@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail social</h4></div>
            <div class="card-body">
              @if(Session::has('message'))
                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
              @endif
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <th>
                      ID
                    </th>
                    <td>
                      {{$social->socID}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Title
                    </th>
                    <td>
                      {{$social->socTitle}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Follower:
                    </th>
                    <td>
                      {{$social->socFollower}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Sign:
                    </th>
                    <td>
                      {{$social->socSign}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Status
                    </th>
                    <td>
                      @if($social->socStatus == 0)
                        Active
                      @else
                        Inactive
                      @endif
                      
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Image:
                    </th>
                    <td>
                      <img src="/uploads/{{$social->socImage }}" alt="hh">
                    </td>
                  </tr>
                </tbody>
              </table>
              <a class="btn btn-warning text-white" href="{{ route('socials.index') }}">Return</a>
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