<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SidebarMenu;
use App\Models\Slide;
use Illuminate\Validation\Rule;
class SlideController extends Controller
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
        return view('project.slides.index', array(
            'slides'  => Slide::all()
        ));
    }

    public function create(){
        return view('project.slides.create',[]);
    }
    public function crop(Request $request){
        $folderPath = public_path('uploads/');
        $image_parts = explode(";base64,", $request->sliImage);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . date('YmdHis'). '.jpeg';
        file_put_contents($file, $image_base64);

        return response()->json(['data'=>date('YmdHis') . '.jpeg']);
    }

    public function store(Request $request){ 

        $slide = new Slide();
        $slide->sliName = $request->sliName;
        $slide->sliLink = $request->sliLink;
        $slide->sliStatus = $request->sliStatus;
        $slide->sliOrder = $request->sliOrder;

        $slide->description = $request->description;
        $slide->sliImage = $request->sliImage;
        $slide->save();
        return response()->json(['success'=>$slide]);
    }

    public function edit(Request $request){
        return view('project.slides.edit',[
            'slide'  => Slide::where('id', '=', $request->input('id'))->first()
        ]);
    }

    public function update(Request $request){
        
        $slide = Slide::where('id', '=', $request->id)->first();
        $slide->sliName = $request->sliName;
        $slide->sliLink = $request->sliLink;
        $slide->sliStatus = $request->sliStatus;
        $slide->sliOrder = $request->sliOrder;
        $slide->description = $request->description;
        $slide->sliImage = $request->sliImage;
        $slide->save();
        return response()->json(['success'=>$slide]);
    }

    public function show(Request $request){
        return view('project.slides.show',[
            'slide'  => Slide::where('id', '=', $request->input('id'))->first()
        ]);
    }
    public function delete(Request $request){
        
        Slide::where('id', '=', $request->input('id'))->delete();
        // $request->session()->flash('message',$request->input('id'));
        // $request->session()->flash('back', 'slides.index');
        return view('project.slides.index', array(
            'slides'  => Slide::all()
        ));
        
    }
}

