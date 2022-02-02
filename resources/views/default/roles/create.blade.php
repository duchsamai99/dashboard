@extends('dashboard.base')
@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Create new role</h4></div>
            <div class="card-body">
              @if(Session::has('message_success'))
                <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
              @elseif(Session::has('message_fail'))
                <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
              @endif
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <table class="table table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    <input class="form-control" name="name" type="text"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-info" type="submit">Save</button>
                    <a class="btn btn-warning text-white" href="{{ route('roles.index') }}">Return</a>
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