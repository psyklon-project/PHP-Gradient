<?php

namespace Psyklon\Gradient;

/**
 * Renders a Gradient as a CSS property value
 *
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
class CssGradientRenderer implements GradientRenderer
{
	private $grad;
	private $dir = 90;

	/**
	 * Create a new renderer for the given Gradient
	 * 
	 * @param Gradient $grad  Gradient instance
	 * @access public
	 */
	public function __construct(Gradient $grad)
	{
		$this->grad = $grad;
	}

	/**
	 * Set the direction of the gradient
	 * 
	 * @param float $dir  direction
	 * @access public
	 */
	public function setDirection(float $dir)
	{
		$this->dir = fmod(fmod($dir, 360) + 360, 360);
	}

	/**
	 * Render the gradient
	 * 
	 * @return string css property value
	 * @access public
	 */
	public function __toString() : string
	{
		$stops = $this->grad->getStops();
		foreach($stops as $stop) {
			$col = $stop->getColor();
			$pos = $stop->getPosition();
			$cssarr[] = "rgb({$col[0]}, {$col[1]}, {$col[2]}) {$pos}%";
		}
		$css = implode(', ', $cssarr);
		return "linear-gradient({$this->dir}deg, {$css})";
	}
}
