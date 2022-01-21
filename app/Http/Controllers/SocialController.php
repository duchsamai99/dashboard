<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SocialController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request){
        // {{App::getLocale()}}
        $language = App::getLocale();
        $user = DB::table('tbl_socials')->where('socLang', $language)->first();
        return view('default.socials.index', array(
            'socials'  => $user
        ));
    }

    public function create(){
        return view('default.socials.create',[]);
    }
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

    public function store(Request $request){ 
        $social = new Social();
        $social->socLang = 'en';
        $social->socTitle = $request->socTitle;
        $social->socDescription = $request->socDescription;
        $social->socFollower = $request->socFollower;
        $social->socSign = $request->socSign;
        $social->socStatus = $request->socStatus;
        $social->socOrder = $request->socOrder;
        $social->socID = 1;
        $social->socImage = $request->socImage;

        $social->save();
        return response()->json(['success'=>$social]);
    }

    public function edit($id){
        return view('default.socials.edit',[
            'social'  => Social::where('socAutoID', '=', $id)->first()
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id){
        $social = Social::where('socAutoID', '=', $id)->first();

        $social->socAutoID = $id;
        $social->socLang = 'en';
        $social->socTitle = $request->socTitle;
        $social->socDescription = $request->socDescription;
        $social->socFollower = $request->socFollower;
        $social->socSign = $request->socSign;
        $social->socStatus = $request->socStatus;
        $social->socOrder = $request->socOrder;
        $social->socID = 7;
        $social->socImage = $request->socImage;
        $social->save();
        return response()->json(['success'=>$social]);
    }

    public function show($id){
        return view('default.socials.show',[
            'social'  => Social::where('socAutoID', '=', $id)->first()
        ]);
    }
    public function destroy(Request $request){
        Social::where('socAutoID', '=', $request->input('socAutoID'))->delete();
        return view('default.socials.index', array(
            'socials'  => social::all()
        ));
        
    }
}
