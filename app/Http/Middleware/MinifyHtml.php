<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /**
         * Handle
         *
         * @var $response Response
         */
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');
        if (strpos($contentType, 'text/html') !== false) {
            $response->setContent($this->minify($response->getContent()));
        }

        return $response;
    }

    /**
     * Минификация текста
     *
     * @param string $input
     * @return string
     */
    public function minify($input)
    {
        $search = [
            '/\>\s+/s',  // strip whitespaces after tags, except space
            '/\s+</s',  // strip whitespaces before tags, except space
        ];

        $replace = [
            '> ',
            ' <',
        ];

        return preg_replace($search, $replace, $input);
    }
}
