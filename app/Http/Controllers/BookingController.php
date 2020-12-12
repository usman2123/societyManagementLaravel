<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
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
    public function save(Request $request)
    {
        $building_id = $request->building_id;
        $user_id = $request->user_id;
        $b_date = $request->booking_date;
        $bookings=DB::table('bookings')->insert(
           [
               'building_id' => $building_id,
               'user_id' => $user_id,
               'date' => $b_date,
               'status' => '0',
           "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
           "updated_at" => \Carbon\Carbon::now(),
           ]
       );

    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $building_id = $request->building_id;
        $user_id = $request->user_id;
        $b_date = $request->booking_date;
        $bookings=DB::table('bookings')->where('id',$id)->update(
           [
               'building_id' => $building_id,
               'user_id' => $user_id,
               'date' => $b_date,
               'status' => '0',
           "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
           "updated_at" => \Carbon\Carbon::now(),
           ]
       );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=DB::table('bookings')->delete($id);

    }
}
