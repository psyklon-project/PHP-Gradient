<?php

namespace Psyklon\Gradient;

/**
 * Represents a color gradient
 *
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
class Gradient
{
    private $stops = [];
    private $dirty = false;

    /**
     * Add a stop to the gradient
     * 
     * @param int   $r    red color component (0-255)
     * @param int   $g    green color component (0-255)
     * @param int   $b    blue color component (0-255)
     * @param float $pos  position (0-100)
     * 
     * @return float stop identifier (position)
     * @access public
     */
    public function addStop(int $r, int $g, int $b, float $pos) : float
    {
        $this->dirty = true;
        $this->stops[$pos] = new GradientStop($r, $g, $b, $pos);
        return $pos;
    }

    /**
     * Remove a stop from the gradient
     * 
     * @param float $id  stop identifier (position)
     * 
     * @throws MissingColorStopException
     * @access public
     */
    public function removeStop(float $id)
    {
        if(!isset($this->stops[$id])) {
            throw new MissingColorStopException();
        }
        unset($this->stops[$id]);
    }

    /**
     * Set the position of the given stop
     * 
     * @param float $id   stop identifier (position)
     * @param float $pos  position (0-100)
     * 
     * @throws MissingColorStopException
     * @access public
     */
    public function setStopPosition(float $id, float $pos) : float
    {
        if(!isset($this->stops[$id])) {
            throw new MissingColorStopException();
        }
        if($id !== $pos) {
            $this->dirty = true;
            $this->stops[$pos] = clone $this->stops[$id];
            $this->stops[$pos]->setPosition($pos);
            unset($this->stops[$id]);
        }
        return $pos;
    }

    /**
     * Set the color of the given stop
     * 
     * @param float $id  stop identifier (position)
     * @param int    $r  red color component (0-255)
     * @param int    $g  green color component (0-255)
     * @param int    $b  blue color component (0-255)
     * 
     * @throws MissingColorStopException
     * @access public
     */
    public function setStopColor(float $id, int $r, int $g, int $b)
    {
        if(!isset($this->stops[$id])) {
            throw new MissingColorStopException();
        }
        $this->stops[$id]->setColor($r, $g, $b);
    }

    /**
     * Get the position of the given stop
     * 
     * @param float $id  stop identifier (position)
     * 
     * @return float  position
     * @throws MissingColorStopException
     * @access public
     */
    public function getStopPosition(float $id) : float
    {
        if(!isset($this->stops[$id])) {
            throw new MissingColorStopException();
        }
        return $this->stops[$id]->getPosition();
    }

    /**
     * Get the color of the given stop
     * 
     * @param float $id  stop identifier (position)
     * 
     * @return array  [red, green, blue]
     * @throws MissingColorStopException
     * @access public
     */
    public function getStopColor(float $id) : array
    {
        if(!isset($this->stops[$id])) {
            throw new MissingColorStopException();
        }
        return $this->stops[$id]->getColor();
    }

    /**
     * Get the list of stops (also sorts them if necessary)
     * 
     * @return array  array of GradientStops
     * @access public
     */
    public function getStops() : array
    {
        $this->handleDirty();
        return array_values($this->stops);
    }

    /**
     * Get the color of any point on the gradient
     * 
     * @param float $pos  position
     * 
     * @return array [red, green, blue]
     * @access public
     */
    public function getColorAt(float $pos) : array
    {
        if(empty($this->stops)) {
            return [0, 0, 0];
        }
        if(isset($this->stops[$pos])) {
            return $this->stops[$pos]->getColor();
        }

        $this->handleDirty();
        $keys = array_keys($this->stops);

        if(sizeof($this->stops) == 1) {
            return $this->stops[$keys[0]]->getColor();
        }

        $first = $this->stops[$keys[0]];
        $last  = $this->stops[$keys[sizeof($keys) - 1]];

        if($pos <= $first->getPosition()) {
            return $first->getColor();
        }
        if($pos >= $last->getPosition()) {
            return $last->getColor();
        }

        $neighbors = $this->getNeighbors($keys, $pos);
        $prev      = $this->stops[$neighbors[0]];
        $next      = $this->stops[$neighbors[1]];

        $total     = $next->getPosition() - $prev->getPosition();
        $target    = $pos - $prev->getPosition();
        $lerpval   = $target / $total;

        $prevcolor = $prev->getColor();
        $nextcolor = $next->getColor();

        return [
            (int)round($this->lerp($prevcolor[0], $nextcolor[0], $lerpval)),
            (int)round($this->lerp($prevcolor[1], $nextcolor[1], $lerpval)),
            (int)round($this->lerp($prevcolor[2], $nextcolor[2], $lerpval)),
        ];
    }

    /**
     * Sort the stops only if any position changed
     * 
     * @access private
     */
    private function handleDirty()
    {
        if($this->dirty) {
            $this->sortStops();
            $this->dirty = false;
        }
    }

    /**
     * Sort the stops by their position
     * 
     * @access private
     */
    private function sortStops()
    {
        ksort($this->stops, SORT_NUMERIC);
    }

    /**
     * Get the closest values in both directions from the given array
     * Edge cases are already handled in getColorAt
     * 
     * @param array $arr  positions to choose from
     * @param float $pos  posisiotn to search
     * 
     * @access private
     */
    private function getNeighbors(array $arr, float $pos) : array
    {
        $prev = 0;
        $next = 100;
        foreach($arr as $val) {
            if($val > $prev && $val <= $pos) {
                $prev = $val;
            }
            if($val < $next && $val >= $pos) {
                $next = $val;
            }
        }
        return [$prev, $next];
    }

    /**
     * Linear interpolation
     * 
     * @param float $a  min value
     * @param float $b  max value
     * @param float $v  value
     * 
     * @return float value between 0 and 1
     * @access private
     */
    private function lerp(float $a, float $b, float $v) : float
    {
        return $a * (1 - $v) + $b * $v;
    }
}
