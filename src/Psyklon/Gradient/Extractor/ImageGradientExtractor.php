<?php

namespace Psyklon\Gradient;

/**
 * Extracts a Gradient from an image file
 *
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
class ImageGradientExtractor implements GradientExtractor
{
    const SUPPORTED_FORMATS = ['jpeg', 'png', 'gif', 'bmp', 'gd', 'gd2', 'avif'];

    const SCAN_TOP     =  0;
    const SCAN_CENTER  = -1;
    const SCAN_MIDDLE  = -1;
    const SCAN_BOTTOM  = -2;
    const SCAN_AVERAGE = -3;

    private $size;
    private $image;
    private $scanpos;
    
    private $indexes;

    /**
     * Create a new reader
     * 
     * @param string $filename  image file
     * @param string $format    image format
     * @param int    $scanpos   positive integer between 0 and height, or a SCAN_* constant
     * 
     * @throws \Exception
     * @access public
     */
    public function __construct(string $filename, string $format = 'jpeg', int $scanpos = -1)
    {
        if(!in_array($format, self::SUPPORTED_FORMATS)) {
            throw new \Exception('Unsupported image format!');
        }

        $this->size = getimagesize($filename);
        $this->setScanPosition($scanpos);

        $imagecreate   = 'imagecreatefrom'.$format;
        $this->image   = $imagecreate($filename);
        $this->scanpos = $scanpos;
    }

    /**
     * Set the scan position
     * 
     * @param int $scanpos  positive integer between 0 and height, or a SCAN_* constant
     * 
     * @throws \Exception
     * @access public
     */
    public function setScanPosition(int $scanpos = -1)
    {
        if($scanpos < -3 || $scanpos >= $this->size[1]) {
            throw new \Exceoption('Invalid scan position!');
        }
        $this->scanpos = $scanpos;
    }

    /**
     * Extract the gradient
     * 
     * @return Gradient gradient extracted from the image
     * 
     * @access public
     */
    public function extract() : Gradient
    {
        $grad = new Gradient();
        for($x = 0; $x < $this->size[0]; $x++) {
            $col = $this->scan($x);
            $grad->addStop($col[0], $col[1], $col[2], ($x / $this->size[0]) * 100);
        }
        return $grad;
    }

    /**
     * Get the color at the given X position with different settings
     * 
     * @param int $x  X position
     * 
     * @return array [red, green, blue]
     * @access private
     */
    private function scan(int $x)
    {
        switch($this->scanpos) {

            case self::SCAN_CENTER:
                return $this->getColorAt($x, floor($this->size[1] / 2));

            case self::SCAN_BOTTOM:
                return $this->getColorAt($x, $this->size[1] - 1);

            case self::SCAN_AVERAGE:
                return $this->getAverageColorAt($x);

            default:
                return $this->getColorAt($x, $this->scanpos);
        }
    }

    /**
     * Get the color at the given coordinates, and cache it for reuse
     * 
     * @param int $x  X positoin
     * @param int $y  Y position
     * 
     * @return array [red, green, blue]
     * @access private
     */
    private function getColorAt(int $x, int $y)
    {
        $index = imagecolorat($this->image, $x, $y);
        if(isset($this->indexes[$index])) {
            return $this->indexes[$index];
        }
        $col = imagecolorsforindex($this->image, $index);
        $this->indexes[$index] = [$col['red'], $col['green'], $col['blue']];
        return $this->indexes[$index];
    }

    /**
     * Calculate the average color at the given X position
     * 
     * @param int $x  X position
     * 
     * @return array [red, green, blue]
     * @access private
     */
    private function getAverageColorAt(int $x)
    {
        $r = $g = $b = [];
        for($y = 0; $y < $this->size[1]; $y++) {
            $col = $this->getColorAt($x, $y);
            $r[] = $col[0];
            $g[] = $col[1];
            $b[] = $col[2];
        }
        $red   = round(array_sum($r) / sizeof($r));
        $green = round(array_sum($g) / sizeof($g));
        $blue  = round(array_sum($b) / sizeof($b));
        return [$red, $green, $blue];
    }
}
