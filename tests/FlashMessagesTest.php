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
    public function it_has_aliases_for_add_and_get_messages()
    {
        $this->flash->addMessage('Message');
        $this->flash->info('Message');
        $this->assertEquals($this->flash->messages()->first(), $this->flash->messages()->last());
        $this->assertEquals($this->flash->getMessages(), $this->flash->messages());
    }

    /**
     * @test
     */
    public function it_work_as_flash_one()
    {
        $this->flash->addMessage('Message');

        $this->session->ageFlashData();

        $this->assertEquals('Message', $this->flash->getMessages()->first()->text);
        $this->assertCount(1, $this->flash->getMessages());

        $this->session->ageFlashData();
        $this->assertEmpty($this->flash->getMessages());
    }

    /**
     * @test
     */
    public function it_work_as_flash_two()
    {
        $this->flash->addMessage('Message');

        $this->assertCount(1, $this->flash->getMessages());

        $this->session->ageFlashData();
        $this->assertEmpty($this->flash->getMessages());
    }

    /**
     * @test
     */
    public function it_return_messages_like_stack()
    {
        $this->flash->addMessage('One');
        $this->flash->addMessage('Two');

        $this->assertCount(2, $this->flash->getMessages());
        $this->assertEquals('Two', $this->flash->getMessages()->first()->text);
        $this->assertEquals('One', $this->flash->getMessages()->last()->text);
    }

    /**
     * @test
     */
    public function it_keep_messages_by_level()
    {
        $this->flash->info('Info');
        $this->assertEquals('info', $this->flash->messages()->first()->level);
        $this->flash->clear();

        $this->flash->success('Success');
        $this->assertEquals('success', $this->flash->messages()->first()->level);
        $this->flash->clear();

        $this->flash->warning('Warning');
        $this->assertEquals('warning', $this->flash->messages()->first()->level);
        $this->flash->clear();

        $this->flash->danger('Danger');
        $this->assertEquals('danger', $this->flash->messages()->first()->level);
        $this->flash->clear();

        $this->flash->error('Error');
        $this->assertEquals('danger', $this->flash->messages()->first()->level);
        $this->flash->clear();
    }

    /**
     * @test
     */
    public function it_possible_multiple_messages()
    {
        $this->flash->warning('One warning');
        $this->flash->warning('Two warning');
        $this->flash->success('But we did it');
        $messages = $this->flash->messages();
        $this->assertCount(3, $messages);
        $this->assertEquals('But we did it', $messages[0]->text);
        $this->assertEquals('success', $messages[0]->level);
        $this->assertEquals('Two warning', $messages[1]->text);
        $this->assertEquals('warning', $messages[1]->level);
        $this->assertEquals('One warning', $messages[2]->text);
        $this->assertEquals('warning', $messages[2]->level);
    }

    /**
     * @test
     */
    public function it_possible_add_extra_data_to_message_like_array()
    {
        $this->flash->addMessage('Message', 'info', ['important' => true, 'timeout' => 3]);
        $message = $this->flash->messages()->first();
        $this->assertEquals(true, $message->important);
        $this->assertEquals(3, $message->timeout);
    }

    /**
     * @test
     */
    public function it_possible_add_extra_data_to_message_fluent()
    {
        $this->flash->addMessage('Message')->important()->timeout(3);
        $message = $this->flash->messages()->first();
        $this->assertEquals(true, $message->important);
        $this->assertEquals(3, $message->timeout);
    }
}
