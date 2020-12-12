<?php

namespace App\Http\Controllers;

use App\Notifications\DatabaseNotification;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){
        $title = $request->title;
        $desc = $request->description;

        $users=User::all();
        $letter = Collect(['title'=>$title,'body'=>$desc]);

        Notification::send($users, new DatabaseNotification($letter,['role'=>'Owner']));



        return view('admin\pages\notifications\announcements');
        toastr()->info('Post Updated');
      }
      public function markasread(){
          \Auth::User()->notifications->markAsRead();
          return back();
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
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ann=DB::table('notifications')->find($id);

        return view('admin\pages\notifications\announcement_edit', ['notifications' => $ann]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
