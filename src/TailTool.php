<?php

namespace Spatie\TailTool;

use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class TailTool extends Tool
{
    public function boot()
    {
        Nova::script('TailTool', __DIR__.'/../dist/js/tool.js');
    }

    public function renderNavigation(): View
    {
        return view('TailTool::navigation');
    }
}
