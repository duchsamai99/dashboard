@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>View detail user</h4></div>
            <div class="card-body">
            <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <th>
                      ID
                    </th>
                    <td>
                      {{$user->id}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Name
                    </th>
                    <td>
                      {{$user->name}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Email
                    </th>
                    <td>
                      {{$user->email}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Role
                    </th>
                    <td>
                      {{$user->menuroles}}
                    </td>
                  </tr>
                  <tr>
                    <th>
                      Profile
                    </th>
                    <td>
                    <img src="/uploads/users/{{$user->image}}" id="preview_image" style="width: 50px;height: 50px; padding: 5px; margin: 0px; ">
                    </td>
                  </tr>
                </tbody>
              </table>
              
              <a class="btn btn-warning text-white" href="{{ route('users.index') }}">Return</a>
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