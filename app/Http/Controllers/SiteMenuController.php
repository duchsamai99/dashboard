<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use App\Models\AdminMenuRole;
use App\Models\Menurole;  
use App\Models\MenuRoleSiteMenu;    
use App\Models\SiteMenu;    
use App\Http\Menus\GetSidebarMenu;
use App\Models\Menulist;
use App\Models\Menus;
use App\Models\Action;
use App\Services\RolesService;
use App\Services\RolesServiceSiteMenu;
use App\Http\Menus\PermissionMenu;
use Spatie\Permission\Models\Role;


class SiteMenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['site_menu_id' => $request->current_menu_id]);
    }

    public function index(Request $request){
        // $language = App::getLocale();
        // $slides = DB::table('tbl_slides')->where('sliLang', $language)->get();
        // return view('project.slides.index', array(
        //     'slides'  => $slides
        // ));

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
        return view('default.site_menus.index', array(
            'menulist'      => Menulist::all(),
            'role'          => 'admin',
            'roles'         => RolesService::get(),
            'menuToEdit'    => $getSidebarMenu->getAllSiteMenu( $menuId ),
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
        $language = App::getLocale();
        $menuId = $request->input('menu');
        $result = SiteMenu::where('smeMenu_id', '=', $menuId)
            ->where('smeSlug', '=', 'dropdown')
            ->where('smeLang', '=', $language)
            ->orderBy('smeAutoID', 'asc')->get();
        return response()->json(
            $result
        ); 
    }
    public function create(){
        return view('default.site_menus.create',[
            'roles'    => RolesServiceSiteMenu::get(),
            'menulist' => Menulist::all()

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
		$permission_menu = $permission_action->permission(session('site_menu_id'), null, "insert");
		if($permission_menu['status'] == true){
            $languages = Config::get('languages');
            $site_menu_last = SiteMenu::all()->last();
            $smeID = 0;
            if($site_menu_last == null){
                $smeID = 1;
            }else{
                $smeID = $site_menu_last->smeID + 1;
            }
            foreach($languages as $language){
                $menus = new SiteMenu();
                $menus->smePageName = '/pages';
                $menus->smeLang = $language['value'];
                $menus->smeID = $smeID;
                $menus->smeOrder = 1;
                $menus->smeSlug = $request->input('type');
                $menus->smeMenu_id = $request->input('menu');
                $menus->smeName = $request->input('name');
                if(strlen($request->input('icon')) > 0){
                    $menus->smeIcon = $request->input('icon');
                }
                if(strlen($request->input('href')) > 0){
                    $menus->smeHref = $request->input('href');
                }
                //if($request->input('type') !== 'title' && $request->input('parent') !== 'none'){
                $menus->smeParent_id = $request->input('parent');
                //}
                $menus->sequence = $this->getNextSequence( $request->input('menu') );
                $menus->save();
            }
            
            $request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('site.menu.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('site.menu.create');
		}
    }

    public function edit(Request $request){
        $site_menu_by_autoId = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
        $language = App::getLocale();
        $site_menu = DB::table('tbl_site_menus')->where('smeLang', $language)->where('smeID', $site_menu_by_autoId->smeID)->first();
        $menu_lists = Menulist::all();
        $menu_roles = MenuroleSiteMenu::where('merMenusID', '=', $site_menu_by_autoId->smeID)->get();
        return view('default.site_menus.edit',[
            'menulist' => $menu_lists,
            'menuElement' => $site_menu,
            'menuroles' => $menu_roles,
        ]);
    }

    public function update(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('site_menu_id'), null,"update");
		if($permission_menu['status'] == true){
            $menus = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
            $menus->smeAutoID = $request->input('id');
            $menus->smePageName = "/page";
            $menus->smeLang = $menus->smeLang;
            $menus->smeID = $menus->smeID;
            $menus->smeOrder = $menus->smeOrder;
            $menus->smeSlug = $request->input('type');
            $menus->smeMenu_id = $request->input('menu');
            $menus->smeName = $request->input('name');
            if(strlen($request->input('icon')) > 0){
                $menus->smeIcon = $request->input('icon');
            }
            if(strlen($request->input('href')) > 0){
                $menus->smeHref = $request->input('href');
            }
            //if($request->input('type') !== 'title' && $request->input('parent') !== ''){
            $menus->smeParent_id = $request->input('parent');
            //}
            $menus->save();
            $site_menu_by_autoId = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
            MenuroleSiteMenu::where('merMenusID', '=', $site_menu_by_autoId->smeID)->delete();
            $request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('site.menu.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('site.menu.edit', ['id'=>$request->input('id')]);
		}

    }

    public function show(Request $request){
        $menu_element_by_autoId = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
        $language = App::getLocale();
        $menuElement = SiteMenu::join('tbl_site_menus as mparent', 'tbl_site_menus.smeParent_id', '=', 'mparent.smeAutoID')
        ->select('tbl_site_menus.*', 'mparent.smeName as parent_name')
        ->where('tbl_site_menus.smeLang', '=', $language)
        ->where('tbl_site_menus.smeID', '=', $menu_element_by_autoId->smeID)->first();
        if(empty($menuElement)){
            $menuElement = SiteMenu::where('smeID', '=', $menu_element_by_autoId->smeID)
            ->where('smeLang', '=', $language)
            ->first();
        }
        $menuId = $menuElement->smeID;
        $menu_roles = MenuroleSiteMenu::where('merMenusID', '=', $menuId)->get();
        return view('default.site_menus.show',[
            'menulist' => Menulist::all(),
            'menuElement' => $menuElement,
            'menuroles' => $menu_roles
        ]);
       
    }

    public function delete(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('site_menu_id'), null,"delete");
		if($permission_menu['status'] == true){
            $menus = SiteMenu::where('smeAutoID', '=', $request->input('id'))->first();
            $menuId = $menus->merMenusID;
            $smeID = $menus->smeID;
            SiteMenu::where('smeID', '=', $menus->smeID)->delete();

            $menus->delete();
            MenuroleSiteMenu::where('merMenusID', '=', $smeID)->delete();
            $request->session()->flash('message_success', $permission_menu['message']);
            return redirect()->route('site.menu.index');
        }else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('site.menu.index'); 
		}

    }

}
