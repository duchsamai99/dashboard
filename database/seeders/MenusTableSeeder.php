<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    private $menuId = null;
    private $dropdownId = array();
    private $dropdown = false;
    private $sequence = 1;
    private $joinData = array();
    private $adminRole = null;
    private $userRole = null;
    private $subFolder = '';

    public function join($roles, $menusId){
        // dd($role);
        // $roles = explode(',', $roles);
        foreach($roles as $role){
            array_push($this->joinData, array($role, 'menus_id' => $menusId));
        }
    }

    /*
        Function assigns menu elements to roles
        Must by use on end of this seeder
    */
    public function joinAllByTransaction(){
        DB::beginTransaction();
        foreach($this->joinData as $data){
            $role_id = $data[0]['id'];
            $role_name = $data[0]['name'];
            DB::table('tbl_admin_menu_roles')->insert([
                'amrRoleID' => $role_id,
                'amrRoleName' => $role_name,
                'amrMenusID' => $data['menus_id'],
                'amrView' => 1,
                'amrInsert' => 1,
                'amrUpdate' => 1,
                'amrDelete' => 1,
            ]);
        } 
        DB::commit();
    }

    public function insertLink($roles, $name, $href, $icon = null){
        $href = $this->subFolder . $href;
        if($this->dropdown === false){
            DB::table('menus')->insert([
                'slug' => 'link',
                'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'sequence' => $this->sequence
            ]);
        }else{
            DB::table('menus')->insert([
                'slug' => 'link',
                'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'parent_id' => $this->dropdownId[count($this->dropdownId) - 1],
                'sequence' => $this->sequence
            ]);
        }
        $this->sequence++;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        $permission = Permission::where('name', '=', $name)->get();
        if(empty($permission)){
            $permission = Permission::create(['name' => 'visit ' . $name]);
        }
        // $roles = explode(',', $roles);
        if(in_array('user', $roles)){
            $this->userRole->givePermissionTo($permission);
        }
        if(in_array('admin', $roles)){
            $this->adminRole->givePermissionTo($permission);
        }
        return $lastId;
    }

    public function insertTitle($roles, $name){
        DB::table('menus')->insert([
            'slug' => 'title',
            'name' => $name,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence
        ]);
        $this->sequence++;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        return $lastId;
    }

    public function beginDropdown($roles, $name, $icon = ''){
        if(count($this->dropdownId)){
            $parentId = $this->dropdownId[count($this->dropdownId) - 1];
        }else{
            $parentId = null;
        }
        DB::table('menus')->insert([
            'slug' => 'dropdown',
            'name' => $name,
            'icon' => $icon,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence,
            'parent_id' => $parentId
        ]);
        $lastId = DB::getPdo()->lastInsertId();
        array_push($this->dropdownId, $lastId);
        $this->dropdown = true;
        $this->sequence++;
        $this->join($roles, $lastId);
        return $lastId;
    }

    public function endDropdown(){
        $this->dropdown = false;
        array_pop( $this->dropdownId );
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        /* Get roles */
        $this->adminRole = Role::where('name' , '=' , 'admin' )->first();
        $this->userRole = Role::where('name', '=', 'user' )->first();
        /* Create Sidebar menu */
        DB::table('menulist')->insert([
            'name' => 'sidebar menu'
        ]);
        $this->menuId = DB::getPdo()->lastInsertId();  //set menuId
        //seed default menu 
        $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'dashboard', '/', 'cil-speedometer');
        $this->insertLink([['id'=>'1','name'=>'admin'],['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Slide'     , '/slides'   , 'cil-calculator');
        // $this->insertLink([['id'=>'3','name'=>'guest']], 'Login'     , '/login'   , 'cil-account-logout');
        // $this->insertLink([['id'=>'3','name'=>'guest']], 'Register'  , '/register', 'cil-account-logout');
        $this->beginDropdown([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Settings', 'cil-calculator');
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Users',                   '/users');
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Roles',              '/roles');
            $this->insertLink([['id'=>'1','name'=>'admin']], 'Admin menu', '/menu'   , 'cil-align-center');
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Site Description' , '/site-descriptions'    , 'cil-sitemap'); 
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Site menu', '/site/menu'   , 'cil-align-center');
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Social' , '/socials'    , 'cil-sitemap'); 
            $this->insertLink([['id'=>'1','name'=>'admin'], ['id'=>'2','name'=>'user'],['id'=>'3','name'=>'guest']], 'Title', '/titles'   , 'cil-align-center'); 
        $this->endDropdown();   
       
        $this->joinAllByTransaction(); ///   <===== Must by use on end of this seeder
       
    }
}
