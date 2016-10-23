<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Traits\SetSession;

use DB;


class HomeController extends Controller {
  use SetSession;
   public function accessSessionData(Request $request)
   {
      if($request->session()->has('user_id'))
      {
         echo $request->session()->get('user_id');
         echo $request->session()->get('user_lname');
         echo $request->session()->get('user_fname');
         echo $request->session()->get('ip_address');
      }
      else
         echo 'No data in the session';
   }

   public function deleteSessionData(Request $request){
         $request->session()->forget('user_id');
         $request->session()->forget('user_lname');
         $request->session()->forget('user_fname');
         $request->session()->forget('ip_address');
   }

  public function get_tab(Request $request)
   {
    $query = "SELECT * FROM tbl_menu_tab_item ";
    $tabs = DB::select($query);
    $tab =  array();
    foreach ($tabs as $key => $value)
    {
      $tab[] = $value->tab_name;
    }
     return json_encode($tab);
     die();
   }

   public function get_tabitems(Request $request)
   {
     $data = "<table><tr><th>Masterfile Management</th><th>Transaction</th><th>Report Generation</th></tr><tr><td><a href='/user' class='button'>1. USERS</a></td><td><a href='#' class='button'>2. Lorem ipsum dolor sit amet</a></td><td><a href='#' class='button'>3. Lorem ipsum dolor sit amet</a></td></tr><tr><td><a href='#' class='button'>4. Lorem ipsum dolor sit amet</a></td><td><a href='#' class='button'>5. Lorem ipsum dolor sit amet</a></td><td><a href='#' class='button'>6. Lorem ipsum dolor sit amet</a></td></tr></table>"
       ;
    $tab_item[] = $data;
     return json_encode($tab_item);
     die();
   }

   public function redirectpermission(Request $request)
   {
     return redirect()->intended('home1');
   }


   public function get_tab2(Request $request)
   {
     $uri = $request->path();

      $set = $this->tab_menu_sessions($request);
       return view($uri)->with($set);
   }
}