<?php

namespace Psyklon\Gradient\Tests;

use Psyklon\Gradient\GradientStop;
use Psyklon\Gradient\MissingColorStopException;

use PHPUnit\Framework\TestCase;

class GradientStopTest extends TestCase
{
    public function testNewGradientStop()
    {
        $stop = new GradientStop(100, 200, 255, 55.5);

        self::assertSame([100, 200, 255], $stop->getColor());
        self::assertSame(55.5, $stop->getPosition());
    }

    public function testGetSetColor()
    {
        $stop = new GradientStop(100, 200, 255, 55.5);
        $stop->setColor(10, 20, 30);

        self::assertSame([10, 20, 30], $stop->getColor());
    }

    public function testGetSetPosition()
    {
        $stop = new GradientStop(100, 200, 255, 55.5);
        $stop->setPosition(66.7);

        self::assertSame(66.7, $stop->getPosition());
    }

    public function testInvalidColor()
    {
        $stop = new GradientStop(-1, 500, 55.5, 55.5);
        
        self::assertSame([0, 255, 55], $stop->getColor());
    }

    public function testInvalidPosition()
    {
        $stop = new GradientStop(100, 200, 255, -1.5);
        
        self::assertSame(0.0, $stop->getPosition());

        $stop->setPosition(500.0);

        self::assertSame(100.0, $stop->getPosition());
    }
}
