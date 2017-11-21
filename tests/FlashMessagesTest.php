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

    /**
     * {@inheritdoc}
     */
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

    /**
     * @test
     */
    public function it_work_as_flash()
    {
        $this->flash->addMessage('Message');

        $this->session->ageFlashData();
        $this->assertEquals('Message', $this->flash->getMessages()->first()->text);
        $this->assertCount(1, $this->flash->getMessages());

        $this->session->ageFlashData();
        $this->assertEmpty($this->flash->getMessages());
    }
}