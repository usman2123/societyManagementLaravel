<?php

namespace App\Http\Controllers;
use App\Street;
use App\Block;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Gate;
class adminRoutesController extends Controller
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
    public function form(){
        return view('admin.form');
    }
    public function blocks(){
        $blocks= DB::table('blocks')->get();
        return view('admin.pages.houses.blocks', ['blocks' => $blocks]);


    }
    public function streets(){
        $streets= Street::with('block')->get();
        $blocks= DB::table('blocks')->get();

        return view('admin.pages.houses.streets', ['streets' => $streets,'blocks'=>$blocks]);
    }

    public function houses(){
        $houses=DB::table('houses')
        ->join('blocks', 'blocks.id', '=', 'houses.block_id')
        ->select('houses.*', 'blocks.name')
    ->get();
    $houses_owner=DB::table('houses')
    ->join('users', 'users.id', '=', 'houses.owner_id')
    ->select('users.name')
->get();


        return view('admin.pages.houses.houses', ['houses' => $houses, 'owner_info'=>$houses_owner]);
    }


    public function houses_add(){
        $blocks= DB::table('blocks')->get();
        $owners= DB::table('users')->where('role','Owner')->get();

        return view('admin.pages.houses.add_house',  ['blocks' => $blocks, 'owners'=>$owners]);
    }


    public function edit_house($id){
        $house=DB::table('houses')->find($id);
    $blocks= DB::table('blocks')->get();
        $owners= DB::table('users')->where('role','Owner')->get();

        return view('admin.pages.houses.edit_house', ['houses' => $house,'blocks'=>$blocks]);


    }


    //owners
    public function owners(){
          $users= DB::table('users')->join('users_meta', 'users.id', '=', 'users_meta.user_id')
        ->select('users.*', 'users_meta.user_phone')->
        where('role', 'Owner')->get();

        return view('admin.pages.users.owner' ,['users' => $users]);
    }

    public function security_add(){

        return view('admin.pages.users.add_security');
    }
    public function edit_security($id){
        $users=DB::table('users_meta')
        ->join('users', 'users.id', '=', 'users_meta.user_id')
    ->where('users.id','=', $id)
    ->first();

        return view('admin.pages.users.edit_security', ['users' => $users]);


    }
    //securtiy
    public function security(){
        $users= DB::table('users')->join('users_meta', 'users.id', '=', 'users_meta.user_id')
      ->select('users.*', 'users_meta.user_phone')->
      where('role', 'Security')->get();

      return view('admin.pages.users.security' ,['users' => $users]);
  }

  public function owners_add(){
      $blocks= DB::table('blocks')->get();
      return view('admin.pages.users.add_owner',['blocks' => $blocks]);
  }
  public function edit_owner($id){
      $users=DB::table('users_meta')
      ->join('users', 'users.id', '=', 'users_meta.user_id')
  ->where('users.id','=', $id)
  ->first();

      return view('admin.pages.users.edit_owner', ['users' => $users]);


  }




    //admin
    public function admins(){
        $users= DB::table('users')->where('role','Admin')->get();
        return view('admin.pages.users.admins' ,['users' => $users]);

    }
    public function admins_add(){
        return view('admin.pages.users.add_admins');
    }



    public function tanents_add(){
        $users= DB::table('users')->where('role','Owner')->get();

        return view('admin.pages.users.add_tanents',['owners' => $users]);
    }
    public function edit_tanent($id){
        $users=DB::table('users_meta')
        ->join('users', 'users.id', '=', 'users_meta.user_id')
    ->where('users.id','=', $id)
    ->first();

        return view('admin.pages.users.edit_tanent', ['users' => $users]);


    }

    public function tanents(){
        if(Gate::check('isAdmin')){
        $users= DB::table('users')->join('tanents_meta','users.id','=','tanents_meta.owner_id')
        ->where('users.role','Tanent')->get();
        return view('admin.pages.users.tanents' ,['users' => $users]);

    }
    if(Gate::check('isOwner')){
        $user=auth()->user();
        $id=$user->id;
    $users= DB::table('users')->join('users_meta','users.id','=','users_meta.user_id')
    ->join('tanents_meta','users.id','=','tanents_meta.tanent_id')
    ->select('users.*','users_meta.user_phone','tanents_meta.house_id')
    ->where('tanents_meta.owner_id',$id)->get();
    return view('admin.pages.users.tanents' ,['users' => $users]);

    }
}
    public function edit_admin($id){
        $users=DB::table('users')

    ->where('users.id','=', $id)
    ->first();

        return view('admin.pages.users.edit_admin', ['users' => $users]);


    }

    //owners

    //owners

    //owners
    public function maintainance(){
        return view('admin.pages.payments.maintainance');
    }
    //owners
    public function quitrent(){
        return view('admin.pages.payments.quit_rent');
    }

    //owners
    public function waterbills(){
        return view('admin.pages.payments.water_bills');
    }
    //owners
    public function maintainance_mode(){
        return view('admin.pages.settings.maintainance');
    }
    //owners
    public function site_setting(){
        return view('admin.pages.settings.site_settings');
    }
    //owners
    public function lost_items(){
        if(Gate::check('isAdmin')){
        $lost= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
        ->join('lost_categories','lostfounds.category','=','lost_categories.id')
        ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
       where('type','Lost')->get();
        }
        if(Gate::check('isOwner')|| Gate::check('isTanent') ){
            $user=auth()->user();
            $id=$user->id;

            $lost= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
            ->join('lost_categories','lostfounds.category','=','lost_categories.id')
            ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
           where('type','Lost')->where('users.id',$id)->get();

        }
        return view('admin.pages.security.lost_items',['losts'=> $lost]);
    }
    public function lost_add(){
        $users= DB::table('users')->get();
        $cat= DB::table('lost_categories')->get();
        return view('admin.pages.security.add_complain_lost',['users'=>$users,'cat'=>$cat]);
    }
    public function lost_edit($id){
        $lost= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
        ->join('lost_categories','lostfounds.category','=','lost_categories.id')
        ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
       where('lostfounds.id',$id )->get();
       $users= DB::table('users')->get();
       $cat= DB::table('lost_categories')->get();
        return view('admin.pages.security.edit_complain_lost',['losts'=>$lost, 'users'=>$users,'cat'=>$cat ]);
    }


    public function found_edit($id){
        $lost= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
        ->join('lost_categories','lostfounds.category','=','lost_categories.id')
        ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
       where('lostfounds.id',$id )->get();
       $users= DB::table('users')->get();
       $cat= DB::table('lost_categories')->get();
        return view('admin.pages.security.edit_complain_found',['losts'=>$lost, 'users'=>$users,'cat'=>$cat ]);
    }
 public function item_categories_add(){

    return view('admin.pages.security.add_categories_lost');

 }

