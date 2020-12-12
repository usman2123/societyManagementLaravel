<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(){

    }
    public function save(Request $request){

      $name = $request->fname;
      $email = $request->email;
      $password = $request->password;

       $id=DB::table('users')->insert(
          [
              'name' => $name,
              'email' => $email,
              'role' => 'Admin',
              'password' =>Hash::make($password),
          "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
          "updated_at" => \Carbon\Carbon::now(),
          ]

      );



    //   $users= DB::table('users')->get();
    //   return view('admin\pages\users\ajax\view_users', ['users' => $users]);

    }

    // public function edit($id){
    //  $users=DB::table('users')->find($id);

    //  return view('admin\pages\houses\edit_users', ['users' => $users]);
    // }


 public function update(Request $re){

    $id=$re->id;
    $users=DB::table('users')->find($re->id);


     $name = $re->fname;
     $email = $re->email;

     $old = $re->old_password;

     $password = $re->password;
if (!$password=='') {
    $password=Hash::make($password);
}else{
     $password=$old;
}

  $users=DB::table('users')->where('id',$id)->update(
      [
        'name' => $name,
        'email' => $email,
        'role' => 'Admin',
        'password' =>Hash::make($password),
      "updated_at" => \Carbon\Carbon::now(),
      ]
  );

  $users= DB::table('users')->get();
  toastr()->info('Post Updated');
 return redirect('admin/admins/edit/'.$id)->with('message','post updated');


 }


 public function destroy($id){


  $users=DB::table('users')->delete($id);

  $users= DB::table('users')->get();
  return view('admin\pages\houses\ajax\view_users', ['users' => $users]);
 }
}
