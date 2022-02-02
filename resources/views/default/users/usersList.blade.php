@extends('dashboard.base')

@section('content')

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="card">
              <div class="card-header">
                <h4>List of users</h4>
              
              <div class="card-body">
                <div class="row mb-3 ml-1">
                  <a class="btn btn-lg btn-info" href="{{ route('users.create') }}">Add new user</a>
                </div>
                @if(Session::has('message_success'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                  <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                  <table class="table table-striped table-bordered datatable">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>E-mail</th>
                      <th>Roles</th>
                      <th>Profile</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <!-- delete modal -->
                      <form action="{{ route('users.destroy',$user->id) }}" method="POST" enctype="multiple/form-data">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}  
                        <div id="ModalDelete{{$user->id}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" style="width:55%" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Confirmation message</h4>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                              </div>
                              <div class="modal-body">
                                <p>Do you want to delete this record?</p>
                                <input type="hidden" name="socAutoID" value="{{$user->id}}">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn text-white bg-warning" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn text-white bg-danger">Delete</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <!-- end delete modal -->
                      <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->menuroles }}</td>
                        <td>
                          <img  src="{{ url('/uploads/users/'.$user->image) }}" style="width: 20%;  " alt="user@email.com">
                        </td>
                        <td>
                          <a href="{{ url('/users/' . $user->id) }}" class="btn btn-info">View</a>
                          <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn text-white btn-warning">Edit</a>
                          @if( $you->id !== $user->id )
                            <a class="btn text-white btn-danger" id="submit" data-id="{{$user->id}}" data-toggle="modal" data-target="#ModalDelete{{$user->id}}">Delete</a>
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

