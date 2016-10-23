<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Traits\SetSession;
use DB;

class ErrorController extends Controller {
    use SetSession;
     public function error1(Request $request)
   {

    $uri = $request->path();
      $set = $this->tab_menu_sessions($request);
           $session['tabs'] = $set['tabs'];
          $session['menu'] = $set['menu'];
          $session['message'] = $request->message;;
       return view($uri)->with($session);

  }

}