<?php

namespace Wabue\BackToTop;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap
{
    public function boot()
    {
        elgg_extend_view('elements/layout.css', 'css/backtotop');
        elgg_extend_view('page/layouts/elements/body', 'backtotop/scrollbutton');
    }
}