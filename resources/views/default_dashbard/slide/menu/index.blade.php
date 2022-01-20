@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Sidebar menu list</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-3">
                    <a class="btn btn-lg btn-info" href="{{ route('slide.menu.create') }}">Add new sidebar menu</a>
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
                                    <a class="btn btn-info" href="{{ route('sidebar.menu.show', ['id' => $slide->id] ) }}">View</a>
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('sidebar.menu.edit', ['id' => $slide->id] ) }}">Edit</a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('slide.menu.delete', ['id' => $slide->id] ) }}">Delete</a>
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