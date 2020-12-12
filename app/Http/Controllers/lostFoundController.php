<?php

namespace App\Http\Controllers;
use App\Lost_found;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class lostFoundController extends Controller
{

    public function add_category(Request $request){
        $name = $request->category_title;
        $id=DB::table('lost_categories')->insert(
            [
                'category_name' => $name,

            "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]

        );

    }
    public function update_category(Request $request){
        $name = $request->category_title;
        $id = $request->id;
        $id=DB::table('lost_categories')->where('id',$id)->update(
            [
                'category_name' => $name,


            "updated_at" => \Carbon\Carbon::now(),
            ]

        );

    }

    public function lost_add(Request $request){
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $item_name = $request->item_name;
        $lost_data = $request->lost_data;
        $type = 'Lost';
        $status = 'Lost';


         $id=DB::table('lostfounds')->insert(
            [
                'user_id' => $user_id,
                'item_title' => $item_name,
                'category' => $category_id,
                'type' => $type,
                'description' => $lost_data,
                'status' => $status,

            "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]

        );
    }

    public function found_add(Request $request){
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $item_name = $request->item_name;
        $lost_data = $request->lost_data;
        $type = 'Found';
        $status = 'New';


         $id=DB::table('lostfounds')->insert(
            [
                'user_id' => $user_id,
                'item_title' => $item_name,
                'category' => $category_id,
                'type' => $type,
                'description' => $lost_data,
                'status' => $status,

            "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]

        );
    }



    public function lost_update(Request $request){
        $user_id = $request->user_id;
        $id = $request->id;
        $category_id = $request->category_id;
        $item_name = $request->item_name;
        $lost_data = $request->lost_data;
        $type = 'Lost';


         $id=DB::table('lostfounds')->where('id',$id)->update(
            [
                'user_id' => $user_id,
                'item_title' => $item_name,
                'category' => $category_id,
                'type' => $type,
                'description' => $lost_data,


            "updated_at" => \Carbon\Carbon::now(),
            ]

        );
    }

    public function found_update(Request $request){
        $user_id = $request->user_id;
        $id = $request->id;
        $category_id = $request->category_id;
        $item_name = $request->item_name;
        $lost_data = $request->lost_data;
        $type = 'Found';


         $id=DB::table('lostfounds')->where('id',$id)->update(
            [
                'user_id' => $user_id,
                'item_title' => $item_name,
                'category' => $category_id,
                'type' => $type,
                'description' => $lost_data,


            "updated_at" => \Carbon\Carbon::now(),
            ]

        );
    }


    public function found_destroy($id){
        $users=DB::table('lostfounds')->delete($id);
    }

public function founded($id){
$found=DB::table('lostfounds')->where('id',$id)->update([
    'status'=>'Founded',
]);
}
}
