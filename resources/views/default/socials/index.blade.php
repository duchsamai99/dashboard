@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>List of socials</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('socials.create') }}">Add new social</a>
                </div>
                @if(Session::has('message_success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>   
                            <th>Title</th>
                            <th>Image</th>
                            <th>Follower</th>
                            <th>Sign</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>  
                        @foreach($socials as $social)
                            <!-- delete modal -->
                            <form action="{{ route('socials.destroy',$social->socAutoID) }}" method="POST" enctype="multiple/form-data">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}  
                                <div id="ModalDelete{{$social->socAutoID}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" style="width:55%" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation message</h4>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete this record?</p>
                                                <input type="hidden" name="socAutoID" value="{{$social->socAutoID}}">
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
                                    {{ $social->socID}}
                                </td>
                                <td>
                                    {{ $social->socTitle}}
                                </td>
                                <td>
                                    <img src="/uploads/{{$social->socImage }}" alt="image">
                                </td>
                                <td>
                                    {{ $social->socFollower}}
                                </td>
                                <td>{{ $social->socSign }}</td>
                                <td>
                                    {!! $social->socDescription !!}
                                </td>
                                <td>
                                    @if ($social->socStatus == "0")
                                        Active
                                    @else
                                        Inactive
                                    @endif  
                                </td>
                                <td>
                                    {{ $social->socOrder }}
                                </td>            
                                <td>
                                    <a class="btn btn-info text-white" href="{{ url('/socials/' . $social->socAutoID) }}">View</a>
                                    <a class="btn btn-warning text-white" href="{{ route('socials.edit', $social->socAutoID ) }}">Edit</a>
                                    <a class="btn text-white btn-danger" id="submit" data-id="{{$social->socAutoID}}" data-toggle="modal" data-target="#ModalDelete{{$social->socAutoID}}">Delete</a>
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