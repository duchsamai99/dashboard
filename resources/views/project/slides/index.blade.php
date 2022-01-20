@extends('dashboard.base')

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <div class="card-header"><h4>{{__('messages.welcome')}}</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-3">
                    <a class="btn btn-lg btn-info" href="{{ route('slides.create') }}">Add new sidebar menu</a>
                </div>
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
                        <!-- <input type="hidden" name="id" value="{{ $slide->id }}" id="id"/> -->

                                                    <!-- Delete Product Model -->
                            <form action="{{route('slides.delete', $slide->id)}}" method="POST" enctype="multiple/form-data">
                                {{method_field('delete')}}
                                {{csrf_field()}}    
                            <div id="ModalDelete{{$slide->id}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" style="width:55%" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{__('Slide Delete')}}</h4>
                                                <button type="button" class="close">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>You Want You Sure Delete This Record?</h4>
                                                <input type="hidden" name="id" value="{{$slide->id}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn gray btn-outline-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn gray btn-outline-danger">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <!--  -->
                            <tr>
                                <td>
                                    {{ $slide->id }}
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
                                    {!! $slide->description !!}
                                </td>
                                <td>
                                    <img src="/uploads/{{$slide->sliImage }}" alt="hh">
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('slides.show', ['id' => $slide->id] ) }}">View</a>
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('slides.edit', ['id' => $slide->id] ) }}">Edit</a>

                                </td>
                                <td>
                                <a class="btn btn-danger" id="submit" data-id="{{$slide->id}}" data-toggle="modal" data-target="#ModalDelete{{$slide->id}}">Delete</a>
                                    <!-- <a class="btn btn-danger" href="{{ route('slides.delete', ['id' => $slide->id] ) }}">Delete</a> -->
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