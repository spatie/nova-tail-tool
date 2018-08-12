<?php

namespace Spatie\TailTool\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\TailTool\TailTool;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        return TailTool::check($request)
            ? $next($request)
            : abort(403);
    }
}