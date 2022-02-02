@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <div class="card-header"><h4>{{__('messages.welcome')}}</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('slides.create') }}">Add new sidebar menu</a>
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
                        <th>Status</th>
                        <th>Order</th>
                        <th>Description</th>

                        <th>Image</th>
                        <th></th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>  
                        @foreach($slides as $slide)
                            <form action="{{route('slides.delete', ['sliAutoID' => $slide->sliAutoID])}}" method="POST" enctype="multiple/form-data">
                                {{method_field('delete')}}
                                {{csrf_field()}}    
                                <div id="ModalDelete{{$slide->sliAutoID}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" style="width:55%" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{__('Confirmation message')}}</h4>
                                                <button type="button" data-dismiss="modal" class="close">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete this record?</p>
                                                <input type="hidden" name="id" value="{{$slide->sliAutoID}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn text-white btn-warning" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <!--  -->
                            <tr>
                                <td>
                                    {{ $slide->sliAutoID }}
                                </td>
                                <td>
                                    {{ $slide->sliName }}
                                </td>
                                <td>
                                @if ($slide->sliStatus == "1")
                                    Active
                                @else
                                    Inactive
                                @endif  
                                </td>
                                <td>
                                    {{ $slide->sliOrder }}
                                </td>
                                <td>
                                    {!! $slide->sliDescription !!}
                                </td>
                                <td>
                                    <img src="/uploads/{{$slide->sliImage }}" alt="hh">
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('slides.show', ['sliAutoID' => $slide->sliAutoID] ) }}">View</a>
                                </td>
                                <td>
                                    <a class="btn btn-warning text-white" href="{{ route('slides.edit', ['sliAutoID' => $slide->sliAutoID] ) }}">Edit</a>

                                </td>
                                <td>
                                <a class="btn btn-danger text-white" id="submit" data-id="{{$slide->sliAutoID}}" data-toggle="modal" data-target="#ModalDelete{{$slide->sliAutoID}}">Delete</a>
                                    <!-- <a class="btn btn-danger" href="{{ route('slides.delete', ['sliAutoID' => $slide->sliAutoID] ) }}">Delete</a> -->
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
    <!--  -->

  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>

  
  
  
</script>
@endsection

@section('javascript')

@endsection