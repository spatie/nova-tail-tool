<?php

namespace Spatie\NovaTailTool;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaTailTool extends Tool
{
    /** @var \Closure */
    public static $authUsing;

    public function boot()
    {
        Nova::script('NovaTailTool', __DIR__ . '/../dist/js/tool.js');

        $this->canSee(function () {
            return static::check(request());
        });
    }

    public function renderNavigation(): View
    {
        return view('NovaTailTool::navigation');
    }

    public static function auth(Closure $callback): NovaTailTool
    {
        static::$authUsing = $callback;

        return new static;
    }

    public static function check(Request $request): bool
    {
        return (static::$authUsing ?? function () {
                return app()->environment('local');
            })($request);
    }
}
