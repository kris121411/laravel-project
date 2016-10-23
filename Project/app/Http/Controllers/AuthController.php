<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use App\Http\Traits\SetSession;

class AuthController extends Controller {
   
   use SetSession;
   
   public function authenticate(Request $request)
  {
    $data = json_decode($request->input('data'), true);
    $username = $data['username'];
    $password = $data['password'];
    $query = "SELECT count(*) AS count,username,password,uid,fname,lname,role
    FROM tbl_user 
    WHERE username = '$username' AND password = '$password' group by uid ";
    $users = DB::select($query);
    $response =  array();
    if(count($users) == 1 )
    {
    foreach ($users as $key => $value)
    {
    $count = $value->count;
    $user_id = $value->uid;
    $user_fname = $value->fname;
    $user_lastname = $value->lname;
    $user_name = $value->username;
    $user_password = $value->password;
    }
      if(!strcmp($username, $user_name) and !strcmp( $password , $user_password))
      {
          $set = $this->setSession($request,$user_id,$user_fname,$user_lastname);
          $message  = 'Success';
          $result = true;
      }
      else
      {
        $message  = 'Incorrect Username or Password';
        $result = false;
      }
      
    }
    else if(count($users) == 0) 
    {
      $message  = 'Username or Password did not match';
      $result = false;
    } 

    $response['message'] = $message;
    $response['result'] = $result;
    return json_encode($response);
    die();
}
public function logout(Request $request)
{
  $set = $this->endSession($request);
  return redirect()->route('login');
}

}