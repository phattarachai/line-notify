<?php


namespace Phattarachai\LineNotify\Facade;

class Line extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phattarachai\LineNotify\Line::class;
    }

}
