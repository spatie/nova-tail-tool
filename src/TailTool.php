<?php

namespace Spatie\TailTool;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class TailTool extends Tool
{
    /** @var \Closure */
    public static $authUsing;

    public function boot()
    {
        Nova::script('TailTool', __DIR__ . '/../dist/js/tool.js');

        $this->canSee(function () {
            return static::check(request());
        });
    }

    public function renderNavigation(): View
    {
        return view('TailTool::navigation');
    }

    public static function auth(Closure $callback): TailTool
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
