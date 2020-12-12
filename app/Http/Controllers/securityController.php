<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class securityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(){
        $users= DB::table('users')->join('houses', 'users.id', '=', 'houses.owner_id')
        ->select('users.*', 'houses.owner_id')->
        where('role', 'Owner')->get();
dd($users);
      return view('admin\pages\users\ajax\view_users', ['users' => $users]);
    }
    public function save(Request $request){





      $name = $request->fname;
      $email = $request->email;
      $gender = $request->gender;
      $dob = $request->dob;
      $address = $request->address;
      $phone = $request->phone;
      $cnic = $request->cnic;
      $password = $request->password;

       $id=DB::table('users')->insertGetId(
          [
              'name' => $name,
              'email' => $email,
              'role' => 'Security',
              'password' =>Hash::make($password),
          "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
          "updated_at" => \Carbon\Carbon::now(),
          ]

      );


      $users_meta=DB::table('users_meta')->insert(
        [
             'user_id' => $id,
            'user_address' => $address,
            'user_phone' => $phone,
            'user_cnic' =>$cnic,
            'gender' =>$gender,
            'date_of_birth' =>$dob,
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
        'role' => 'Security',
        'password' =>Hash::make($password),
      "updated_at" => \Carbon\Carbon::now(),
      ]
  );
  $user_id=$re->user_id;
  $users=DB::table('users_meta')->find($re->user_id);
  $gender = $re->gender;
  $dob = $re->dob;
  $address = $re->address;
  $phone = $re->phone;
  $cnic = $re->cnic;
  $users=DB::table('users_meta')->where('user_id',$user_id)->update(
      [
        'user_address' => $address,
            'user_phone' => $phone,
            'user_cnic' =>$cnic,
            'gender' =>$gender,
            'date_of_birth' =>$dob,
            "updated_at" => \Carbon\Carbon::now(),
      ]
  );
  $users= DB::table('users')->get();
  toastr()->info('Post Updated');
 return redirect('admin/security/edit/'.$id)->with('message','post updated');


 }


 public function destroy($id){


  $users=DB::table('users')->delete($id);
  $users=DB::table('users_meta')->where('user_id', '=',$id)->delete();
  $users= DB::table('users')->get();

 }
}
