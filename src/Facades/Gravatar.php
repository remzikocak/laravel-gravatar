<?php


namespace RKocak\Gravatar\Facades;

use Illuminate\Support\Facades\Facade;

class Gravatar extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }

}