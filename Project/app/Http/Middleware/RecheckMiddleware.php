<?php
namespace App\Http\Middleware;
use Closure;

class RecheckMiddleware {
   public function handle($request, Closure $next ) {
      $user_id = $request->session()->get('user_id');
      if(empty($user_id))
      {
         return redirect('/');
      }
      else
      {
      	   return $next($request);
      }
    return $next($request);
   }
}