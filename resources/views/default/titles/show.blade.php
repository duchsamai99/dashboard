@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail title</h4></div>
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
                      {{$title->titID}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Title
                    </th>
                    <td>
                      {{$title->titTitle}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Alias:
                    </th>
                    <td>
                      {{$title->titAlias}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Description:
                    </th>
                    <td>
                      {!! $title->titDescription !!}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Status
                    </th>
                    <td>
                      @if($title->titStatus == 0)
                        Active
                      @else
                        Inactive
                      @endif
                      
                    </td>
                  </tr>
                </tbody>
              </table>
              <a class="btn btn-warning text-white" href="{{ route('titles.index') }}">Return</a>
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