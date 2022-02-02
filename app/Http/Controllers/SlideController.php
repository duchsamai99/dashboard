<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\AdminMenuRole;
use App\Http\Menus\PermissionMenu;
use Illuminate\Http\Request;
use App\Models\SidebarMenu;
use App\Models\Slide;
use Illuminate\Validation\Rule;
class SlideController extends Controller
{
	//constructur
	public function __construct(Request $request)
	{
		$this->middleware('auth');
		session(['slide_menu_id' => $request->current_menu_id]);
	}

	// list data
	public function index(Request $request){
		$language = App::getLocale();
		$slides = DB::table('tbl_slides')->where('sliLang', $language)->get();
		return view('project.slides.index', array(
			'slides'  => $slides
		));
	}

	// view create form
	public function create(){
		return view('project.slides.create',[]);
	}

	// crop image
	public function crop(Request $request){
		$folderPath = public_path('uploads/');
		$image_parts = explode(";base64,", $request->sliImage);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$file = $folderPath . date('YmdHis'). '.jpeg';
		file_put_contents($file, $image_base64);
		$request->session()->flash('sliImage', date('YmdHis') . '.jpeg');
		return response()->json(['data'=>date('YmdHis') . '.jpeg']);
	}

	// sumit form create
	public function store(Request $request){ 
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('slide_menu_id'), null, "insert");
		if($permission_menu['status'] == true){
			$languages = Config::get('languages');
			$slide_last = Slide::all()->last();
			$sliID = 0;
			if($slide_last == null){
				$sliID = 1;
			}else{
				$sliID = $slide_last->sliID + 1;
			}
			foreach($languages as $language){
				$slide = new Slide();
				$slide->sliLang     = $language['value'];
				$slide->sliID       = $sliID;
				$slide->sliName     = $request->sliName;
				$slide->sliLink     = $request->sliLink;
				$slide->sliStatus   = $request->sliStatus;
				$slide->sliOrder    = $request->sliOrder;
				$slide->sliDescription = $request->sliDescription;
				$slide->sliImage = $request->sliImage;
				$slide->save();
			}
			$request->session()->flash("message_success", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}
	}
	// view edit form
	public function edit(Request $request){
		$slide_by_autoId = Slide::where('sliAutoID', '=', $request->sliAutoID)->first();
		$language = App::getLocale();
		$slid = DB::table('tbl_slides')->where('sliLang', $language)->where('sliID', $slide_by_autoId->sliID)->first();
		return view('project.slides.edit',[
			'slide'  => $slid
		]);
	}

	// submit form create
	public function update(Request $request){
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('slide_menu_id'), null, "update");
		$id = $request->sliAutoID;
		// return response()->json($permission_menu);
		if($permission_menu['status'] == true){
			$slide_by_autoId = Slide::where('sliAutoID', '=', $id)->first();
			$slide_id = $slide_by_autoId->sliID;
			$slides = Slide::where('sliID', $slide_id)->get();
			foreach($slides as $value){
				if($id == $value->sliAutoID){
					DB::table('tbl_slides')->where('sliAutoID', $value->sliAutoID)->update([
						'sliAutoID'      => $value->sliAutoID,
						'sliLang'        => $value->sliLang,
						'sliID'          => $slide_id,
						'sliName'        => $request->sliName,
						'sliLink'        => $request->sliLink,
						'sliStatus'      => $request->sliStatus,
						'sliOrder'       => $request->sliOrder,
						'sliDescription' => $request->sliDescription,
						'sliImage'       => $request->sliImage	
					]);  
				}else{
					DB::table('tbl_slides')->where('sliAutoID', $value->sliAutoID)->update([
						'sliAutoID'      => $value->sliAutoID,
						'sliLang'        => $value->sliLang,
						'sliID'          => $slide_id,
						'sliName'        => $value->sliName,
						'sliLink'        => $value->sliLink,
						'sliStatus'      => $request->sliStatus,
						'sliOrder'       => $value->sliOrder,
						'sliDescription' => $value->sliDescription,
						'sliImage'       => $value->sliImage
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
	public function show(Request $request){
		$slide_by_autoId = Slide::where('sliAutoID', '=', $request->sliAutoID)->first();
        $language = App::getLocale();
        $slide = DB::table('tbl_slides')->where('sliLang', $language)->where('sliID', $slide_by_autoId->sliID)->first();
        return view('project.slides.show',[
            'slide'  => $slide
        ]);
	}
	// delet data
	public function delete(Request $request){
		
		$permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('slide_menu_id'), null, "delete");
		if($permission_menu['status'] == true){
			$slide = Slide::where('sliAutoID', '=', $request->input('sliAutoID'))->first();
			Slide::where('sliID', '=', $slide->sliID)->delete();
			$request->session()->flash('message_success', $permission_menu['message']);
			return redirect()->route('slides.index');
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return redirect()->route('slides.index');
		}        
	}
}

