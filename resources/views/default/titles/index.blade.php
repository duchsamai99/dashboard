@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>List of titles</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('titles.create') }}">Add new title</a>
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
                            <th>Alias</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>  
                        @foreach($titles as $title)
                            <!-- delete modal -->
                            <form action="{{ route('titles.destroy',$title->titAutoID) }}" method="POST" enctype="multiple/form-data">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}  
                                <div id="ModalDelete{{$title->titAutoID}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" style="width:55%" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation message</h4>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete this record?</p>
                                                <input type="hidden" name="titAutoID" value="{{$title->titAutoID}}">
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
                                    {{ $title->titID}}
                                </td>
                                <td>
                                    {{ $title->titTitle}}
                                </td>
                                <td>
                                    {{ $title->titAlias}}
                                </td>
                                <td>
                                    {!! $title->titDescription !!}
                                </td>
                                <td>
                                    @if ($title->titStatus == "0")
                                        Active
                                    @else
                                        Inactive
                                    @endif  
                                </td>            
                                <td>
                                    <a class="btn btn-info text-white" href="{{ url('/titles/' . $title->titAutoID) }}">View</a>
                                    <a class="btn btn-warning text-white" href="{{ route('titles.edit', $title->titAutoID ) }}">Edit</a>
                                    <a class="btn text-white btn-danger" id="submit" data-id="{{$title->titAutoID}}" data-toggle="modal" data-target="#ModalDelete{{$title->titAutoID}}">Delete</a>
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