public function item_categories_edit(){
    $categories= DB::table('lost_categories')->get();
    return view('admin.pages.security.edit_categories_lost',['categories'=>$categories]);
}


    public function found_items(){
        if(Gate::check('isAdmin')){
        $found= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
        ->join('lost_categories','lostfounds.category','=','lost_categories.id')
        ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
       where('type','Found')->get();
        }
       if(Gate::check('isOwner')|| Gate::check('isTanent')){
        $user=auth()->user();
        $id=$user->id;
        $found= DB::table('lostfounds')->join('users', 'lostfounds.user_id', '=', 'users.id')
        ->join('lost_categories','lostfounds.category','=','lost_categories.id')
        ->select('lostfounds.*', 'users.name','lost_categories.category_name')->
       where('type','Found')->where('users.id',$id)->get();
       }
        return view('admin.pages.security.found_items',['founds'=>$found]);
    }

    public function found_add(){
        $users= DB::table('users')->get();
        $cat= DB::table('lost_categories')->get();
        return view('admin.pages.security.add_complain_found',['users'=>$users,'cat'=>$cat]);
    }



    public function lost_categories(){
        $categories= DB::table('lost_categories')->get();
        return view('admin.pages.security.lost_categories',['categories'=>$categories]);
    }



    public function visitors(){
        $visitors= DB::table('visitors')->get();
        return view('admin.pages.security.visitors',['visitors'=>$visitors]);
    }
    public function visitors_add(){
        $users= DB::table('users')->get();
        return view('admin.pages.security.add_visitor',['users'=>$users]);
    }
    public function visitors_edit($id){
        $visitors= DB::table('visitors')->where('id',$id)->get();
        $users= DB::table('users')->get();
        return view('admin.pages.security.edit_visitor',['users'=>$users,'visitors'=>$visitors]);
    }


    public function announcements(){

        $announcment= DB::table('notifications')->get();

        return view('admin.pages.notifications.announcements',['noti'=>$announcment]);
    }
    public function announcement_add(){
        return view('admin.pages.notifications.announcement_add');
    }


    public function forumn(){
        return view('admin.pages.notifications.forumn');
    }
    public function notices(){
        return view('admin.pages.notifications.notices');
    }
    public function complains(){
        if(Gate::check('isAdmin')){
        $complains= DB::table('complains')->join('users', 'complains.user_id', '=', 'users.id')
        ->select('complains.*', 'users.name')->
       get();
        }
       if(Gate::check('isOwner')|| Gate::check('isTanent')){
        $user=auth()->user();
        $id=$user->id;
        $complains= DB::table('complains')->join('users', 'complains.user_id', '=', 'users.id')
        ->select('complains.*', 'users.name')->where('users.id',$id)->
       get();
       }

        return  view('admin.pages.helpdesk.complains',['complains'=>$complains]);
    }
    public function complains_add(){
        return view('admin.pages.helpdesk.add_complain');
    }
    public function complain_edit(){
        return view('admin.pages.helpdesk.edit_complain');
    }


    public function gym_booking(){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('buildings.building_type','GYM')->
       get();

        return view('admin.pages.bookings.gym_booking',['bookings'=>$booking]);
    }
    public function gymb_add(){
        $user=DB::table('users')->get();
        $building=DB::table('buildings')->where('building_type','GYM')->get();
        return view('admin.pages.bookings.add_gymb',['users'=>$user,'buildings'=>$building]);
    }
    public function gymb_edit($id){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('bookings.id',$id)->
       get();
       $building=DB::table('buildings')->where('building_type','GYM')->get();
        $users= DB::table('users')->get();
        return view('admin.pages.bookings.edit_gymb',['users'=>$users,'bookings'=>$booking,'buildings'=>$building]);
    }


    public function hall_booking(){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('buildings.building_type','Hall')->
       get();

        return view('admin.pages.bookings.hall_booking',['bookings'=>$booking]);
    }
    public function hallb_add(){
        $user=DB::table('users')->get();
        $building=DB::table('buildings')->where('building_type','Hall')->get();
        return view('admin.pages.bookings.add_hallb',['users'=>$user,'buildings'=>$building]);
    }
    public function hallb_edit($id){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('bookings.id',$id)->
       get();
       $building=DB::table('buildings')->where('building_type','Hall')->get();
        $users= DB::table('users')->get();
        return view('admin.pages.bookings.edit_hallb',['users'=>$users,'bookings'=>$booking,'buildings'=>$building]);
    }


    public function pool_booking(){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('buildings.building_type','SwimmingPool')->
       get();

        return view('admin.pages.bookings.pool_booking',['bookings'=>$booking]);
    }
    public function poolb_add(){
        $user=DB::table('users')->get();
        $building=DB::table('buildings')->where('building_type','SwimmingPool')->get();
        return view('admin.pages.bookings.add_poolb',['users'=>$user,'buildings'=>$building]);
    }
    public function poolb_edit($id){
        $booking=DB::table('bookings')->join('buildings', 'bookings.building_id', '=', 'buildings.id')
        ->select('bookings.*', 'buildings.*')->where('bookings.id',$id)->
       get();
       $building=DB::table('buildings')->where('building_type','SwimmingPool')->get();
        $users= DB::table('users')->get();
        return view('admin.pages.bookings.edit_poolb',['users'=>$users,'bookings'=>$booking,'buildings'=>$building]);
    }



