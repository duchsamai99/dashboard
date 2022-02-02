@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>List of roles</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('roles.create') }}">Add new role</a>
                </div>
                <br>
                @if(Session::has('message_success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hierarchy</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <!-- delete modal -->
                        <form action="{{ route('roles.destroy',$role->id) }}" method="POST" enctype="multiple/form-data">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}  
                                <div id="ModalDelete{{$role->id}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" style="width:55%" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation message</h4>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete this record?</p>
                                                <input type="hidden" name="socAutoID" value="{{$role->id}}">
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
                                <td>
                                    {{ $role->name }}
                                </td>
                                <td>
                                    {{ $role->hierarchy }}
                                </td>
                                <td>
                                    {{ $role->created_at }}
                                </td>
                                <td>
                                    {{ $role->updated_at }}
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('roles.up', ['id' => $role->id]) }}">
                                        <i class="cil-arrow-thick-top"></i> 
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('roles.down', ['id' => $role->id]) }}">
                                        <i class="cil-arrow-thick-bottom"></i>  
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('roles.show', $role->id ) }}" class="btn btn-info">Show</a>
                                </td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-warning text-white">Edit</a>
                                </td>
                                <td>
                                    <a class="btn text-white btn-danger" id="submit" data-id="{{$role->id}}" data-toggle="modal" data-target="#ModalDelete{{$role->id}}">Delete</a>
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
</div>

@endsection

@section('javascript')

@endsection