<?php

namespace Spatie\TailTool;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class TailTool extends Tool
{
    public function boot(): void
    {
        Nova::script('TailTool', __DIR__.'/../dist/js/tool.js');
        Nova::style('TailTool', __DIR__.'/../dist/tool.css');
    }

    public function menu(Request $request): MenuSection
    {
        return MenuSection::make(__('Application log'))
            ->path('/application-log')
            ->icon('command-line');
    }
}
