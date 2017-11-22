<?php

namespace Larapac\FlashMessages;

use Illuminate\Session\Store;
use Illuminate\Support\Collection;

class Sender
{
    const OLD_FLASH_LARAVEL_SESSION_ENGINE_KEY = '_flash.old';

    protected $keyInStorage = '_flash_messages';

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $messages;

    /**
     * @param \Illuminate\Session\Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->messages = new Collection();
        $this->ageFlash();
    }

    /**
     * Set specific key for session storage.
     *
     * @param string $key
     */
    public function setStorageKey($key)
    {
        $this->keyInStorage = $key;
    }

    /**
     * Flash an information message.
     *
     * @param string $message
     * @param array $data
     * @return Message
     */
    public function info($message, array $data = [])
    {
        return $this->addMessage($message, 'info', $data);
    }

    /**
     * Flash a success message.
     *
     * @param string $message
     * @param array $data
     * @return Message
     */
    public function success($message, array $data = [])
    {
        return $this->addMessage($message, 'success', $data);
    }

    /**
     * Flash a warning message.
     *
     * @param string $message
     * @param array $data
     * @return Message
     */
    public function warning($message, array $data = [])
    {
        return $this->addMessage($message, 'warning', $data);
    }

    /**
     * Flash an danger message.
     *
     * @param string $message
     * @param array $data
     * @return Message
     */
    public function danger($message, array $data = [])
    {
        return $this->addMessage($message, 'danger', $data);
    }

    /**
     * Flash an error message.
     *
     * This is alias for danger.
     *
     * @param string $message
     * @param array $data
     * @return Message
     */
    public function error($message, array $data = [])
    {
        return $this->danger($message, $data);
    }

    /**
     * Flash a general message.
     *
     * @param string $message
     * @param string $level
     * @param array $data
     * @return Message
     */
    public function addMessage($message, $level = 'info', array $data = [])
    {
        $msg_object = new Message(array_merge($data, ['text' => $message, 'level' => $level]), $this);

        $this->messages->prepend($msg_object);

        $this->flash();

        return $msg_object;
    }

    /**
     * Return collection messages by level or all.
     *
     * @param string|null $level
     * @return \Illuminate\Support\Collection
     */
    public function getMessages($level = null)
    {
        $this->flushFlash();

        $messages = array_merge(
            $this->session->get($this->keyInStorage, []),
            $this->session->get($this->keyInStorage . '_old', [])
        );

        $messages = (new Collection($messages))->map(function ($message) {
            return (object) $message;
        });

        if (null === $level) {
            return $messages;
        }

        return $messages->filter(function ($message) use ($level) {
            return $message->level === $level;
        });
    }

    /**
     * Alias for getMessages method.
     *
     * @param string|null $level
     * @return \Illuminate\Support\Collection
     */
    public function messages($level = null)
    {
        return $this->getMessages($level);
    }

    /**
     * Restore current messages when message changes.
     */
    public function reFlash()
    {
        $this->flash();
    }

    /**
     * Store current messages to flash session store.
     */
    protected function flash()
    {
        $data = $this->messages->toArray();

        $this->session->flash($this->keyInStorage, $data);
    }

    /**
     * Remove old messages to special message list.
     */
    protected function ageFlash()
    {
        if (! $this->session->has($this->keyInStorage)) {
            return;
        }

        $old_messages = $this->session->pull($this->keyInStorage);
        $key_old = $this->keyInStorage . '_old';
        $this->session->put($key_old, $old_messages);
        $this->session->push(self::OLD_FLASH_LARAVEL_SESSION_ENGINE_KEY, $key_old);
    }

    /**
     * Mark notices as old.
     */
    protected function flushFlash()
    {
        $this->session->push(self::OLD_FLASH_LARAVEL_SESSION_ENGINE_KEY, $this->keyInStorage);
    }

    /**
     * Clear all messages from current list and from session.
     */
    public function clear()
    {
        $this->messages = new Collection();
        if ($this->session->has($this->keyInStorage)) {
            $this->session->get($this->keyInStorage, []);
        }
        if ($this->session->has($this->keyInStorage . '_old')) {
            $this->session->get($this->keyInStorage . '_old', []);
        }
    }
}
