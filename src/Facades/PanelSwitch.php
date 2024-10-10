<?php

namespace BezhanSalleh\PanelSwitch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BezhanSalleh\PanelSwitch\PanelSwitch
 */
class PanelSwitch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BezhanSalleh\PanelSwitch\PanelSwitch::class;
    }
}