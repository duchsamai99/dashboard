@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Create menu element</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif

                <form action="{{route('sidebar.menu.update')}}" method="POST">
                    @csrf
                    <!-- @method('PUT') -->
                    <input type="hidden" name="id" value="{{ $viewSidebar->id }}" id="menuElementId"/>
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Title</span>
                              <input type="text" class="form-control" name="name" value="{{ $viewSidebar->name }}" require></input>
                            </div>
                          </div>
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Status</span>
                              <select class="form-control" name="status" aria-label="Default select example" value="{{ $viewSidebar->status }}">
                              @if ($viewSidebar->status == "Active")
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                              @else
                                <option value="Active" >Active</option>
                                <option value="Inactive" selected>Inactive</option>
                              @endif  
                              
                              </select>
                            </div> 
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Order</span>
                              <input type="number" class="form-control" name="order" value="{{ $viewSidebar->order }}" require></input>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <input type="hidden" name="id" value="{{ $viewSidebar->id }}" id="menuElementId"/>
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    <input type="text" name="name" class="form-control" value="{{ $viewSidebar->name }}"/>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                    <button class="btn btn-info" type="submit">Save</button>
                    <a class="btn btn-warning" href="{{ route('sidebar.menu.index') }}">Return</a>
                </form>
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