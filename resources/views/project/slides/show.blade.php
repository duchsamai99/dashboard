@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail slide</h4></div>
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
                      {{$slide->sliID}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Name
                    </th>
                    <td>
                      {{$slide->sliName}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Link:
                    </th>
                    <td>
                      {{$slide->sliLink}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Description:
                    </th>
                    <td>
                      {!! $slide->sliDescription !!}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Status
                    </th>
                    <td>
                      @if($slide->sliStatus == 0)
                        Active
                      @else
                        Inactive
                      @endif
                      
                    </td>
                  </tr>
                  <tr>
                    <th>Image</th>
                    <td>
                      <img src="/uploads/{{$slide->sliImage }}"  alt="SitImage1">
                    </td>
                  </tr>
                </tbody>
              </table>
              <a class="btn btn-warning text-white" href="{{ route('slides.index') }}">Return</a>
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