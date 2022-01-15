<?php

namespace Psyklon\Gradient;

/**
 * Gradient extractor interface
 * 
 * Returns a Gradient instance generated
 * from the source implementation
 * 
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
interface GradientExtractor
{
	public function extract() : Gradient;
}
