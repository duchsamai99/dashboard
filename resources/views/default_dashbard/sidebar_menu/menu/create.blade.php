@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Create sidebar menu</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form action="{{ route('sidebar.menu.store') }}" method="POST">
                    @csrf
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Title</span>
                              <input type="text" class="form-control" name="name"></input>
                            </div>
                          </div>
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Status</span>
                              <select class="form-control" name="status" aria-label="Default select example">
                                <option selected value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                            </div> 
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="form-group">
                              <span>Order</span>
                              <input type="number" class="form-control" name="order"></input>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Order
                                </th>
                                <td>
                                    <input type="text" class="form-control" name="name" placeholder="Name"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="status" placeholder="Status"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="order" placeholder="Order"/>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a class="btn btn-primary" href="{{ route('sidebar.menu.index') }}">Return</a>
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