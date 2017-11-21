<?php

if (! function_exists('flash')) {
    /**
     * Make a flash message or retrieve a FlashMessageSender instance.
     *
     * @param string $message
     * @param array $data
     * @return \Larapac\FlashMessages\Sender
     */
    function flash($message = null, array $data = [])
    {
        if (null === $message) {
            return app('flash');
        }

        return app('flash')->info($message, $data);
    }
}

