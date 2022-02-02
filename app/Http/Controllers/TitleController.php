<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Menus\PermissionMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\AdminMenuRole;

class TitleController extends Controller
{  
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['title_menu_id' => $request->current_menu_id]);
    }
    // list all data
    public function index(Request $request){
        // dd($request->session()->all());
        $language = App::getLocale();
        $titles = DB::table('tbl_titles')->where('titLang', $language)->get();
        return view('default.titles.index', array(
            'titles'  => $titles
        ));
    }
    // view form create
    public function create(Request $request){
        return view('default.titles.create',[]);
    }
    // create data
    public function store(Request $request){ 
        
        $permission_action = new PermissionMenu();
        $permission_menu = $permission_action->permission(session('title_menu_id'), null, "insert");
        if($permission_menu['status'] == true){
            $languages = Config::get('languages');
            $title_last = Title::all()->last();
            $titID = 0;
            if($title_last == null){

                $titID = 1;
            }else{
                $titID = $title_last->titID + 1;
            }
            foreach($languages as $language){
                $title = new Title();
                $title->titLang = $language['value'];
                $title->titTitle = $request->titTitle;
                $title->titDescription = $request->titDescription;
                $title->titAlias = $request->titAlias;
                $title->titStatus = $request->titStatus;
                $title->titID = $titID;
                $title->save();
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
        
        $title_by_autoId = Title::where('titAutoID', '=', $id)->first();
        $language = App::getLocale();
        $title = DB::table('tbl_titles')->where('titLang', $language)->where('titID', $title_by_autoId->titID)->first();
        return view('default.titles.edit',[
            'title'  => $title
        ]);
    }
    
    // update data
    public function update(Request $request , $id){
        $permission_action = new PermissionMenu();
        $permission_menu = $permission_action->permission(session('title_menu_id'), null,"update");
        if($permission_menu['status'] == true){
            $title_by_autoId = Title::where('titAutoID', '=', $id)->first();
            $title_id = $title_by_autoId->titID;
            $titles = Title::where('titID', $title_id)->get();
            foreach($titles as $value){
                if($id == $value->titAutoID){
                    DB::table('tbl_titles')->where('titAutoID', $value->titAutoID)->update([
                        'titAutoID'      => $value->titAutoID,
                        'titLang'        => $value->titLang,
                        'titTitle'       => $request->titTitle,
                        'titDescription' => $request->titDescription,
                        'titAlias'       => $value->titAlias,
                        'titStatus'      => $request->titStatus,
                        'titID'          => $title_id,
                    ]);  
                }else{
                    DB::table('tbl_titles')->where('titAutoID', $value->titAutoID)->update([
                        'titAutoID'      => $value->titAutoID,
                        'titLang'        => $value->titLang,
                        'titTitle'       => $value->titTitle,
                        'titDescription' => $value->titDescription,
                        'titAlias'       => $value->titAlias,
                        'titStatus'      => $request->titStatus,
                        'titID'          => $title_id,
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
        $title_by_autoId = Title::where('titAutoID', '=', $id)->first();
        $language = App::getLocale();
        $title = DB::table('tbl_titles')->where('titLang', $language)->where('titID', $title_by_autoId->titID)->first();
        return view('default.titles.show',[
            'title'  => $title
        ]);
    }
    
    // delete data
    public function destroy(Request $request){
        $permission_action = new PermissionMenu();
        $permission_menu = $permission_action->permission(session('title_menu_id'), null, "delete");
        if($permission_menu['status'] == true){
            $title = Title::where('titAutoID', '=', $request->input('titAutoID'))->first();
            Title::where('titID', '=', $title->titID)->delete();
            $request->session()->flash('message_success', $permission_menu['message']);
            return redirect()->route('titles.index');
        }else{
            $request->session()->flash("message_fail", $permission_menu['message']);
            return redirect()->route('titles.index');

        }
        

        
    }
}
