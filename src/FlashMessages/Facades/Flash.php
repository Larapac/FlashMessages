<?php

namespace Larapac\FlashMessages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Larapac\FlashMessages\Sender
 */
class Flash extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }
}