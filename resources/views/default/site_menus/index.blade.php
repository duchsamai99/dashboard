@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>List of site menus</h4></div>
            <div class="card-body">
                <div class="row mb-3 ml-1">
                    <a class="btn btn-lg btn-info" href="{{ route('site.menu.create') }}">Add new site menu</a>
                </div>
                @if(Session::has('message_success'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message_success') }}</div>
                @elseif(Session::has('message_fail'))
                  <div class="alert alert-danger" role="alert">{{ Session::get('message_fail') }}</div>
                @endif
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>href</th>
                            <!-- <th>Sequence</th>
                            <th></th>
                            <th></th> -->
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($menuToEdit as $menuel)
                    <!-- delete modal -->
                    <form action="{{ route('site.menu.delete', ['id' => $menuel['id']]) }}" method="POST" enctype="multiple/form-data">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}  
                        <div id="ModalDelete{{$menuel['id']}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" style="width:55%" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation message</h4>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Do you want to delete this record?</p>
                                        <input type="hidden" name="id" value="{{$menuel['id']}}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn text-white bg-warning" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn text-white bg-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end delete modal -->
                    @if($menuel['slug'] === 'link')
                        <tr>
                            <td>
                                @if($menuel['hasIcon'] === true)
                                    @if($menuel['iconType'] === 'coreui')
                                    <svg class="c-nav-icon edit-menu-icon">
                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}"></use>
                                    </svg> 
                                    <i class="{{ $menuel['icon'] }}"></i> 
                                    @endif
                                @endif 
                            </td>
                            <td>
                                {{ $menuel['slug'] }}
                            </td>
                            <td>
                                {{ $menuel['name'] }}
                            </td>
                            <td>
                                {{ $menuel['href'] }}
                            </td>
                            
                            <td>
                                <a class="btn btn-info" href="{{ route('site.menu.show', ['id' => $menuel['id']]) }}">Show</a>
                            </td>
                            <td>
                                <a class="btn btn-warning text-white" href="{{ route('site.menu.edit', ['id' => $menuel['id']]) }}">Edit</a>
                            </td>
                            <td>
                                <a class="btn text-white btn-danger" id="submit" data-id="$menuel['id']" data-toggle="modal" data-target="#ModalDelete{{$menuel['id']}}">Delete</a>
                            </td>
                        </tr>
                    @elseif($menuel['slug'] === 'dropdown')
                    <tr>
							<td>
								@if($menuel['hasIcon'] === true)
									@if($menuel['iconType'] === 'coreui')
										<svg class="c-nav-icon edit-menu-icon">
											<use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}"></use>
										</svg> 
										<i class="{{ $menuel['icon'] }}"></i> 
									@endif
								@endif 
							</td>
							<td>
								{{ $menuel['slug'] }}
							</td>
							<td>
								{{ $menuel['name'] }}
							</td>
							<td>
							<td>
								<a class="btn btn-info" href="{{ route('menu.show', ['id' => $menuel['id']]) }}">Show</a>
							</td>
							<td>
								<a class="btn btn-warning text-white" href="{{ route('site.menu.edit', ['id' => $menuel['id']]) }}">Edit</a>
							</td>
							<td>
								<a class="btn text-white btn-danger" id="submit" data-id="$menuel['id']" data-toggle="modal" data-target="#ModalDelete{{$menuel['id']}}">Delete</a>
							</td>
						</tr>
                        @if (array_key_exists('elements', $menuel) && count($menuel['elements']) > 0)
								@foreach($menuel['elements'] as $item)
								<!-- delete modal -->
								<form action="{{ route('menu.delete', ['id' => $item['id']]) }}" method="POST" enctype="multiple/form-data">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}  
									<div id="ModalDelete{{$item['id']}}" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog" style="width:55%" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Confirmation message</h4>
													<button type="button" class="close" data-dismiss="modal">×</button>
												</div>
												<div class="modal-body">
													<p>Do you want to delete this record?</p>
													<input type="hidden" name="id" value="{{$item['id']}}">
												</div>
												<div class="modal-footer">
													<button type="button" class="btn text-white bg-warning" data-dismiss="modal">Cancel</button>
													<button type="submit" class="btn text-white bg-danger">Delete</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<tr>
									<td>
										@if($item['hasIcon'] === true)
											@if($item['iconType'] === 'coreui')
												<svg class="c-nav-icon edit-menu-icon">
													<use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $item['icon'] }}"></use>
												</svg> 
												<i class="{{ $item['icon'] }}"></i> 
											@endif
										@endif 
									</td>
									<td>
										{{ $item['slug'] }}
									</td>
									<td>
										{{ $item['name'] }}
									</td>
									<td>
										@if (array_key_exists('href', $item))
											{{ $item['href'] }}
										@endif
									</td>
									<td>
										<a class="btn btn-info" href="{{ route('menu.show', ['id' => $item['id']]) }}">Show</a>
									</td>
									<td>
										<a class="btn btn-warning text-white" href="{{ route('site.menu.edit', ['id' => $item['id']]) }}">Edit</a>
									</td>
									<td>
										<a class="btn text-white btn-danger" id="submit" data-id="$item['id']" data-toggle="modal" data-target="#ModalDelete{{$item['id']}}">Delete</a>
									</td>
								</tr>
								@endforeach
							@endif
                    @elseif($menuel['slug'] === 'title')
                        <tr>
                            <td>
                                @if($menuel['hasIcon'] === true)
                                    @if($menuel['iconType'] === 'coreui')
                                        <svg class="c-nav-icon edit-menu-icon">
                                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}"></use>
                                        </svg> 
                                        <i class="{{ $menuel['icon'] }}"></i> 
                                    @endif
                                @endif 
                            </td>
                            <td>
                                {{ $menuel['slug'] }}
                            </td>
                            <td>
                                {{ $menuel['name'] }}
                            </td>
                            <td>
                                
                            </td>
                            <!-- <td>
                                {{ $menuel['sequence'] }}
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('site.menu.up', ['id' => $menuel['id']]) }}">
                                    <i class="cil-arrow-thick-top"></i> 
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('site.menu.down', ['id' => $menuel['id']]) }}">
                                    <i class="cil-arrow-thick-bottom"></i>  
                                </a>
                            </td> -->
                            <td>
                                <a class="btn btn-info" href="{{ route('site.menu.show', ['id' => $menuel['id']]) }}">Show</a>
                            </td>
                            <td>
                                <a class="btn btn-warning text-white" href="{{ route('site.menu.edit', ['id' => $menuel['id']]) }}">Edit</a>
                            </td>
                            <td>
                                <a class="btn text-white btn-danger" id="submit" data-id="$menuel['id']" data-toggle="modal" data-target="#ModalDelete{{$menuel['id']}}">Delete</a>
                            </td>
                        </tr>
                    @endif
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