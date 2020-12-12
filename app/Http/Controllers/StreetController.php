<?php

namespace App\Http\Controllers;
use App\Street;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StreetController extends Controller
{
    public function index(){
        $streets= DB::table('streets')->get();

      return view('admin\pages\houses\streets', ['streets' => $streets]);
    }
    public function save(Request $request){
      $name = $request->name;
      $block_id = $request->block_id;
       $streets=DB::table('streets')->insert(
          [
           'street_no' => $name,
           'block_id' => $block_id,
          "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
          "updated_at" => \Carbon\Carbon::now(),
          ]
      );
      $streets= DB::table('streets')->get();
      return $streets;

    }

    public function edit($id){
     $streets=DB::table('streets')->find($id);
     $blocks=DB::table('blocks')->get();

     return view('admin\pages\houses\ajax\edit_streets', ['streets' => $streets, 'blocks'=>$blocks]);
    }
 public function update(Request $request){
     $id=$request->id;
  $streets=DB::table('streets')->find($request->id);
  $name = $request->name;
  $block_id = $request->block_id;
  $streets=DB::table('streets')->where('id',$id)->update(
      [
          'street_no' => $name,
          'block_id' => $block_id,

      "updated_at" => \Carbon\Carbon::now(),
      ]
  );
  $streets= DB::table('streets')->get();
  return view('admin\pages\houses\ajax\view_streets', ['streets' => $streets]);
  toastr()->info('Post Updated');



 }
 public function destroy($id){


  $streets=DB::table('streets')->delete($id);
  $streets= DB::table('streets')->get();
  return view('admin\pages\houses\ajax\view_streets', ['streets' => $streets]);
 }
}
