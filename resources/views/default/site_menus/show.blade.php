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
                                        @if($menu1->id == $menuElement->smeMenu_id  )
                                            {{ $menu1->name }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Type
                                </th>
                                <td>
                                    {{ $menuElement->smeSlug }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Href:
                                </th>
                                <td>
                                    {{ $menuElement->smeHref}}
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
                                    <i class="{{ $menuElement->smeIcon }}"></i>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $menuElement->smeIcon }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-warning text-white" href="{{ route('site.menu.index', ['menu' => $menuElement->smeMenu_id]) }}">Return</a>
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