<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminRequest;

class AdminController extends Controller
{
    /**
    * Display a listing of the resource.
    */
   public function index()
   {
       $data["title"] = 'Admins managments';
       $data["admins"] = Admin::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
       $data["can_create"] = Auth::user()->Has_permission("create_admins");
       $data["can_edit"] = Auth::user()->Has_permission("edit_admins");
       $data["can_delete"] = Auth::user()->Has_permission("delete_admins");
       return view("webmaster.admins.index")->with("data", $data);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       $data["title"] = 'Create an admin';
       return view("webmaster.admins.create")->with("data", $data);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(StoreAdminRequest $request)
   {
        $photoName = '';
        if($request->photo != null){
            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('img/avatars'), $photoName);
        }
        $admin = Admin::create([
           'name'  => $request->input('name'),
           'role'  => $request->input('role'),
           'email'  => $request->input('email'),
           'password' => Hash::make($request->input('password')),
           'permissions'  => implode(",", $request->permissions),
           'profile_image' => $photoName,
           'is_active'  => $request->input('is_active'),
           'created_by' => Auth::user()['id'],
       ]);
       return redirect()->route('webmaster_admins_index')->with('success', 'Admin created successfully');
   }

   /**
    * Display the specified resource.
    */
   public function show(Admin $admin)
   {
       $data["can_create"] = Auth::user()->Has_permission("create_admins");
       $data["can_edit"] = Auth::user()->Has_permission("edit_admins");
       $data["can_delete"] = Auth::user()->Has_permission("delete_admins");
       $data["title"] = 'Admin '.$admin["id"];
       $data["admin"] = $admin;
       return view("webmaster.admins.show")->with("data", $data);
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Admin $admin)
   {
       $data["title"] = 'Edit admin '.$admin["id"];
       $data["admin"] = $admin;
       return view("webmaster.admins.edit")->with("data", $data);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(UpdateAdminRequest $request, Admin $admin)
   {
        $photoName = $admin->profile_image;
        if($request->photo != null){
            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('img/avatars'), $photoName);
        }
        $admin->update([
            'name'  => $request->input('name'),
            'role'  => $request->input('role'),
            'email'  => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'permissions'  => implode(",", $request->permissions),
            'profile_image' => $photoName,
            'is_active'  => $request->input('is_active'),
            'created_by' => Auth::user()['id'],
        ]);
        return redirect()->route('webmaster_admins_index')->with('success', 'Admin updated successfully');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Admin $admin)
   {
       //
   }
}
