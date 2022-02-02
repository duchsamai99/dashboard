<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AdminMenuRole;
use App\Http\Menus\PermissionMenu;
use App\Models\Menus;
use Spatie\Permission\Models\Role;
class UsersController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['role_menu_id' => $request->current_menu_id]);
        session(['user_name_menu' => $request->current_menu_name]);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user();
        $users = User::all();
        return view('default.users.usersList', compact('users', 'you'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('default.users.userShow', compact( 'user' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('default.users.userCreate',[
            'roles'    => Role::all(),
        ]);
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
		$permission_menu = $permission_action->permission(6, null, "insert");
		if($permission_menu['status'] == true){
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',  
            ]);
            
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->email_verified_at = $request->input('email_verified_at');
            $user->menuroles = $request->input('role');
            $user->remember_token = $request->input('remember_token');
            $user->assignRole($request->input('role'));
            $user->save();
            
            $request->session()->flash('message_success', $permission_menu['message']);
            $you = auth()->user();
            $users = User::all();
            return view('default.users.usersList', compact('users', 'you'));
        }else{
            $request->session()->flash("message_fail", $permission_menu['message']);
            return view('default.users.userCreate');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $role = auth()->user();
        $current_role_id = $role['id'];
        $role_permission = AdminMenuRole::where('amrRoleID', $current_role_id )->where( 'amrMenusID', session('role_menu_id') )->first();
        $user = User::find($id);
        return view('default.users.userEditForm', compact('user', 'role_permission'));
    }
    public function cropProfile(Request $request)
    {
        $folderPath = public_path('uploads/users/');
        $image_parts = explode(";base64,", $request->profileImage);
        // return response()->json(['data'=>$image_parts]);

        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . date('YmdHis'). '.jpeg';
        file_put_contents($file, $image_base64);

        return response()->json(['data'=>date('YmdHis') . '.jpeg']);
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
        $permission_menu = $permission_action->permission(6, null,"update");
        if($permission_menu['status'] == true){
            $user = User::find($id);
            $user->name          = $request->name;
            $user->email         = $request->email;
            if($user->password != $request->password){
                $user->password      = $request->password;

            }else{
                $user->password      = $user->password;

            }
            if($request->image !=""){
                $user->image      = $request->image;
            }
            $user->save();
            $request->session()->flash("message_success", $permission_menu['message']);
			return response()->json($permission_menu['status']);

		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}  
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission( 6, null,"delete");
		if($permission_menu['status'] == true){
            $user = User::find($id);
            if($user){
                $user->delete();
            }
            $request->session()->flash("message_success", $permission_menu['message']);
			return redirect()->route('users.index'); 
        }else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('users.index'); 
		}
    }
}
