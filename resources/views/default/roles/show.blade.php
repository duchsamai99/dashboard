@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail role</h4></div>
            <div class="card-body">
            <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <th>
                      ID
                    </th>
                    <td>
                      {{$role->id}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Name
                    </th>
                    <td>
                      {{$role->name}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Created at:
                    </th>
                    <td>
                      {{$role->created_at}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Updated at:
                    </th>
                    <td>
                      {{$role->updated_at}}
                    </td>
                  </tr>
                </tbody>
              </table>
              
              <a class="btn btn-warning text-white" href="{{ route('roles.index') }}">Return</a>
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