<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()

    {
        $total_users= DB::table('users')->count();
        
        $data['counter']=array(
            'users'=>$total_users,
            'avg_time'=>123.50
        );
        return view('admin.index',$data);
      
        
    }
    public function counter(){
        
     
    }
}
