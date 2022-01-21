@extends('dashboard.base')

@section('content')

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="card">
              <div class="card-header">
              <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('users.create') }}">Add new user</a>
                </div>
              <div class="card-body">
                <h4>List of users</h4>
                  <table class="table table-responsive-sm table-striped">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>E-mail</th>
                      <th>Roles</th>
                      <th>Email verified at</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                      <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->menuroles }}</td>
                        <td>{{ $user->email_verified_at }}</td>
                        <td>
                          <a href="{{ url('/users/' . $user->id) }}" class="btn btn-block btn-info">View</a>
                        </td>
                        <td>
                          <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-block text-white btn-warning">Edit</a>
                        </td>
                        <td>
                          @if( $you->id !== $user->id )
                          <form action="{{ route('users.destroy', $user->id ) }}" method="POST">
                              @method('DELETE')
                              @csrf
                              <button class="btn btn-block btn-danger">Delete User</button>
                          </form>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('javascript')

@endsection

