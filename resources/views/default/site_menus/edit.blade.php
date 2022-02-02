@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Edit menu element</h4></div>
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
                <form action="{{ route('site.menu.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $menuElement->smeAutoID }}" id="menuElementId"/>
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <!-- <th>
                                    Menu
                                </th>
                                <td> -->
                                    <select hidden class="form-control" name="menu" id="menu">
                                        @foreach($menulist as $menu1)
                                            @if($menu1->id == $menuElement->smeMenu_id  )
                                                <option value="{{ $menu1->id }}" selected>{{ $menu1->name }}</option>
                                            @else
                                                <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                <!-- </td>
                            </tr> -->
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    value="{{ $menuElement->smeName }}"
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
                                        @if($menuElement->smeSlug === 'link')
                                            <option value="link" selected>Link</option>
                                        @else
                                            <option value="link">Link</option>
                                        @endif
                                        @if($menuElement->smeSlug === 'title')
                                            <option value="title" selected>Title</option>
                                        @else
                                            <option value="title">Title</option>
                                        @endif
                                        @if($menuElement->smeSlug === 'dropdown')
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
                                            value="{{ $menuElement->smeHref }}"
                                        />
                                    </div>
                                    <br><br>
                                    <div id="div-dropdown-parent">
                                        Dropdown parent:
                                        <input type="hidden" id="parentId" value="{{ $menuElement->smeParent_id }}"/>
                                        <select class="form-control" name="parent" id="parent">

                                        </select>
                                    </div>
                                    <br><br>
                                    <div hidden id="div-icon">
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
                                            value="{{ $menuElement->smeIcon }}"
                                        >
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-info" type="submit">Save</button>
                    <a class="btn btn-warning text-white" href="{{ route('site.menu.index', ['menu' => $menuElement->smeMenu_id]) }}">Return</a>
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
<script src="{{ asset('js/axios.min.js') }}"></script> 
<script src="{{ asset('js/site-menu-edit.js') }}"></script> 



@endsection