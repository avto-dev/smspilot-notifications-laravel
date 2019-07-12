<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests\Messages;

use AvtoDev\SmsPilotNotifications\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

/**
 * @covers \AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage<extended>
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
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new SmsPilotMessage;
    }

    /**
     * Test static factory method.
     *
     * @return void
     */
    public function testCreateMethod(): void
    {
        $this->assertInstanceOf(SmsPilotMessage::class, SmsPilotMessage::create());
    }

    /**
     * Test 'content' data accessors.
     *
     * @return void
     */
    public function testContentDataAccessors(): void
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->content($content = "some content\nfoo\tbar"));
        $this->assertEquals($content, $this->instance->content);
    }

    /**
     * Test 'from' data accessors.
     *
     * @return void
     */
    public function testFromDataAccessors(): void
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->from($from = 'sender name'));
        $this->assertEquals($from, $this->instance->from);
    }

    /**
     * Test 'to' data accessors.
     *
     * @return void
     */
    public function testToDataAccessors(): void
    {
        $this->assertInstanceOf(SmsPilotMessage::class, $this->instance->to($to = '71112223344'));
        $this->assertEquals($to, $this->instance->to);
    }

    /**
     * Test 'toArray' and 'toJson' methods.
     *
     * @return void
     */
    public function testToArrayAndToJsonMethods(): void
    {
        $this->instance
            ->to($to = '71112223344')
            ->content($content = "some content\nfoo\tbar");

        $as_array = $this->instance->toArray();

        $this->assertEquals($to, $as_array['to']);
        $this->assertEquals($content, $as_array['content']);
        $this->assertNull($as_array['from']);

        $this->assertEquals(json_encode($as_array), $this->instance->toJson());
    }
}
