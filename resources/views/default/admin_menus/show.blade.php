@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Show site menu</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                    Menu
                                </th>
                                <td>
                                    @foreach($menulist as $menu1)
                                        @if($menu1->id == $menuElement->menu_id  )
                                            {{ $menu1->name }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    User Roles
                                </th>
                                <td>
                                    <?php
                                        $first = true;
                                        foreach($menuroles as $menurole){
                                            if($first === true){
                                                $first = false;
                                            }
                                            echo '<b>'.$menurole->amrRoleName.'</b>';
                                            echo '<ul>';
                                            if($menurole->amrView ==1){
                                                echo'<li>View</li>';
                                            }
                                            if($menurole->amrInsert ==1){
                                                echo'<li>Insert</li>';
                                            }
                                            if($menurole->amrUpdate ==1){
                                                echo'<li>Update</li>';
                                            }
                                            if($menurole->amrDelete ==1){
                                                echo'<li>Delete</li>';
                                            }
                                            echo '</ul>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Type
                                </th>
                                <td>
                                    {{ $menuElement->slug }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Href:
                                </th>
                                <td>
                                    {{ $menuElement->href}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Dropdown parent:
                                </th>
                                <td>
                                    <?php
                                        if(isset($menuElement->parent_name)){
                                            echo $menuElement->parent_name;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Icon
                                </th>
                                <td>
                                    <i class="{{ $menuElement->icon }}"></i>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $menuElement->icon }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="{{ route('menu.index', ['menu' => $menuElement->menu_id]) }}">Return</a>
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