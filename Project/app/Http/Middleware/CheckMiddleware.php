<?php
namespace App\Http\Middleware;
use Closure;
class CheckMiddleware {
   public function handle($request, Closure $next ) {
      $user_id = $request->session()->get('user_id');
      if(empty($user_id))
      {
            return $next($request);
      }
      else
      {
      	return redirect('home');
      }
    return $next($request);
   }
}