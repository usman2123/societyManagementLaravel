<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
public  function fetch_streets(Request $request){

$id=$request->id;

    $data = DB::table('streets')
      ->where('block_id', $id)
      ->get();
  return response()->json($data);
}

public  function fetch_houses(Request $request){

    $id=$request->id;

        $data = DB::table('houses')->join('blocks', 'blocks.id', '=', 'houses.block_id')
        ->select('houses.*', 'blocks.name')
          ->where('street_no', $id)
          ->get();

      return response()->json($data);
    }
    public  function fetch_houses_users(Request $request){

        $id=$request->id;

            $data = DB::table('houses')->join('blocks', 'blocks.id', '=', 'houses.block_id')
            ->select('houses.*', 'blocks.name')
              ->where('owner_id', $id)
              ->get();

          return response()->json($data);
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

      $block = $request->block_name;
      $street_no = $request->street_no;
      $land_price = $request->land_price;
      $quit_rent = $request->quit_rent;
      $house_area = $request->house_area;
      $maintanance_charges = $request->maintainance;
    //   $owner = $request->owner_house;


       $id=DB::table('houses')->insert(
          [
              'block_id' => $block,

              'street_no' => $street_no,
              'land_price' => $land_price,
              'house_area' => $house_area,
              'quit_rent' => $quit_rent,
              'maintainance_charges' => $maintanance_charges,

          "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
          "updated_at" => \Carbon\Carbon::now(),
          ]

      );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\House  $house
     * @return \Illuminate\Http\Response
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\House  $house
     * @return \Illuminate\Http\Response
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $block = $request->block_name;
        $id = $request->hid;
        $street_no = $request->street_no;
        $land_price = $request->land_price;
        $quit_rent = $request->quit_rent;
        $house_area = $request->house_area;
        $maintanance_charges = $request->maintainance;
      //   $owner = $request->owner_house;


         $id=DB::table('houses')->where('id',$id)->update(
            [
                'block_id' => $block,

                'street_no' => $street_no,
                'land_price' => $land_price,
                'house_area' => $house_area,
                'quit_rent' => $quit_rent,
                'maintainance_charges' => $maintanance_charges,

            // "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
            "updated_at" => \Carbon\Carbon::now(),
            ]

        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

  $users=DB::table('houses')->delete($id);
  return view('admin\pages\houses');

    }
}
