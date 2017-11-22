<?php

namespace Larapac\FlashMessages;

use Illuminate\Support\Fluent;

/**
 * @property string $text
 * @property string $level
 */
class Message extends Fluent
{
    /**
     * Callback for object data changed event.
     *
     * @var callable|null
     */
    private $onChangeCallback;

    /**
     * Set callback for object data changed event.
     *
     * @param $callback
     */
    public function setOnChangeCallback($callback)
    {
        $this->onChangeCallback = $callback;
    }

    /**
     * Event of data is changed.
     */
    private function onChange()
    {
        if (null !== $this->onChangeCallback) {
            call_user_func($this->onChangeCallback);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);

        $this->onChange();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        parent::offsetSet($offset, $value);
        $this->onChange();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        parent::offsetUnset($offset);
        $this->onChange();
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
