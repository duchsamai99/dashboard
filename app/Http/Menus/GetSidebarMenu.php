<?php
/*
*   07.11.2019
*   MenusMenu.php
*/
namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;
use App\Models\SiteMenu;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\MenuBuilder\RenderFromDatabaseDataSiteMenu;
use App\MenuBuilder\RenderFromDatabaseData;

class GetSidebarMenu implements MenuInterface{

    private $mb; //menu builder
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuId, $menuName){
        $current_user = auth()->user();
        $menu_role = $current_user->menuroles;
        $role = Role::where('name',$menu_role )->first();
        if($current_user->type == 1){
            $this->menu = Menus::join('tbl_admin_menu_roles', 'menus.id', '=', 'tbl_admin_menu_roles.amrMenusID')
            ->select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->where('tbl_admin_menu_roles.amrRoleName', '=', $role->name)
            // ->where('tbl_admin_menu_roles.amrView', '=', 1)
            ->orderBy('menus.id', 'asc')->distinct()->get();   
        }else{
            $this->menu = Menus::join('tbl_admin_menu_roles', 'menus.id', '=', 'tbl_admin_menu_roles.amrMenusID')
            ->select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->where('tbl_admin_menu_roles.amrRoleName', '=', $role->name)
            ->where('tbl_admin_menu_roles.amrView', '=', 1)
            ->orderBy('menus.id', 'asc')->distinct()->get();   
        }
            
    }

    private function getGuestMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'guest');
    }

    private function getUserMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'user');
    }

    private function getAdminMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'admin');
    }

    public function get($role, $menuId=1){
        $this->getMenuFromDB($menuId, $role);
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
        /*
        $roles = explode(',', $roles);
        if(empty($roles)){
            $this->getGuestMenu( $menuId );
        }elseif(in_array('admin', $roles)){
            $this->getAdminMenu( $menuId );
        }elseif(in_array('user', $roles)){
            $this->getUserMenu( $menuId );
        }else{
            $this->getGuestMenu( $menuId );
        }
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
        */
    }

    public function getAll( $menuId=1 ){
        $this->menu = Menus::select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.id', 'asc')->get();  
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

        // $socials = DB::table('tbl_socials')->where('socLang', $language)->get();
        // return view('default.socials.index', array(
        //     'socials'  => $socials
        // ));
    public function getAllSiteMenu( $menuId=2 ){
        $language = App::getLocale();
        $this->menu = SiteMenu::select('tbl_site_menus.*')
            // ->where('tbl_site_menus.smeMenu_id', '=', 2)
            ->where('tbl_site_menus.smeLang', '=', $language)
            ->orderBy('tbl_site_menus.sequence', 'asc')->get();  
        $rfd = new RenderFromDatabaseDataSiteMenu;
        return $rfd->render($this->menu);
    }
}
