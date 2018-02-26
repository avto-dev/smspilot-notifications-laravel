<?php

namespace AvtoDev\SmsPilotNotifications\Tests\Messages;

use AvtoDev\SmsPilotNotifications\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

/**
 * Class SmsPilotMessageTest.
 */
class SmsPilotMessageTest extends AbstractTestCase
{
    /**
     * @var SmsPilotMessage
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->instance = new SmsPilotMessage;
    }

    /**
     * Test static factory method.
     *
     * @return void
     */
    public function testCreateMethod()
    {
        $this->assertInstanceOf(SmsPilotMessage::class, SmsPilotMessage::create());
    }

    /**
     * Test 'content' data accessors.
     *
     * @return void
     */
    public function testContentDataAccessors()
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->content($content = "some content\nfoo\tbar"));
        $this->assertEquals($content, $this->instance->content);
    }

    /**
     * Test 'from' data accessors.
     *
     * @return void
     */
    public function testFromDataAccessors()
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->from($from = 'sender name'));
        $this->assertEquals($from, $this->instance->from);
    }

    /**
     * Test 'to' data accessors.
     *
     * @return void
     */
    public function testToDataAccessors()
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->to($to = '71112223344'));
        $this->assertEquals($to, $this->instance->to);
    }
}
