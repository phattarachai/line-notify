<?php


namespace Phattarachai\LineNotify;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Line::class;
    }

}
