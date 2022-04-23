<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Support\Facades\Redirect;

class LowercaseRoutes
{
    /**
     * Paths excluded from lowercase restrictions
     * Accepts wildcards (e.g., 'images*')
     *
     * @var array
     */
    protected $excluded = [
        "/courses/"
    ];

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // assert that route contains uppercase letters
        $condition_1 = !ctype_lower(preg_replace('/[^A-Za-z]/', '', $request->path()));

        // assert that path is not root
        $condition_2 = $request->path() !== "/";

        // assert that path is not excluded from lowercase routes
        $condition_3 = !$request->is($this->excluded);

        // rewrite route to lowercase if all conditions are met
        if ($condition_1 && $condition_2 && $condition_3 && substr_count($request->fullUrl(), 'text=') == 0) {
            $new_route = str_replace($request->path(), strtolower($request->path()), $request->fullUrl());
            return Redirect::to($new_route."/", 301);
        }

        return $next($request);
    }
}
