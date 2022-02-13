<?php

namespace Psyklon\Gradient\Tests;

use Psyklon\Gradient\Gradient;
use Psyklon\Gradient\MissingColorStopException;

use PHPUnit\Framework\TestCase;

class GradientTest extends TestCase
{
    public function testEmptyGradient()
    {
        $grad = new Gradient();

        self::assertEmpty($grad->getStops());
    }

    public function testAddStop()
    {
        $grad = new Gradient();
        $grad->addStop(10, 20, 30, 0.0);

        $stops = $grad->getStops();

        self::assertSame(1, sizeof($stops));
        self::assertSame([10, 20, 30], $stops[0]->getColor());
        self::assertSame(0.0, $stops[0]->getPosition());
    }

    public function testMoreStops()
    {
        $grad = new Gradient();
        $grad->addStop(110, 120, 130, 0.0);
        $grad->addStop(140, 150, 160, 33.333);
        $grad->addStop(170, 180, 190, 66.667);
        $grad->addStop(200, 210, 220, 100.0);

        $stops = $grad->getStops();

        self::assertSame(sizeof($stops), 4);

        self::assertSame([110, 120, 130], $stops[0]->getColor());
        self::assertSame(0.0, $stops[0]->getPosition());

        self::assertSame([140, 150, 160], $stops[1]->getColor());
        self::assertSame(33.333, $stops[1]->getPosition());

        self::assertSame([170, 180, 190], $stops[2]->getColor());
        self::assertSame(66.667, $stops[2]->getPosition());

        self::assertSame([200, 210, 220], $stops[3]->getColor());
        self::assertSame(100.0, $stops[3]->getPosition());
    }

    public function testMissingStop()
    {
        self::expectException(MissingColorStopException::class);

        $grad = new Gradient();
        $grad->setStopColor(33.333, 10, 20, 30);
    }

    public function testGetSetColor()
    {
        $grad = new Gradient();
        $stop = $grad->addStop(0, 0, 0, 0.0);
        $grad->setStopColor($stop, 255, 255, 255);

        $stops = $grad->getStops();

        self::assertSame(1, sizeof($stops));
        self::assertSame([255, 255, 255], $stops[0]->getColor());
        self::assertSame([255, 255, 255], $grad->getStopColor($stop));
    }

    public function testGetSetPosition()
    {
        $grad = new Gradient();
        $stop = $grad->addStop(0, 0, 0, 0.0);
        $stop = $grad->setStopPosition($stop, 100.0);

        $stops = $grad->getStops();

        self::assertSame(1, sizeof($stops));
        self::assertSame(100.0, $stop);
        self::assertSame(100.0, $stops[0]->getPosition());
        self::assertSame(100.0, $grad->getStopPosition($stop));
    }

    public function testGetSetSamePosition()
    {
        $grad = new Gradient();
        $stop = $grad->addStop(0, 0, 0, 0.0);
        $stop = $grad->setStopPosition($stop, 0.0);

        $stops = $grad->getStops();

        self::assertSame(1, sizeof($stops));
        self::assertSame(0.0, $stop);
        self::assertSame(0.0, $stops[0]->getPosition());
    }

    public function testGetColorAt()
    {
        $grad = new Gradient();
        $grad->addStop(0, 0, 0, 0.0);
        $grad->addStop(255, 255, 255, 100.0);

        $blue = new Gradient();
        $blue->addStop(0,   0,   0,   0.0);
        $blue->addStop(0,   123, 255, 50.0);
        $blue->addStop(255, 255, 255, 100.0);

        self::assertSame([0,   0,   0  ], $grad->getColorAt(0.0));
        self::assertSame([64,  64,  64 ], $grad->getColorAt(25.0));
        self::assertSame([128, 128, 128], $grad->getColorAt(50.0));
        self::assertSame([191, 191, 191], $grad->getColorAt(75.0));
        self::assertSame([255, 255, 255], $grad->getColorAt(100.0));

        self::assertSame([0,   0,   0  ], $blue->getColorAt(0.0));
        self::assertSame([0,   62,  128], $blue->getColorAt(25.0));
        self::assertSame([0,   123, 255], $blue->getColorAt(50.0));
        self::assertSame([128, 189, 255], $blue->getColorAt(75.0));
        self::assertSame([255, 255, 255], $blue->getColorAt(100.0));
    }

    public function testColorsOutOfRange()
    {
        $grad = new Gradient();

        self::assertSame([0, 0, 0], $grad->getColorAt(25.0));
        self::assertSame([0, 0, 0], $grad->getColorAt(75.0));

        $grad->addStop(255, 0, 0, 40.0);

        self::assertSame([255, 0, 0], $grad->getColorAt(25.0));
        self::assertSame([255, 0, 0], $grad->getColorAt(75.0));

        $grad->addStop(0, 255, 0, 60.0);

        self::assertSame([255, 0, 0], $grad->getColorAt(25.0));
        self::assertSame([0, 255, 0], $grad->getColorAt(75.0));
    }

    public function testRemoveStop()
    {
        $grad = new Gradient();
        $stop = $grad->addStop(255, 0, 0, 40.0);
        $grad->removeStop($stop);

        self::assertSame([0, 0, 0], $grad->getColorAt(40.0));
        self::assertEmpty($grad->getStops());
    }

    public function testRemoveMissingStop()
    {
        self::expectException(MissingColorStopException::class);

        $grad = new Gradient();
        $grad->addStop(255, 0, 0, 40.0);
        $grad->removeStop(50.0);
    }

    public function testSetMissingStopPosition()
    {
        self::expectException(MissingColorStopException::class);

        $grad = new Gradient();
        $grad->addStop(255, 0, 0, 40.0);
        $grad->setStopPosition(50.0, 60.0);
    }

    public function testGetMissingStopPosition()
    {
        self::expectException(MissingColorStopException::class);

        $grad = new Gradient();
        $grad->getStopPosition(50.0);
    }

    public function testGetMissingStopColor()
    {
        self::expectException(MissingColorStopException::class);

        $grad = new Gradient();
        $grad->getStopColor(50.0);
    }
}
