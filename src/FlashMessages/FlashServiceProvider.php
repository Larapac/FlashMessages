<?php

namespace Larapac\FlashMessages;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('flash', Sender::class);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['flash'];
    }
}
