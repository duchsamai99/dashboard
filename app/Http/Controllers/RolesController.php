<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Menus\PermissionMenu;
use App\Models\Menurole;
use App\Models\Action;
use App\Models\AdminMenuRole;
use App\Models\RoleHierarchy;

class RolesController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['role_menu_id' => $request->current_menu_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table('roles')
        ->leftJoin('role_hierarchy', 'roles.id', '=', 'role_hierarchy.role_id')
        ->select('roles.*', 'role_hierarchy.hierarchy')
        ->orderBy('hierarchy', 'asc')
        ->get();
        return view('default.roles.index', array(
            'roles' => $roles,
        ));
    }

    public function moveUp(Request $request){
        $element = RoleHierarchy::where('role_id', '=', $request->input('id'))->first();
        $switchElement = RoleHierarchy::where('hierarchy', '<', $element->hierarchy)
            ->orderBy('hierarchy', 'desc')->first();
        if(!empty($switchElement)){
            $temp = $element->hierarchy;
            $element->hierarchy = $switchElement->hierarchy;
            $switchElement->hierarchy = $temp;
            $element->save();
            $switchElement->save();
        }
        return redirect()->route('roles.index');
    }

    public function moveDown(Request $request){
        $element = RoleHierarchy::where('role_id', '=', $request->input('id'))->first();
        $switchElement = RoleHierarchy::where('hierarchy', '>', $element->hierarchy)
            ->orderBy('hierarchy', 'asc')->first();
        if(!empty($switchElement)){
            $temp = $element->hierarchy;
            $element->hierarchy = $switchElement->hierarchy;
            $switchElement->hierarchy = $temp;
            $element->save();
            $switchElement->save();
        }
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('default.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('role_menu_id'), null, "insert");
		if($permission_menu['status'] == true){
            $role = new Role();
            $role->name = $request->input('name');
            $role->save();
            $array_actions = ['Insert', 'View', 'Edit', 'Delete'];
            foreach($array_actions as $value){
                $action = new Action();
                $action->actRoleID = $role->id;
                $action->actName   = $value;
                $action->actValue  = 0;
                $action->save();

            }

            $hierarchy = RoleHierarchy::select('hierarchy')
            ->orderBy('hierarchy', 'desc')->first();
            if(empty($hierarchy)){
                $hierarchy = 0;
            }else{
                $hierarchy = $hierarchy['hierarchy'];
            }
            $hierarchy = ((integer)$hierarchy) + 1;
            $roleHierarchy = new RoleHierarchy();
            $roleHierarchy->role_id = $role->id;
            $roleHierarchy->hierarchy = $hierarchy;
            $roleHierarchy->save();
            $request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('roles.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('roles.create');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('default.roles.show', array(
            'role' => Role::where('id', '=', $id)->first()
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('default.roles.edit', array(
            'role' => Role::where('id', '=', $id)->first()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('role_menu_id'), null,"update");
		if($permission_menu['status'] == true){
            $role = Role::where('id', '=', $id)->first();
            $role->name = $request->input('name');
            $role->save();
            
            $request->session()->flash("message_success", $permission_menu['message']);
            return redirect()->route('roles.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('roles.edit', $id); 
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('role_menu_id'), null,"delete");
		if($permission_menu['status'] == true){
            $role = Role::where('id', '=', $id)->first();
            $roleHierarchy = RoleHierarchy::where('role_id', '=', $id)->first();
            $menuRole = AdminMenuRole::where('amrRoleName', '=', $role->name)->first();
            if(!empty($menuRole)){
                $request->session()->flash('message_fail', "Can't delete. Role has assigned one or more admin menus.");
                return redirect()->route('roles.index');
            }else{
                $role->delete();
                $roleHierarchy->delete();
                $request->session()->flash("message_success", $permission_menu['message']);
                return redirect()->route('roles.index');
            }
               
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('roles.index'); 
		}
    }
}
