<?php

namespace App\Http\Middleware;

use Closure;
use View;

class RedirectIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct()
    {
        View::composers([
            'App\Composers\CustComposer'  => [
                                                'users.*',
                                             ]
        ]);
    }
    
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('bamaCust')) {
            return redirect()->route('userLogin');
        }

        return $next($request);
    }
}