// //**********************************
    // *******************************
    //  questions
    // ********************

    // */

    public function questions(){
        $questions= DB::table('questions')->get();
        return view('admin.pages.surveys.questions', ['questions' => $questions]);
    }
    public function questions_add(){

        return view('admin.pages.surveys.add_questions');
    }

    public function edit_questions($id){
        $questions=DB::table('questions')->where('id',$id)->get();

        return view('admin.pages.surveys.edit_questions', ['questions' => $questions]);
    }












    public function buildings(){
        $building= DB::table('buildings')->get();
        return view('admin.pages.bookings.building',['buildings'=>$building]);
    }
    public function add_building(){

        return view('admin.pages.bookings.add_building');
    }
    public function edit_building($id){
        $building= DB::table('buildings')->where('id',$id)->get();
        $users= DB::table('users')->get();
        return view('admin.pages.bookings.edit_building',['buildings'=>$building]);
    }







    // //**********************************
    // *******************************
    //  surveys
    // ********************

    // */

    public function surveys(){
        $teachers= DB::table('survey')->get();
        return view('admin.pages.surveys.surveys', ['teachers' => $teachers]);
    }
    public function surveys_add(){
        $questions= DB::table('questions')->get();
        $users= DB::table('users')->get();

        return view('admin.pages.surveys.survey_add',  ['questions'=>$questions],['users'=>$users]);
    }

    public function edit_survey($id){
        $questions=DB::table('questions')->where('id',$id)->get();

        return view('admin.pages.surveys.edit_questions', ['questions' => $questions]);
    }


    public function survey_list(){

       $user_id= Auth::user()->id;

       $students= DB::table('students')->join('users', 'students.user_id', '=', 'users.id')
       ->select('students.student_id')->where('students.user_id',$user_id)->get();
foreach($students as $student){
    $sid=$student->student_id;
}
        $sur= DB::table('survey')->where('student_id',$sid)->where('status','0')->get();

       if(!count($sur)==0){
        foreach($sur as $s){
            $tid=$s->teacher_id;
          }
            $teachers= DB::table('teachers')->join('users', 'teachers.user_id', '=', 'users.id')
          ->select('teachers.*', 'users.*')->where('teachers.teacher_id',$tid)->get();
          $survey_r=DB::table('survey_result')->where('student_id',$user_id)->get();
          return view('admin.pages.surveys.survey_list', ['surveys' => $sur],['teachers' => $teachers]);
        }

       return view('admin.pages.surveys.survey_notfound', ['surveys' => $sur]);
    }




    public function survey_fill($survey_id){
        $questions=DB::table('survey')->where('survery_id',$survey_id)->get();
        foreach($questions as $question){
       $qq= $question->questions;
    $ques=explode(",", $qq);
        }
            $qnew=DB::table('questions')->whereIn('id',$ques)->get();

        return view('admin.pages.surveys.survery_fill', ['questions' => $qnew],['info' => $questions]);
    }


    public function feedback_result(){
        $te_id= Auth::user()->id;

        $teachers=DB::table('teachers')->where('user_id',$te_id)->get();

        foreach($teachers as $tid){
        $t_id=$tid->teacher_id;
        }


        $tc=DB::table('teacherscourse_r')->where('t_id',$t_id)->get();


        $survey_r=DB::table('survey_result')->where('teacher_id',$t_id)->get();
        $total=1;
        foreach($tc as $tcc){
            $t_course=$tcc->c_id;
            $count= DB::table('enrollemnts')->where('c_id',$t_course)->count();
            $total=$count;
        }




        $g_s= DB::table('survey_result')->where('teacher_id',$t_id)->count();

        return view('admin.pages.results.results', ['survey' => $survey_r,'enrolled_students'=>$total,'total_feedbacks'=>$g_s]);
    }










}
