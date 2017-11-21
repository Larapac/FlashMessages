<?php

use Illuminate\Session\Store;
use Larapac\FlashMessages\Sender;
use PHPUnit\Framework\TestCase;

class FlashMessagesTest extends TestCase
{
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var \Larapac\FlashMessages\Sender
     */
    protected $flash;

    public function setUp()
    {
        $this->session = new Store('test', new \Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler());
        $this->flash = new Sender($this->session);
    }

    /**
     * @test
     */
    public function it_add_and_return_messages()
    {
        $this->flash->addMessage('Message');
        $this->assertEquals('Message', $this->flash->getMessages()->first()->text);

        $this->flash->addMessage('Message Two');
        $this->assertCount(2, $this->flash->getMessages());
    }

    //more test later
}