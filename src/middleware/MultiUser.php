<?php 

namespace Unisharp\Laravelfilemanager\middleware;

use Closure;

class MultiUser
{
    public function handle($request, Closure $next)
    {
    	if (\Config::get('lfm.allow_multi_user') === true) {
    		$slug = \Config::get('lfm.user_field');
	        \Auth::user()->user_field = \Auth::user()->$slug;

	        if ($request->input('base') == null) {
	            $request->merge(['base' => \Auth::user()->user_field]);
	        } elseif (strpos($request->input('base'), \Config::get('lfm.shared_folder_name')) !== false) {
	            // $request->replace(['base' => \Config::get('lfm.shared_folder_name')]);
	        } elseif (strpos($request->input('base'), (string)\Auth::user()->user_field) === false) {
	            $request->replace(['base' => \Auth::user()->user_field]);
	        }
	    }

        return $next($request);
    }
}