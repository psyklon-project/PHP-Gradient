<?php

namespace Psyklon\Gradient\Tests;

use Psyklon\Gradient\Gradient;
use Psyklon\Gradient\CssGradientRenderer;
use Psyklon\Gradient\MissingColorStopException;

use PHPUnit\Framework\TestCase;

class CssGradientRendererTest extends TestCase
{
    public function testEmpty()
    {
        $grad = new Gradient();
        $css  = (string)(new CssGradientRenderer($grad));

        self::assertSame("rgb(0, 0, 0)", $css);
    }

    public function testOneStop()
    {
        $grad = new Gradient();
        $grad->addStop(64, 128, 64, 77.7);

        $css = (string)(new CssGradientRenderer($grad));

        self::assertSame("rgb(64, 128, 64)", $css);
    }

    public function testTwoStops()
    {
        $grad = new Gradient();
        $grad->addStop(0,   0,   0,   0.0);
        $grad->addStop(255, 255, 255, 100.0);

        $css = (string)(new CssGradientRenderer($grad));

        self::assertSame(
            "linear-gradient(90deg, rgb(0, 0, 0) 0%, rgb(255, 255, 255) 100%)",
            $css
        );
    }

    public function testThreeStops()
    {
        $grad = new Gradient();
        $grad->addStop(0,   0,   0,   0.0);
        $grad->addStop(64,  128, 64,  66.7);
        $grad->addStop(255, 255, 255, 100.0);

        $css = (string)(new CssGradientRenderer($grad));

        self::assertSame(
            "linear-gradient(90deg, rgb(0, 0, 0) 0%, rgb(64, 128, 64) 66.7%, rgb(255, 255, 255) 100%)",
            $css
        );
    }

    public function testSetDirection()
    {
        $grad = new Gradient();
        $grad->addStop(0,   0,   0,   0.0);
        $grad->addStop(255, 255, 255, 100.0);

        $css = new CssGradientRenderer($grad);
        $css->setDirection(45.5);
        $css = (string)$css;

        self::assertSame(
            "linear-gradient(45.5deg, rgb(0, 0, 0) 0%, rgb(255, 255, 255) 100%)",
            $css
        );
    }

    public function testSetInvalidDirection()
    {
        $grad = new Gradient();
        $grad->addStop(0,   0,   0,   0.0);
        $grad->addStop(255, 255, 255, 100.0);

        $css = new CssGradientRenderer($grad);
        $css->setDirection(-45.5);
        $css = (string)$css;

        self::assertSame(
            "linear-gradient(314.5deg, rgb(0, 0, 0) 0%, rgb(255, 255, 255) 100%)",
            $css
        );
    }
}
