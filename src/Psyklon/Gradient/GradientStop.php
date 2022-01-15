<?php

namespace Psyklon\Gradient;

/**
 * Represents a stop on a color gradient
 *
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
class GradientStop
{
	private $r;
	private $g;
	private $b;
	private $pos;

	/**
	 * Create a new GradientStop instance with the given parameters
	 * 
	 * @param int   $r    red color component (0-255)
	 * @param int   $g    green color component (0-255)
	 * @param int   $b    blue color component (0-255)
	 * @param float $pos  position (0-100)
	 */
	public function __construct(int $r, int $g, int $b, float $pos)
	{
		$this->r   = $this->clampColor($r);
		$this->g   = $this->clampColor($g);
		$this->b   = $this->clampColor($b);
		$this->pos = $this->clampPos($pos);
	}

	/**
	 * Set the position of the stop
	 * 
	 * @param float $pos  position (0-100)
	 * 
	 * @access public
	 */
	public function setPosition(float $position)
	{
		$this->pos = $this->clampPos($position);
	}

	/**
	 * Set the color of the stop
	 * 
	 * @param int $r   red color component (0-255)
	 * @param int $g   green color component (0-255)
	 * @param int $b   blue color component (0-255)
	 * 
	 * @access public
	 */
	public function setColor(int $r = null, int $g = null, int $b = null)
	{
		$this->r = (isset($r) ? $this->clampColor($r) : $this->r);
		$this->g = (isset($g) ? $this->clampColor($g) : $this->g);
		$this->b = (isset($b) ? $this->clampColor($b) : $this->b);
	}

	/**
	 * Set the color and position of the stop
	 * 
	 * @param int   $r    red color component (0-255)
	 * @param int   $g    green color component (0-255)
	 * @param int   $b    blue color component (0-255)
	 * @param float $pos  position (0-100)
	 * 
	 * @access public
	 */
	public function setData(int $r = null, int $g = null, int $b = null, float $position = null)
	{
		$this->setColor($r, $g, $b);
		$this->setPosition($position);
	}

	/**
	 * Get the position of the stop
	 * 
	 * @return float position
	 * @access public
	 */
	public function getPosition()
	{
		return $this->pos;
	}

	/**
	 * Get the color of the stop
	 * 
	 * @return array [red, green, blue]
	 * @access public
	 */
	public function getColor()
	{
		return [$this->r, $this->g, $this->b];
	}

	/**
	 * Get the color and position of the stop
	 * 
	 * @return array [red, green, blue, position]
	 * @access public
	 */
	public function getData()
	{
		return [$this->r, $this->g, $this->b, $this->pos];
	}

	/**
	 * Force the given value to be between 0 and 255
	 * 
	 * @param int $value  the value
	 * 
	 * @return int value between 0 and 255
	 * @access private
	 */
	private function clampColor(int $value)
	{
		return max(0, min(255, $value));
	}

	/**
	 * Force the given value to be between 0 and 100
	 * 
	 * @param int $value  the value
	 * 
	 * @return int value between 0 and 100
	 * @access private
	 */
	private function clampPos(float $value)
	{
		return max(0, min(100, $value));
	}
}
