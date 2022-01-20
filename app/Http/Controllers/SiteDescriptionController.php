<?php

namespace App\Http\Controllers;

use App\Models\SiteDescription;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class SiteDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('default.site_descriptions.create',[]);
       
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
        $folderPath = public_path('uploads/');
        $image_parts = explode(";base64,", $request->sitImage1);
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
        // return response()->json(['success'=>$request->sitReceiverMail]);
        $site_description = new SiteDescription();
        $site_description->SitImage1 = $request->sitImage1;
        $site_description->SitImage2 = $request->sitImage1;
        $site_description->SitImage3 = $request->sitImage1;
        $site_description->SitName = $request->sitName;
        $site_description->SitCopyRight = $request->sitCopyRight;
        $site_description->SitReceiverMail = $request->sitReceiverMail;
        $site_description->SitPhoneNumber = $request->sitPhoneNumber;
        $site_description->save();
        return response()->json(['success'=>$site_description]);
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
    public function edit($id)
    {
        return view('default.site_descriptions.edit', array(
            'sit_description' => SiteDescription::where('SitId', '=', $id)->first()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteMenu  $siteMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteMenu $siteMenu)
    {
        //
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
