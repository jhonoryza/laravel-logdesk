<?php

use Jhonoryza\Logdesk\Logdesk;

if (! function_exists('logdesk')) {
    /**
     * @param mixed ...$args
     */
    function logdesk(...$args): Logdesk
    {
        return app(Logdesk::class)->send(...$args);
    }
}

if (! function_exists('logdeskDie')) {
    function logdeskDie(...$args)
    {
        logdesk(...$args)->die();
    }
}
