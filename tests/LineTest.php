<?php


use Phattarachai\LineNotify\Line;

class LineTest extends \PHPUnit\Framework\TestCase
{
    public function test_send_message()
    {
        $line = new Line;

        $line->send('hello');

        $this->assertTrue(true);
    }

}
