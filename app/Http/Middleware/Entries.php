<?php

namespace App\Http\Middleware;

use App\Models\Entries as ModelsEntries;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Entries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getContent();

         ModelsEntries::create([
             'ip' => $request->ip(),
             'response' => $responseBody,
             'request' => json_encode($request->all()),
             'endpoint' => $request->path(),
             'code' => $statusCode,
             'user_id' => Auth::id()
         ]);

        return $response;
    }
}
