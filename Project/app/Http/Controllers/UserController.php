<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Traits\SetSession;
use DB;

class UserController extends Controller {
    use SetSession;
     public function get_users(Request $request)
   {
    $uri = $request->path();
     $query = " SELECT * FROM tbl_user ";
    $users = DB::select($query);

    if(count($users) > 0 )
      {
        foreach ($users as $key => $value)
        {
          $user['users'][] = [
             'id' => $value->uid,
            'firstname' => $value->fname,
            'lastname' => $value->lname,
            'role' => $value->role,
            'username' => $value->username,
            'password' => $value->password,
            'is_active' => ($value->is_active == 1)?"True":"False",
            ];
        }
     }
     else
     {

     }
      $set = $this->tab_menu_sessions($request);

           $user['tabs'] = $set['tabs'];
      
          $user['menu'] = $set['menu'];

       return view($uri)->with($user);

  }


    public function get_user_byid(Request $request)
   {
    $id = $request->id;
    
      $query = " SELECT * FROM tbl_user where uid = $id";
     $user = DB::select($query);
      foreach ($user as $key => $value)
        {
             $id = $value->uid;
            $firstname = $value->fname;
            $lastname = $value->lname;
            $role = $value->role;
            $username = $value->username;
            $password = $value->password;
            $is_active = $value->is_active;
        }
           print $id."_".$firstname."_".$lastname."_".$role."_".$username."_".$password."_".$is_active;

  }


  public function save_update_user(Request $request)
  {
      $id = $request->id;
      $username = $request->Username;
      $password = $request->Password;
      $fname =$request->Firstname;
      $lname = $request->Lastname;
      $role = $request->Role;
      $is_active = $request->is_active;

      if($id != 0)
      {
        $query = "UPDATE tbl_user SET 
        username = '$username',
        password = '$password',
        fname = '$fname',
        lname = '$lname',
        role = '$role',
        is_active = $is_active
         WHERE uid = $id";
         DB::update($query);
        
          $message = 'Successfully updated user';
      }
      else
      {
        $query = "INSERT INTO tbl_user(username, password, fname, lname, role, dep_id,islock) 
        VALUES ('$username','$password','$fname','$lname','$role', 0 , 1 , 1)";
        DB::insert($query);
        $message = 'Successfully added user';
      }
     $response = $message;
      print $response;
     die();
  }
}