@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Create admin menu</h4></div>
            <div class="card-body">
                @if(Session::has('message_success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('menu.store') }}" method="POST">
                    @csrf
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <!-- <th>
                                    Menu
                                </th> -->
                                <!-- <td> -->
                                    <select hidden class="form-control" name="menu" id="menu">
                                        @foreach($menulist as $menu1)
                                            <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                                        @endforeach
                                    </select>
                                <!-- </td> -->
                            </tr>
                            <tr>
                                <th>
                                    User Roles
                                </th>
                                <td>
                                    <table class="table">
                                    @foreach($roles as $key => $role)
                                        <tr>
                                            <td>
                                                <input  id="{{$key}}" type="checkbox" name="role[]" value="{{ $role }}" class="form-control check"/>
                                            </td>
                                            <td>
                                                <h5>{{ $role->name }}</h5>
                                                <p>Permission: </p>
                                                @foreach($actions as $action)
                                                    @if($action->actRoleID == $role->id)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input  type="checkbox"  disabled class="form-check-input checkbox permission{{$key}}" name="action[]" value="{{$action}}">{{$action->actName}}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    <input class="form-control" type="text" name="name" placeholder="Name" required/>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Type
                                </th>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="link">Link</option>
                                        <option value="title">Title</option>
                                        <option value="dropdown">Dropdown</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Other
                                </th>
                                <td>
                                    <div id="div-href">
                                        Href:
                                        <input type="text" name="href" class="form-control" placeholder="href"/>
                                    </div>
                                    <br><br>
                                    <div id="div-dropdown-parent">
                                        Select dropdown parent:
                                        <select class="form-control" name="parent" id="parent">

                                        </select>
                                    </div>
                                    <br><br>
                                    <div id="div-icon">
                                        Icon - Find icon class in: 
                                        <a 
                                            href="https://coreui.io/docs/icons/icons-list/#coreui-icons-free-502-icons"
                                            target="_blank"
                                        >
                                            CoreUI icons documentation
                                        </a>
                                        <br>
                                        <input class="form-control" name="icon" type="text" placeholder="CoreUI Icon class - example: cil-bell">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-info" type="submit">Save</button>
                    <a class="btn btn-warning text-white" href="{{ route('menu.index') }}">Return</a>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(".check").click(function(){
        var id_name = $(this).attr('id');
        console.log(id_name);
        var remember = document.getElementById(id_name).value;
        console.log(remember);
        var checkbox_condition = $('#'+id_name).is(":checked");
        if(checkbox_condition){
            $( '.permission'+id_name ).prop({
                disabled: false
            });
            $( '.permission'+id_name ).prop( "checked", true );

        }else{
            $('.permission'+id_name ).prop({
                disabled: true
            });
            $( '.permission'+id_name ).prop( "checked", false );

        }
        
    })
</script>
@endsection

@section('javascript')
<script src="{{ asset('js/axios.min.js') }}"></script> 
<script src="{{ asset('js/menu-create.js') }}"></script>


@endsection