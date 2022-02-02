<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Menurole;  
use App\Models\MenuRoleSiteMenu;    
use App\Models\SiteMenu;    
use App\Http\Menus\GetSidebarMenu;
use App\Models\Menulist;
use App\Models\Menus;
use App\Models\Action;
use App\Models\AdminMenuRole;
use App\Services\RolesService;
use App\Services\RolesServiceSiteMenu;
use App\Http\Menus\PermissionMenu;
use Spatie\Permission\Models\Role;
use App\Models\SiteDescription;
class AdminMenuRoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['admin_menu_id' => $request->current_menu_id]);
    }

    public function index(Request $request){
        if($request->has('menu')){
            $menuId = $request->input('menu');
        }else{
            $menuId = Menulist::first();
            if(empty($menuId)){
                $menuId = 1;
            }else{
                $menuId = $menuId->id;
            }
        }
        $getSidebarMenu = new GetSidebarMenu();
        return view('default.admin_menus.index', array(
            'menulist'      => Menulist::all(),
            'role'          => 'admin',
            'roles'         => RolesService::get(),
            'menuToEdit'    => $getSidebarMenu->getAll( $menuId ),
            'thisMenu'      => $menuId,
        ));
    }

    public function moveUp(Request $request){
        $element = Menus::where('id', '=', $request->input('id'))->first();
        $switchElement = Menus::where('menu_id', '=', $element->menu_id)
            ->where('sequence', '<', $element->sequence)
            ->orderBy('sequence', 'desc')->first();
        if(!empty($switchElement)){
            $temp = $element->sequence;
            $element->sequence = $switchElement->sequence;
            $switchElement->sequence = $temp;
            $element->save();
            $switchElement->save();
        }
        return redirect()->route('site.menu.index', ['menu' => $element->menu_id ]);
    }

    public function moveDown(Request $request){
        $element = Menus::where('id', '=', $request->input('id'))->first();
        $switchElement = Menus::where('menu_id', '=', $element->menu_id)
            ->where('sequence', '>', $element->sequence)
            ->orderBy('sequence', 'asc')->first();
        if(!empty($switchElement)){
            $temp = $element->sequence;
            $element->sequence = $switchElement->sequence;
            $switchElement->sequence = $temp;
            $element->save();
            $switchElement->save();
        }
        return redirect()->route('site.menu.index', ['menu' => $element->menu_id ]);
    }
    public function getParents(Request $request){
        $menuId = $request->input('menu');
        $result = Menus::where('menus.menu_id', '=', $menuId)
            ->where('menus.slug', '=', 'dropdown')
            ->orderBy('menus.sequence', 'asc')->get();
        return response()->json(
            $result
        ); 
    }
    public function create(){
        return view('default.admin_menus.create',[
            'roles'    => RolesServiceSiteMenu::get(),
            'menulist' => Menulist::all(),
            'actions' => Action::all(),

        ]);
    }

    public function getValidateArray(){
        $result = [
            'menu' => 'required|numeric',
            'role' => 'required|array',
            'type' => [
                'required',
                Rule::in(['link', 'title', 'dropdown']),
            ],
        ];
        return $result;
    }

    public function getNextSequence( $menuId ){
        $result = Menus::select('menus.sequence')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.sequence', 'desc')->first();
        if(empty($result)){
            $result = 1;
        }else{
            $result = (integer)$result['sequence'] + 1;
        }
        return $result;
    }

    public function store(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('admin_menu_id'), null, "insert");
		if($permission_menu['status'] == true){
            $menus = new Menus();
            $menus->slug = $request->input('type');
            $menus->menu_id = $request->input('menu');
            $menus->name = $request->input('name');
            if(strlen($request->input('icon')) > 0){
                $menus->icon = $request->input('icon');
            }
            $menus->href = $request->input('href');
            //if($request->input('type') !== 'title' && $request->input('parent') !== 'none'){
            $menus->parent_id = $request->input('parent');
            //}
            //$menus->parent_id = $request->input('parent');
            $menus->sequence = $this->getNextSequence( $request->input('menu') );
            $menus->save();
            foreach($request->input('role') as $role){
                $view =  0;
                $insert =  0;
                $edit =  0;
                $delete =  0;
                foreach($request->action as $action){
                    
                    $getRole = json_decode($role);
                    $getAction = json_decode($action);
                    if($getRole->id == $getAction->actRoleID){
                        if($getAction->actName == "Insert"){
                            $insert =1;
                        }
                        if($getAction->actName == "View"){
                            $view = 1;
                        }
                        if($getAction->actName == "Edit"){
                            $edit =1;
                        }
                        if($getAction->actName == "Delete"){
                            $delete =1;
        
                        }
                    }   
                }
                $menuRole = new AdminMenuRole();
                $menuRole->amrRoleID = $getRole->id;
                $menuRole->amrRoleName = $getRole->name;
                $menuRole->amrMenusID = $menus->id;
                $menuRole->amrView = $view;
                $menuRole->amrInsert = $insert;
                $menuRole->amrDelete = $delete;
                $menuRole->amrUpdate = $edit;
                $menuRole->save();
                
            }
            
            $request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('menu.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('menu.create');
		}
    }

    public function edit(Request $request){
        $menu = Menus::where('id', '=', $request->input('id'))->first();
        $roles = RolesServiceSiteMenu::get();
        $get_role_without_menu_roles = [];
        $get_role_menu_roles = [];
        $menu_lists = Menulist::all();
        $actions = Action::all();
        $menu_roles = AdminMenuRole::where('amrMenusID', '=', $menu->id)->get();
        foreach($roles as $role){
            $menu_role = AdminMenuRole::where('amrMenusID', '=',  $menu->id)->where('amrRoleID', '=', $role->id)->get();
            if(count($menu_role) ==0){
                $role_withou_menu_role = Role::where('id', '=', $role->id)->first();
                array_push( $get_role_without_menu_roles, $role_withou_menu_role);

            }else{
                $role_menu_role = Role::where('id', '=', $role->id)->first();
                array_push( $get_role_menu_roles, $role_menu_role);
            }
        }
        return view('default.admin_menus.edit',[
            'get_role_menu_roles'    => $get_role_menu_roles,
            'menulist' => $menu_lists,
            'actions' => $actions,
            'menuElement' => $menu,
            'menuroles' => $menu_roles,
            'get_role_without_menu_roles' => $get_role_without_menu_roles
        ]);
    }

    public function update(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('admin_menu_id'), null,"update");
		if($permission_menu['status'] == true){
            $menus = menus::where('id', '=', $request->input('id'))->first();
            $menus->slug = $request->input('type');
            $menus->menu_id = $request->input('menu');
            $menus->name = $request->input('name');
            if(strlen($request->input('icon')) > 0){
                $menus->icon = $request->input('icon');
            }
            if(strlen($request->input('href')) > 0){
                $menus->href = $request->input('href');
            }
            //if($request->input('type') !== 'title' && $request->input('parent') !== 'none'){
            $menus->parent_id = $request->input('parent');
            // }else{

            // }
            $menus->sequence = $this->getNextSequence( $request->input('menu') );
            $menus->save();
            AdminMenuRole::where('amrMenusID', '=', $request->input('id'))->delete();
            foreach($request->role as $role){
                $view =  0;
                $insert =  0;
                $edit =  0;
                $delete =  0;
                foreach($request->action as $action){
                    
                    $getRole = json_decode($role);
                    $getAction = json_decode($action);
                    if($getRole->id == $getAction->actRoleID){
                        if($getAction->actName == "Insert"){
                            $insert =1;
                        }
                        if($getAction->actName == "View"){
                            $view = 1;
                        }
                        if($getAction->actName == "Edit"){
                            $edit =1;
                        }
                        if($getAction->actName == "Delete"){
                            $delete =1;
        
                        }
                    }   
                }
                $menuRole = new AdminMenuRole();
                $menuRole->amrRoleID = $getRole->id;
                $menuRole->amrRoleName = $getRole->name;
                $menuRole->amrMenusID = $menus->id;
                $menuRole->amrView = $view;
                $menuRole->amrInsert = $insert;
                $menuRole->amrDelete = $delete;
                $menuRole->amrUpdate = $edit;
                $menuRole->save();
                
            }
            $request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('menu.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('menu.edit',['id'=>$request->input('id')]);
		}

    }

    public function show(Request $request){
        // $menu_element_by_autoId = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
        // $language = App::getLocale();
        // $menuElement = SiteMenu::join('tbl_site_menus as mparent', 'tbl_site_menus.smeParent_id', '=', 'mparent.smeAutoID')
        // ->select('tbl_site_menus.*', 'mparent.smeName as parent_name')
        // // ->where('tbl_site_menus.smeLang', '=', $language)
        // ->where('tbl_site_menus.smeID', '=', $menu_element_by_autoId->smeID)->first();
        // if(empty($menuElement)){
        //     $menuElement = SiteMenu::where('smeID', '=', $menu_element_by_autoId->smeID)
        //     // ->where('smeLang', '=', $language)
        //     ->first();
        // }
        // $menuId = $menuElement->smeID;
        // $menu_roles = AdminMenuRole::where('amrMenusID', '=', $menuId)->get();
        // return view('default.admin_menus.show',[
        //     'menulist' => Menulist::all(),
        //     'menuElement' => $menuElement,
        //     'menuroles' => $menu_roles
        // ]);

        $menuElement = Menus::join('menus as mparent', 'menus.parent_id', '=', 'mparent.id')
        ->select('menus.*', 'mparent.name as parent_name')
        ->where('menus.id', '=', $request->input('id'))->first();
        if(empty($menuElement)){
            $menuElement = Menus::where('id', '=', $request->input('id'))->first();
        }
        return view('default.admin_menus.show',[
            'menulist' => Menulist::all(),
            'menuElement' => $menuElement,
            'menuroles' => AdminMenuRole::where('amrMenusID', '=', $request->input('id'))->get()
        ]);
       
    }

    public function delete(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('admin_menu_id'), null,"delete");
		if($permission_menu['status'] == true){
            $menus = menus::where('id', '=', $request->input('id'))->first();
            $delete_menus = menus::where('id', '=', $request->input('id'))->delete();
            AdminMenuRole::where('amrMenusID', '=', $menus->id)->delete();
            $request->session()->flash('message_success', 'Successfully delete admin menu');
            $request->session()->flash('backParams', ['menu' => $menus->id]);
            return redirect()->route('menu.index');
            
            $request->session()->flash('message_success', $permission_menu['message']);
            return redirect()->route('menu.index');
        }else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('menu.index'); 
		}

    }

}
