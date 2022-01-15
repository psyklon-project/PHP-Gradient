<?php

namespace Psyklon\Gradient;

/**
 * Renders a Gradient as an image
 *
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
class ImageGradientRenderer implements GradientRenderer
{
	const SUPPORTED_FORMATS = ['jpeg', 'png', 'gif', 'bmp', 'gd', 'gd2', 'avif'];

	private $grad;
	private $size;
	private $image;
	private $format;

	/**
	 * Create a new renderer for the given Gradient
	 * 
	 * @param Gradient $grad  Gradient instance
	 * @access public
	 */
	public function __construct(Gradient $grad)
	{
		$this->grad    = $grad;
		$this->size    = [100, 100];
		$this->format  = 'png';
	}

	/**
	 * Set the dimesions of the output image
	 * 
	 * @param int $width   width of the image
	 * @param int $height  height of the image
	 * 
	 * @access public
	 */
	public function setSize(int $width, int $height)
	{
		$this->size = [$width, $height];
	}

	/**
	 * Set the format of the output image
	 * Supported formats: jpeg, png, gif, bmp, gd, gd2, avif
	 * 
	 * @param string $format  output format
	 * 
	 * @access public
	 */
	public function setFormat(string $format)
	{
		if(in_array($format, self::SUPPORTED_FORMATS)) {
			$this->format = $format;
		}
	}

	/**
	 * Render the gradient
	 * 
	 * @return string css property value
	 * @access public
	 */
	public function __toString() : string
	{
		$image = imagecreatetruecolor($this->size[0], $this->size[1]);
		for($i = 0; $i < $this->size[0]; $i++) {
			$rgb = $this->grad->getColorAt(($i / $this->size[0]) * 100);
			$col = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
			imageline($image, $i, 0, $i, $this->size[1], $col);
		}
		$output = 'image'.$this->format;
		ob_start();
		$output($image);
		return ob_get_clean();
	}
}
