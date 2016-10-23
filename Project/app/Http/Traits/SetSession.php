<?php
namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

trait SetSession 
{
    public function setSession($request,$user_id,$user_fname,$user_lastname) 
    {
    	$ip_address = getHostByName(php_uname('n'));
    	$request->session()->put('user_id', $user_id);
    	$request->session()->put('user_fname', $user_fname);
    	$request->session()->put('user_lname', $user_lastname);
    	$request->session()->put('ip_address', $ip_address);
    	return true;
    }
    public function endSession($request)
    {
    	 $request->session()->forget('user_id');
         $request->session()->forget('user_lname');
         $request->session()->forget('user_fname');
         $request->session()->forget('ip_address');
         return true;
    }

    public function tab_menu_sessions($request)
    {
         $uri = $request->path();
            $query = "SELECT * FROM tbl_menu_tab_item ";
            $tabs = DB::select($query);
            foreach ($tabs as $key => $value)
            {
              $data['tabs'][] = ['name'=> $value->tab_name,
                                  'id'=> $value->tab_id
                                ];
              $tab_id = $value->tab_id;
              $query_menu ="SELECT * FROM `tbl_menu_items` WHERE tab_id = $tab_id";
              $menu = DB::select($query_menu);
                foreach ($menu as $key => $value)
                {
                  $data['menu'][] = [ 'title'=> $value->item_title,
                                      'link'=>$value->item_link,
                                      'tab_id'=>$value->tab_id
                    ];
                }
            }
         return $data;
    }
}