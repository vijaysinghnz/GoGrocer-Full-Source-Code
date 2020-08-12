<?php

namespace App\Http\Middleware;

use Closure;
use View;

class RedirectIfNotStore
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
            'App\Composers\StoreComposer'  => [
                                                'store.*',
                                             ] //attaches HomeComposer to home.blade.php
        ]);
    }
    
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('bamaStore')) {
            return redirect()->route('storeLogin');
        }

        return $next($request);
    }
}
