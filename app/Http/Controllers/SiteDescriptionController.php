<?php

namespace App\Http\Controllers;

use App\Models\SiteDescription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\AdminMenuRole;
use App\Http\Menus\PermissionMenu;
use Illuminate\Http\Request;

class SiteDescriptionController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        session(['site_description_id' => $request->current_menu_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site_description_last = SiteDescription::all()->last();
        if($site_description_last !=null){
            $site_description_by_autoId = SiteDescription::where('sitAutoID', '=', $site_description_last->sitAutoID)->first();
            $language = App::getLocale();
            $site_description = DB::table('tbl_site_descriptions')->where('sitLang', $language)->where('sitID', $site_description_by_autoId->sitID)->first();
            // $request->session()->flash("logo_image", $site_description->sitImage1);
		    session(['logo_image' => $site_description->sitImage1]);

            return view('default.site_descriptions.edit',[
                'sit_description'  => $site_description
            ]);
        }else{
		    session(['logo_image' => 'amatak_logo.jpg']);
            return view('default.site_descriptions.create',[]);

        }
       
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('default.site_descriptions.create',[]);
 
    }

    public function crop(Request $request){
        $folderPath = public_path('uploads/site_descriptions/');
        $image_parts = explode(";base64,", $request->sitImage);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . date('YmdHis'). '.jpeg';
        file_put_contents($file, $image_base64);

        return response()->json(['data'=>date('YmdHis') . '.jpeg']);
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
		$permission_menu = $permission_action->permission(session('site_description_id'), null, "insert");
		if($permission_menu['status'] == true){
            $languages = Config::get('languages');
            $site_description_last = SiteDescription::all()->last();
            $sitID = 0;
            if($site_description_last == null){
                $sitID = 1;
            }else{
                $sitID = $site_description_last->sitID + 1;
            }
            foreach($languages as $language){
                $site_description = new SiteDescription();
                $site_description->sitID = $sitID;
                $site_description->sitLang = $language['value'];
                if($request->sitImage1 !=null){
                    $site_description->sitImage1 = $request->sitImage1; 
                }
                $site_description->sitImage2 = $request->sitImage2;
                $site_description->sitImage3 = $request->sitImage3;
                $site_description->sitName = $request->sitName;
                $site_description->sitCopyRight = $request->sitCopyRight;
                $site_description->sitReceiverMail = $request->sitReceiverMail;
                $site_description->sitPhoneNumber = $request->sitPhoneNumber;
                $site_description->save();
            }
            $request->session()->flash("message_success", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}else{
			$request->session()->flash("message_fail", $permission_menu['message']);
			return response()->json($permission_menu['status']);
		}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteMenu  $siteMenu
     * @return \Illuminate\Http\Response
     */
    public function show(SiteMenu $siteMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteMenu  $siteMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $site_description_by_autoId = SiteDescription::where('sitAutoID', '=', $id)->first();
        $language = App::getLocale();
        $site_description = DB::table('tbl_site_descriptions')->where('sitLang', $language)->where('sitID', $site_description_by_autoId->sitID)->first();
        return view('project.site_descriptions.edit',[
            'sit_description'  => $site_description
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteMenu  $siteMenu
     * @return \Illuminate\Http\Response
     */
    // update data
    public function update(Request $request){
        $permission_action = new PermissionMenu();
		$permission_menu = $permission_action->permission(session('site_description_id'), null,"update");
        $id = $request->sitAutoID;
		if($permission_menu['status'] == true){
            $site_description_by_autoId = SiteDescription::where('sitAutoID', '=', $id)->first();
            $site_description_id = $site_description_by_autoId->sitID;
            $site_descriptions = SiteDescription::where('sitID', $site_description_id)->get();
            foreach($site_descriptions as $value){
                if($id == $value->sitAutoID){
                    DB::table('tbl_site_descriptions')->where('sitAutoID', $value->sitAutoID)->update([
                        'sitAutoID'      => $value->sitAutoID,
                        'sitLang'        => $value->sitLang,
                        'sitID'          => $site_description_id,
                        'sitImage1'      => $request->sitImage1,
                        'sitImage2'      => $request->sitImage2,
                        'sitImage3'      => $request->sitImage3,
                        'sitName'        => $request->sitName,
                        'sitCopyRight'   => $request->sitCopyRight,
                        'sitReceiverMail'=> $request->sitReceiverMail,
                        'sitPhoneNumber' => $request->sitPhoneNumber
  
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteMenu  $siteMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteMenu $siteMenu)
    {
        //
    }
}
