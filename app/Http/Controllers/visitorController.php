<?php

namespace App\Http\Controllers;
use App\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class visitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
$user_id=$request->user_id;
$visitor_name=$request->visitor_name;
$visitor_phone=$request->visitor_phone;
$visitor_cnic=$request->visitor_cnic;
$visitors=DB::table('visitors')->insert(
    [
         'user_id' => $user_id,
        'visitor_name' => $visitor_name,
        'visitor_phone' => $visitor_phone,
        'visitor_cnic' =>$visitor_cnic,
    "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
    "updated_at" => \Carbon\Carbon::now(),
    ]
);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->id;
        $user_id=$request->user_id;
$visitor_name=$request->visitor_name;
$visitor_phone=$request->visitor_phone;
$visitor_cnic=$request->visitor_cnic;
$visitors=DB::table('visitors')->where('id',$id)->update(
    [
         'user_id' => $user_id,
        'visitor_name' => $visitor_name,
        'visitor_phone' => $visitor_phone,
        'visitor_cnic' =>$visitor_cnic,

    "updated_at" => \Carbon\Carbon::now(),
    ]
);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=DB::table('visitors')->delete($id);
    }
}
