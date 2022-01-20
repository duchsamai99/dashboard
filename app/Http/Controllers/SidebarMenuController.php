<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SidebarMenu;
use Illuminate\Validation\Rule;
class SidebarMenuController extends Controller
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
        return view('dashboard.sidebar_menu.menu.index', array(
            'viewSidebars'  => SidebarMenu::all()
        ));
    }

    public function create(){
        return view('dashboard.sidebar_menu.menu.create',[]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'order' => 'required',
            
        ]);
        $viewSidebar = new SidebarMenu();
        $viewSidebar->name = $request->input('name');
        $viewSidebar->status = $request->input('status');
        $viewSidebar->order = $request->input('order');

        $viewSidebar->save();
        $request->session()->flash('message', 'Successfully created menu');
        return redirect()->route('sidebar.menu.index'); 
    }

    public function edit(Request $request){
        return view('dashboard.sidebar_menu.menu.edit',[
            'viewSidebar'  => SidebarMenu::where('id', '=', $request->input('id'))->first()
        ]);
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'   => 'required',
            'name' => 'required|min:1|max:64'
        ]);
        $viewSidebar = SidebarMenu::where('id', '=', $request->input('id'))->first();
        $viewSidebar->name = $request->input('name');
        $viewSidebar->order = $request->input('order');
        $viewSidebar->status = $request->input('status');
        $viewSidebar->save();
        $request->session()->flash('message', 'Successfully update menu');
        return redirect()->route('sidebar.menu.index'); 
    }


    public function show(Request $request){
        return view('dashboard.sidebar_menu.menu.show',[
            'viewSidebar'  => SidebarMenu::where('id', '=', $request->input('id'))->first()
        ]);
    }
    

    public function delete(Request $request){
        
        SidebarMenu::where('id', '=', $request->input('id'))->delete();
        $request->session()->flash('message', 'Successfully deleted menu');
        $request->session()->flash('back', 'sidebar.menu.index');
        return view('dashboard.layouts.universal-info');
        
    }
}
