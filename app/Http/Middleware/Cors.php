<?php

namespace App\Http\Middleware;

use Closure;
use Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowed_origin = "http://localhost:4200";
        header("Access-Control-Allow-Origin: $allowed_origin");

        // ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Methods'=> 'POST, PATCH, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];

        if($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers
            // allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
            $response->header($key, $value);

        return $response;
    }
}
