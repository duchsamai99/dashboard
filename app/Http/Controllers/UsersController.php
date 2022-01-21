<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
class UsersController extends Controller
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
        // $this->middleware('user');



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
        return view('default.users.userCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // $user->password = Crypt::encryptString($request->input('password'));
        $user->password = Hash::make($request->input('password'));
        $user->image = $request->input('image');
        $user->email_verified_at = $request->input('email_verified_at');
        $user->menuroles = $request->input('role');
        $user->remember_token = $request->input('remember_token');
        // $user->assignRole('user');
        $user->save();
        $user->assignRole($request->input('role'));

        $request->session()->flash('message', 'Successfully created menu');
        $you = auth()->user();
        $users = User::all();
        return view('default.users.usersList', compact('users', 'you'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('default.users.userEditForm', compact('user'));
    }
    public function cropProfile(Request $request)
    {
        $folderPath = public_path('uploads/');
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
        // $validatedData = $request->validate([
        //     'name'       => 'required|min:1|max:256',
        //     'email'      => 'required|email|max:256'
        // ]);
        $user = User::find($id);
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->password      = Hash::make($request->password);
        if($request->image !=""){
            $user->image      = $request->image;
        }
        $user->save();
        return response()->json(['success'=>$user]);

        // $request->session()->flash('message', 'Successfully updated user');
        // return redirect()->route('users.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
