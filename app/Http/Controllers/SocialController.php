<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Http\Menus\PermissionMenu;
use Illuminate\Http\Request;
use App\Models\AdminMenuRole;

class SocialController extends Controller
{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(Request $request)
	{
			$this->middleware('auth');
			session(['social_menu_id' => $request->current_menu_id]);

	}
	// list all data
	public function index(Request $request){
			$language = App::getLocale();
			$socials = DB::table('tbl_socials')->where('socLang', $language)->get();
			return view('default.socials.index', array(
					'socials'  => $socials
			));
	}
	// view form create
	public function create(){
			return view('default.socials.create',[]);
	}
	// crop image
	public function cropImage(Request $request){
			$folderPath = public_path('uploads/');
			$image_parts = explode(";base64,", $request->socImage);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$file = $folderPath . date('YmdHis'). '.jpeg';
			file_put_contents($file, $image_base64);

			return response()->json(['data'=>date('YmdHis') . '.jpeg']);
	}
	// create data
	public function store(Request $request){ 
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('social_menu_id'), null, "insert");
		if($permission_menu['status'] == true){
			$languages = Config::get('languages');
			$social_last = Social::all()->last();
			$socID = 0;
			if($social_last == null){
				$socID = 1;
			}else{
				$socID = $social_last->socID + 1;
			}
			foreach($languages as $language){
				$social = new Social();
				$social->socLang = $language['value'];
				$social->socID = $socID;
				$social->socTitle = $request->socTitle;
				$social->socDescription = $request->socDescription;
				$social->socFollower = $request->socFollower;
				$social->socSign = $request->socSign;
				$social->socStatus = $request->socStatus;
				$social->socOrder = $request->socOrder;
				$social->socImage = $request->socImage;

				$social->save();
			}
			$request->session()->flash("message_success", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}
	}
	
	// view form edit data
	public function edit($id){
		$social_by_autoId = Social::where('socAutoID', '=', $id)->first();
		$language = App::getLocale();
		$social = DB::table('tbl_socials')->where('socLang', $language)->where('socID', $social_by_autoId->socID)->first();
		return view('default.socials.edit',[
			'social'  => $social 
		]);
	}
	
	// update data
	public function update(Request $request , $id){
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('social_menu_id'), null,"update");
		if($permission_menu['status'] == true){
			$social_by_autoId = Social::where('socAutoID', '=', $id)->first();
			$social_id = $social_by_autoId->socID;
			$socials = Social::where('socID', $social_id)->get();
			foreach($socials as $value){
				if($id == $value->socAutoID){
					DB::table('tbl_socials')->where('socAutoID', $value->socAutoID)->update([
						'socAutoID'      => $value->socAutoID,
						'socLang'        => $value->socLang,
						'socTitle'       => $request->socTitle,
						'socDescription' => $request->socDescription,
						'socFollower'    => $request->socFollower,
						'socSign'        => $request->socSign,
						'socStatus'      => $request->socStatus,
						'socOrder'       => $request->socOrder,
						'socID'          => $social_id,
						'socImage'       => $request->socImage,
					]);  
				}else{
					DB::table('tbl_socials')->where('socAutoID', $value->socAutoID)->update([
						'socAutoID'      => $value->socAutoID,
						'socLang'        => $value->socLang,
						'socTitle'       => $value->socTitle,
						'socDescription' => $value->socDescription,
						'socFollower'    => $value->socFollower,
						'socSign'        => $value->socSign,
						'socStatus'      => $request->socStatus,
						'socID'          => $social_id,
						'socImage'       => $request->socImage,
						'socOrder'       => $request->socOrder,

					]); 
				
				}
			}
			$request->session()->flash("message_success", $permission_menu['message']);
			return response()->json($permission_menu['status']);

		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}
	}

	// view detail
	public function show($id){
		$social_by_autoId = Social::where('socAutoID', '=', $id)->first();
		$language = App::getLocale();
		$social = DB::table('tbl_socials')->where('socLang', $language)->where('socID', $social_by_autoId->socID)->first();
		return view('default.socials.show',[
			'social'  => $social 
		]);
	}
	
	// delete data
	public function destroy(Request $request){
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('social_menu_id'), null, "delete");
		if($permission_menu['status'] == true){
			$social = Social::where('socAutoID', '=', $request->input('socAutoID'))->first();
			Social::where('socID', '=', $social->socID)->delete();
			$request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('socials.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('socials.index');
		}
		
	}
}
