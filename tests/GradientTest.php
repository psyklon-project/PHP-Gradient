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

		self::assertSame(sizeof($stops), 1);
		self::assertSame($stops[0]->getColor(), [10, 20, 30]);
		self::assertSame($stops[0]->getPosition(), 0.0);
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

		self::assertSame($stops[0]->getColor(), [110, 120, 130]);
		self::assertSame($stops[0]->getPosition(), 0.0);

		self::assertSame($stops[1]->getColor(), [140, 150, 160]);
		self::assertSame($stops[1]->getPosition(), 33.333);

		self::assertSame($stops[2]->getColor(), [170, 180, 190]);
		self::assertSame($stops[2]->getPosition(), 66.667);

		self::assertSame($stops[3]->getColor(), [200, 210, 220]);
		self::assertSame($stops[3]->getPosition(), 100.0);
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

		self::assertSame(sizeof($stops), 1);
		self::assertSame($stops[0]->getColor(),      [255, 255, 255]);
		self::assertSame($grad->getStopColor($stop), [255, 255, 255]);
	}

	public function testGetSetPosition()
	{
		$grad = new Gradient();
		$stop = $grad->addStop(0, 0, 0, 0.0);
		$stop = $grad->setStopPosition($stop, 100.0);

		$stops = $grad->getStops();

		self::assertSame($stop, 100.0);
		self::assertSame(sizeof($stops), 1);
		self::assertSame($stops[0]->getPosition(), 100.0);
		self::assertSame($grad->getStopPosition($stop), 100.0);
	}

	public function testGetSetSamePosition()
	{
		$grad = new Gradient();
		$stop = $grad->addStop(0, 0, 0, 0.0);
		$stop = $grad->setStopPosition($stop, 0.0);

		$stops = $grad->getStops();

		self::assertSame($stop, 0.0);
		self::assertSame(sizeof($stops), 1);
		self::assertSame($stops[0]->getPosition(), 0.0);
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

		self::assertSame($grad->getColorAt(0.0),   [0,   0,   0  ]);
		self::assertSame($grad->getColorAt(25.0),  [64,  64,  64 ]);
		self::assertSame($grad->getColorAt(50.0),  [128, 128, 128]);
		self::assertSame($grad->getColorAt(75.0),  [191, 191, 191]);
		self::assertSame($grad->getColorAt(100.0), [255, 255, 255]);

		self::assertSame($blue->getColorAt(0.0),   [0,   0,   0  ]);
		self::assertSame($blue->getColorAt(25.0),  [0,   62,  128]);
		self::assertSame($blue->getColorAt(50.0),  [0,   123, 255]);
		self::assertSame($blue->getColorAt(75.0),  [128, 189, 255]);
		self::assertSame($blue->getColorAt(100.0), [255, 255, 255]);
	}

	public function testColorsOutOfRange()
	{
		$grad = new Gradient();

		self::assertSame($grad->getColorAt(25.0), [0, 0, 0]);
		self::assertSame($grad->getColorAt(75.0), [0, 0, 0]);

		$grad->addStop(255, 0, 0, 40.0);

		self::assertSame($grad->getColorAt(25.0), [255, 0, 0]);
		self::assertSame($grad->getColorAt(75.0), [255, 0, 0]);

		$grad->addStop(0, 255, 0, 60.0);

		self::assertSame($grad->getColorAt(25.0), [255, 0, 0]);
		self::assertSame($grad->getColorAt(75.0), [0, 255, 0]);
	}
}
