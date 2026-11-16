<?php

namespace Spatie\TailTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Spatie\TailTool\TailTool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        $tool = collect(Nova::registeredTools())->first(fn ($tool) => $tool instanceof TailTool);

        abort_unless($tool, 404);
        abort_unless($tool->authorize($request), 403);

        return $next($request);
    }
}
