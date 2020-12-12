<?php

namespace App\Http\Controllers;
use App\Complain;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ComplainController extends Controller
{


public function complains_check($id){
$complains=DB::table('complains')
->join('complain_replies','complains.id','=','complain_replies.complain_id')

->join('users', 'complains.user_id', '=', 'users.id')
->select('complains.*', 'complain_replies.reply_content','users.name')
->where('complains.user_id',$id)->get();

if(count($complains)==0){
    $complains=DB::table('complains')->join('users', 'complains.user_id', '=', 'users.id')
    ->select('complains.*', 'users.name')->where('user_id',$id)->get();

    return view('admin.pages.helpdesk.complains_user',['complains'=>$complains])->with('alert','Not reply Yet');

}else{
    return view('admin.pages.helpdesk.complains_user',['complains'=>$complains]);

}


}

    public function save(Request $request){
        $user_id = $request->user_id;
        $complain_title = $request->complain_title;
        $complain_data = $request->complain_data;

         $id=DB::table('complains')->insert(
            [
                'user_id' => $user_id,
                'title' => $complain_title,
                'data' => $complain_data,
                'status'=>'0',
            "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]

        );
    }


    public function mread($id){
        $up=DB::table('complains')->where('id',$id)->update([
            'status'=>'Read',
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }

    public function underob($id){
        $up=DB::table('complains')->where('id',$id)->update([
            'status'=>'UnderObservation',
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }

    public function solve($id){
        $up=DB::table('complains')->where('id',$id)->update([
            'status'=>'Solved',
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }


    public function reply(Request $request){
        $user_id=$request->user_id;
        $complain_id=$request->complain_id;
        $data=$request->reply_content;

        $up=DB::table('complain_replies')->insert([
            'user_id'=>$user_id,
            'complain_id'=>$complain_id,
            'reply_content'=>$data,
        ]);
    }
}
