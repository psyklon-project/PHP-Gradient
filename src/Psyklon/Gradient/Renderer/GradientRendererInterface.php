<?php

namespace Psyklon\Gradient;

/**
 * Gradient renderer interface
 * 
 * Accepts a gradient trough the counstructor, and
 * renders it with the magic __toString method. In
 * PHP, every binary data is also a string, so it
 * seems obvious to use the __toString method here.
 * 
 * @package Psyklon\Gradient
 * @author  Psyklon Project &lt;info@psyklon.com&gt;
 */
interface GradientRenderer
{
    public function __construct(Gradient $grad);
    public function __toString() : string;
}
