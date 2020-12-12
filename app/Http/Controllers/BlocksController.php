<?php

namespace App\Http\Controllers;
use App\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlocksController extends Controller
{
      public function index(){
          $blocks= DB::table('blocks')->get();

        return view('admin\pages\houses\ajax\view_blocks', ['blocks' => $blocks]);
      }
      public function save(Request $request){
        $name = $request->name;
         $blocks=DB::table('blocks')->insert(
            ['name' => $name,
            "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]
        );
        $blocks= DB::table('blocks')->get();
        return view('admin\pages\houses\ajax\view_blocks', ['blocks' => $blocks]);

      }

      public function edit($id){
       $blocks=DB::table('blocks')->find($id);

       return view('admin\pages\houses\ajax\edit_blocks', ['blocks' => $blocks]);
      }
   public function update(Request $request){
       $id=$request->id;
    $blocks=DB::table('blocks')->find($request->id);
    $name = $request->name;
    $blocks=DB::table('blocks')->where('id',$id)->update(
        ['name' => $name,

        "updated_at" => \Carbon\Carbon::now(),
        ]
    );
    $blocks= DB::table('blocks')->get();
    return view('admin\pages\houses\ajax\view_blocks', ['blocks' => $blocks]);
    toastr()->info('Post Updated');



   }
   public function destroy($id){


    $blocks=DB::table('blocks')->delete($id);
    $blocks= DB::table('blocks')->get();
    return view('admin\pages\houses\ajax\view_blocks', ['blocks' => $blocks]);
   }
}
