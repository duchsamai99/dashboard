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
                    <a class="btn btn-lg btn-primary" href="{{ route('sidebar.menu.create') }}">Add new sidebar menu</a>
                </div>
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            
                        <th>Title</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th></th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>    
                        @foreach($viewSidebars as $viewSidebar)
                            <tr>
                                <td>
                                    {{ $viewSidebar->name }}
                                </td>
                                <td>
                                    {{ $viewSidebar->status }}
                                </td>
                                <td>
                                    {{ $viewSidebar->order }}
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('sidebar.menu.show', ['id' => $viewSidebar->id] ) }}">View</a>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('sidebar.menu.edit', ['id' => $viewSidebar->id] ) }}">Edit</a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('sidebar.menu.delete', ['id' => $viewSidebar->id] ) }}">Delete</a>
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