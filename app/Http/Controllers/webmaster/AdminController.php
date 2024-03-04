<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

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
       $data["can_make_payement"] = Auth::user()->Has_permission("make_payement_admins");
       return view("webmaster.admins.index")->with("data", $data);
   }
   public function payement_validate()
   {
        Order::where("recovered_by", null)->where("recovered_at", "!=", null)->update([
            "recovered_by" => Auth::user()->id
        ]);
        
        return redirect()->route('webmaster_dashboard_index')->with('success', 'Paiement created successfully');
   } 
   /**
   * Display a listing of the resource.
   */
    public function payement(Admin $admin)
    {
        $data["title"] = 'Payement from '.$admin->name;
        $data["admin"] = $admin;
        $data["admins"] = Admin::all();
        return view("webmaster.admins.payement")->with("data", $data);
    }

       /**
    * Store a newly created resource in storage.
    */
    public function payement_store(Request $request, Admin $admin)
    {
        $data = array(
            "amount" => $request->input('amount'), 
            "payed_by" => $admin->id, 
            "payed_to" => $request->input('payed_to'), 
            "description" => $request->input('description')
        );
        Payement::create($data);
        return redirect()->route('webmaster_admins_index')->with('success', 'Paiement created successfully');
    }
   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       $data["title"] = 'Create an admin';
       $data["can_edit_role"] = Auth::user()->Has_permission("edit_role_admins");
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
           'email'  => $request->input('email'),
           'phone'  => $request->input('phone'),
           'phone2'  => $request->input('phone2'),

           'role'  => $request->input('role'),
           'permissions'  => implode(",", $request->permissions),

           'password' => Hash::make($request->input('password')),
           'profile_image' => $photoName,
           'is_active'  => $request->input('is_active'),
           'created_by' => Auth::user()->id,
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
       $data["can_edit_role"] = Auth::user()->Has_permission("edit_role_admins");
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
        $permissions = $admin->permissions;
        if(Auth::user()->Has_permission("edit_role_admins")){
            $permissions = implode(",", $request->permissions);
        }
        $admin->update([
           'name'  => $request->input('name'),
           'email'  => $request->input('email'),
           'phone'  => $request->input('phone'),
           'phone2'  => $request->input('phone2'),

           'role'  => $request->input('role'),
           'permissions'  => $permissions,

           'password' => Hash::make($request->input('password')),
           'profile_image' => $photoName,
           'is_active'  => $request->input('is_active'),
           'created_by' => Auth::user()->id,
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
