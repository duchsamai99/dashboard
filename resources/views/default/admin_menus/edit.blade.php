@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Edit admin menu</h4></div>
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
                <form action="{{ route('menu.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $menuElement->id }}" id="menuElementId"/>
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <!-- <th>
                                    Menu
                                </th> -->
                                <!-- <td> -->
                                    <select hidden class="form-control" name="menu" id="menu">
                                        @foreach($menulist as $menu1)
                                            @if($menu1->id == $menuElement->smeMenu_id  )
                                                <option value="{{ $menu1->id }}" selected>{{ $menu1->name }}</option>
                                            @else
                                                <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                                            @endif
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
                                        @foreach($get_role_menu_roles as $role)
                                            <tr>
                                                <td>
                                                    
                                                    @foreach($menuroles as $menurole)
                                                        @if($role->id == $menurole->amrRoleID)
                                                            <input type="checkbox" id="{{$role->id}}" checked name="role[]" value="{{$role}}" class="form-control check"/>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $role->name }}
                                                    @foreach($actions as $action)
                                                        @foreach($menuroles as $menurole)
                                                            @if($action->actRoleID == $menurole->amrRoleID && $action->actRoleID == $role->id)                                                                    
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        @if($menurole->amrInsert ==1 && $role->id == $menurole->amrRoleID && $action->actName== "Insert")  

                                                                            <input type="checkbox" class="form-check-input action{{$role->id}}" checked name="action[]" value="{{$action}}">{{$action->actName}}
                                                                        @elseif($menurole->amrView ==1 && $role->id == $menurole->amrRoleID && $action->actName== "View")
                                                                            <input type="checkbox" class="form-check-input action{{$role->id}}" checked name="action[]" value="{{$action}}">{{$action->actName}}
                                                                        @elseif($menurole->amrUpdate ==1 && $role->id == $menurole->amrRoleID && $action->actName== "Edit")
                                                                            <input type="checkbox" class="form-check-input action{{$role->id}}" checked name="action[]" value="{{$action}}">{{$action->actName}}
                                                                        @elseif($menurole->amrDelete ==1 && $role->id == $menurole->amrRoleID && $action->actName== "Delete")
                                                                            <input type="checkbox" class="form-check-input action{{$role->id}}" checked name="action[]" value="{{$action}}">{{$action->actName}}
                                                                        @else
                                                                        <input type="checkbox" class="form-check-input action{{$role->id}}" name="action[]" value="{{$action}}">{{$action->actName}}

                                                                        @endif
                                                                </label>
                                                                </div>
                                                            @endif 
                                                        @endforeach
                                                        
                                                        
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach($get_role_without_menu_roles as $get_role_without_menu_role)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="role[]" id="{{$get_role_without_menu_role->id}}" value="{{$get_role_without_menu_role}}" class="form-control check"/>
                                                    
                                                </td>
                                                <td>
                                                    {{ $get_role_without_menu_role->name }}
                                                    @foreach($actions as $action)
                                                            @if($action->actRoleID == $get_role_without_menu_role->id)
                                                                    
                                                            <div class="form-check">
                                                                <label class="form-check-label"> 
                                                                    <input type="checkbox" disabled class="form-check-input action{{$get_role_without_menu_role->id}}" name="action[]" value="{{$action}}">{{$action->actName}}
                                                                </label>
                                                            </div>
                                                            @endif   
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    <!--  -->
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    value="{{ $menuElement->name }}"
                                    placeholder="Name"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Type
                                </th>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        @if($menuElement->slug === 'link')
                                            <option value="link" selected>Link</option>
                                        @else
                                            <option value="link">Link</option>
                                        @endif
                                        @if($menuElement->slug === 'title')
                                            <option value="title" selected>Title</option>
                                        @else
                                            <option value="title">Title</option>
                                        @endif
                                        @if($menuElement->slug === 'dropdown')
                                            <option value="dropdown" selected>Dropdown</option>
                                        @else
                                            <option value="dropdown">Dropdown</option>
                                        @endif
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
                                        <input 
                                            type="text" 
                                            name="href" 
                                            class="form-control" 
                                            placeholder="href"
                                            value="{{ $menuElement->href }}"
                                        />
                                    </div>
                                    <br><br>
                                    <div id="div-dropdown-parent">
                                        Dropdown parent:
                                        <input type="hidden" id="parentId" value="{{ $menuElement->parent_id }}"/>
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
                                        <input 
                                            class="form-control" 
                                            name="icon" 
                                            type="text" 
                                            placeholder="CoreUI Icon class - example: cil-bell"
                                            value="{{ $menuElement->icon }}"
                                        >
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-info" type="submit">Save</button>
                    <a class="btn btn-warning text-white" href="{{ route('menu.index', ['menu' => $menuElement->menu_id]) }}">Return</a>
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
            $( '.action'+id_name ).prop({
                disabled: false
            });
            $( '.action'+id_name ).prop( "checked", true );

        }else{
            $('.action'+id_name ).prop({
                disabled: true
            });
            $( '.action'+id_name ).prop( "checked", false );

        }
        
    })
</script>
@endsection

@section('javascript')
<script src="{{ asset('js/axios.min.js') }}"></script> 
<script src="{{ asset('js/menu-edit.js') }}"></script> 



@endsection