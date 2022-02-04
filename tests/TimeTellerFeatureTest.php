<?php

namespace Pete\Timeteller\Tests;

use PHPUnit\Framework\TestCase;
use Pete\Timeteller\TimeTeller;
use \DateTime;
use \DateTimeZone;

class TimeTellerFeatureTest extends TestCase
{
    /**
     * Test is result exist (by server IP)
     *
     * @return void
     * @throws \Exception
     */
    public function testOne()
    {
        $result = TimeTeller::tellTime();
        $this->assertIsObject($result);
    }

    /**
     * Test is result exist (by specific IP)
     *
     * @return void
     * @throws \Exception
     */
    public function testTwo()
    {
        $result = TimeTeller::tellTime('8.8.8.8');
        $this->assertIsObject($result);
    }

    /**
     * Test if result is correct
     *
     * @return void
     * @throws \Exception
     */
    public function testThree()
    {
        $result = TimeTeller::tellTime();

        $currentDateTime = new DateTime();
        $currentDateTime->setTimezone(new DateTimeZone('Europe/Kiev'));

        $this->assertEquals(
            $currentDateTime->format('Y-m-d H:i'),
            $result->format('Y-m-d H:i')
        );
    }
}
