<?php

namespace Spatie\NovaTailTool\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\NovaTailTool\NovaTailTool;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        return NovaTailTool::check($request)
            ? $next($request)
            : abort(403);
    }
}