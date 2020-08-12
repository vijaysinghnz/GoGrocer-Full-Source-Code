<?php

namespace App\Http\Middleware;

use Closure;
use View;

class RedirectIfNotAdmin
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
            'App\Composers\HomeComposer'  => [
                                                'admin.*',
                                             ] //attaches HomeComposer to home.blade.php
        ]);
    }
    
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('bamaAdmin')) {
            return redirect()->route('adminLogin');
        }

        return $next($request);
    }
}
