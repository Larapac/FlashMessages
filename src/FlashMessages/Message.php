<?php

namespace Larapac\FlashMessages;

use Illuminate\Support\Fluent;

class Message extends Fluent
{
    /**
     * @var Sender
     */
    private $sender;

    public function __construct($attributes = [], Sender $sender)
    {
        $this->sender = $sender;

        parent::__construct($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);

        $this->sender->reFlash();

        return $this;
    }

    public function info()
    {
        return $this->level(__FUNCTION__);
    }

    public function success()
    {
        return $this->level(__FUNCTION__);
    }

    public function warning()
    {
        return $this->level(__FUNCTION__);
    }

    public function danger()
    {
        return $this->level(__FUNCTION__);
    }

    public function error()
    {
        return $this->danger();
    }

    public function message($message)
    {
        return $this->text($message);
    }
}
