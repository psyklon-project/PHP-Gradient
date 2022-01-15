<?php

require __DIR__.'/src/Psyklon/Gradient/load-all.php';

use Psyklon\Gradient\Gradient;

use Psyklon\Gradient\CssGradientRenderer;
use Psyklon\Gradient\ImageGradientRenderer;

use Psyklon\Gradient\ImageGradientExtractor;

/**
 * Grayscale demo
 */
$grad = new Gradient();
$grad->addStop(0, 0, 0, 0);
$grad->addStop(255, 255, 255, 100);
$col0   = $grad->getColorAt(0);
$col25  = $grad->getColorAt(25);
$col50  = $grad->getColorAt(50);
$col75  = $grad->getColorAt(75);
$col100 = $grad->getColorAt(100);

/**
 * Bootstap demo (primary)
 */
$primary = new Gradient();
$primary->addStop(0, 0, 0, 0);
$primary->addStop(0, 123, 255, 50);
$primary->addStop(255, 255, 255, 100);
$primary25 = $primary->getColorAt(25);
$primary50 = $primary->getColorAt(50);
$primary75 = $primary->getColorAt(75);

/**
 * Bootstap demo (success)
 */
$success = new Gradient();
$success->addStop(0, 0, 0, 0);
$success->addStop(40, 167, 69, 50);
$success->addStop(255, 255, 255, 100);
$success25 = $success->getColorAt(25);
$success50 = $success->getColorAt(50);
$success75 = $success->getColorAt(75);

/**
 * Bootstap demo (danger)
 */
$danger = new Gradient();
$danger->addStop(0, 0, 0, 0);
$danger->addStop(220, 53, 69, 50);
$danger->addStop(255, 255, 255, 100);
$danger25 = $danger->getColorAt(25);
$danger50 = $danger->getColorAt(50);
$danger75 = $danger->getColorAt(75);

/**
 * Bootstap demo (warning)
 */
$warning = new Gradient();
$warning->addStop(0, 0, 0, 0);
$warning->addStop(255, 193, 7, 50);
$warning->addStop(255, 255, 255, 100);
$warning25 = $warning->getColorAt(25);
$warning50 = $warning->getColorAt(50);
$warning75 = $warning->getColorAt(75);

/**
 * CSS demo
 */
$color = new Gradient();
$color->addStop(131, 58, 180, 0);
$color->addStop(253, 29, 29, 50);
$color->addStop(253, 252, 176, 100);
$renderer = new CssGradientRenderer($color);
$render = (string)$renderer;

/**
 * CSS direction demo
 */
$renderer->setDirection(45);
$render45 = (string)$renderer;

/**
 * Image demo
 */
$imgrenderer = new ImageGradientRenderer($color);
$imgrenderer->setSize(300, 50);
$imgrender = (string)$imgrenderer;

/**
 * Image format (gif) demo
 */
$imgrenderer->setFormat('gif');
$gifrender = (string)$imgrenderer;

/**
 * Extractor demo (image1.jpg)
 */
$reader1  = (new ImageGradientExtractor(__DIR__.'/image1.jpg', 'jpeg'))->extract();
$readcss1 = new CssGradientRenderer($reader1);

/**
 * Extractor demo (image2.jpg)
 */
$reader2  = (new ImageGradientExtractor(__DIR__.'/image2.jpg', 'jpeg'))->extract();
$readcss2 = new CssGradientRenderer($reader2);

/**
 * Advanced extractor demo (scantest1.jpg)
 */
$scan1a = (new ImageGradientExtractor(__DIR__.'/scantest1.jpg', 'jpeg', ImageGradientExtractor::SCAN_CENTER))->extract();
$scan2a = (new ImageGradientExtractor(__DIR__.'/scantest1.jpg', 'jpeg', ImageGradientExtractor::SCAN_TOP))->extract();
$scan3a = (new ImageGradientExtractor(__DIR__.'/scantest1.jpg', 'jpeg', ImageGradientExtractor::SCAN_BOTTOM))->extract();
$scan4a = (new ImageGradientExtractor(__DIR__.'/scantest1.jpg', 'jpeg', ImageGradientExtractor::SCAN_AVERAGE))->extract();
$scan1center  = new CssGradientRenderer($scan1a);
$scan1top     = new CssGradientRenderer($scan2a);
$scan1bottom  = new CssGradientRenderer($scan3a);
$scan1average = new CssGradientRenderer($scan4a);

/**
 * Advanced extractor demo (scantest2.jpg)
 */
$scan1b = (new ImageGradientExtractor(__DIR__.'/scantest2.jpg', 'jpeg', ImageGradientExtractor::SCAN_CENTER))->extract();
$scan2b = (new ImageGradientExtractor(__DIR__.'/scantest2.jpg', 'jpeg', ImageGradientExtractor::SCAN_TOP))->extract();
$scan3b = (new ImageGradientExtractor(__DIR__.'/scantest2.jpg', 'jpeg', ImageGradientExtractor::SCAN_BOTTOM))->extract();
$scan4b = (new ImageGradientExtractor(__DIR__.'/scantest2.jpg', 'jpeg', ImageGradientExtractor::SCAN_AVERAGE))->extract();
$scan2center  = new CssGradientRenderer($scan1b);
$scan2top     = new CssGradientRenderer($scan2b);
$scan2bottom  = new CssGradientRenderer($scan3b);
$scan2average = new CssGradientRenderer($scan4b);

/**
 * Advanced extractor demo (scantest3.jpg)
 */
$scan1c = (new ImageGradientExtractor(__DIR__.'/scantest3.jpg', 'jpeg', ImageGradientExtractor::SCAN_CENTER))->extract();
$scan2c = (new ImageGradientExtractor(__DIR__.'/scantest3.jpg', 'jpeg', ImageGradientExtractor::SCAN_TOP))->extract();
$scan3c = (new ImageGradientExtractor(__DIR__.'/scantest3.jpg', 'jpeg', ImageGradientExtractor::SCAN_BOTTOM))->extract();
$scan4c = (new ImageGradientExtractor(__DIR__.'/scantest3.jpg', 'jpeg', ImageGradientExtractor::SCAN_AVERAGE))->extract();
$scan3center  = new CssGradientRenderer($scan1c);
$scan3top     = new CssGradientRenderer($scan2c);
$scan3bottom  = new CssGradientRenderer($scan3c);
$scan3average = new CssGradientRenderer($scan4c);

/**
 * Fun demo (mona.jpg)
 */
$monalisa = [];
$mona = new ImageGradientExtractor(__DIR__.'/mona.jpg', 'jpeg');
for($i = 0; $i < 50; $i++) {
	$mona->setScanPosition($i);
	$monalisa[] = (string)(new CssGradientRenderer($mona->extract()));
}

/**
 * Start rendering to index.html when this file is newer
 */
if(!file_exists(__DIR__.'/index.html') || filemtime(__FILE__) > filemtime(__DIR__.'/index.html')) {
	define('RENDERING_DEMO_PAGE', 1);
	ob_start();
}
?>
<style>
body{font-family:monospace;font-size:16px}
div{box-sizing:border-box;margin:0;padding:0}
pre,code{background:#eee;border:1px solid #ccc;padding:0px 5px}
pre{background:#121212;color:#eee;padding:5px;text-align:left;margin:1em 0}
table{width:100%;border-collapse:collapse;font-size:16px;margin:1em 0}
td{border:1px solid #ccc;padding:10px;text-align:center}
h1,h2{border-bottom:1px solid #ccc;padding-bottom:5px}
h2{margin-top:2rem}
.inline{display:inline-block}
.color{display:inline-block;width:100px;height:50px;border-radius:5px;box-shadow:0 0 6px 2px #ccc}
.color+div{margin-top:5px}
.class{color:#80bdff}
.new{color:#ee9aa2}
.sign{color:#ffc107}
i.sign{color:#ffe083}
.symbol{color:#bcbcbc}
label{padding:5px;background:#eee;border:1px solid #ccc;border-radius:5px;cursor:pointer}
input:not(:checked)+.show+.hide{display:none}
input:checked+.show{display:none}
summary{user-select:none;font-size:12px;cursor:pointer;padding:.5rem;border-radius:5px 5px 0 0;background:#eee;border:1px solid #ccc;border-bottom:0}
details[open]{overflow-y:auto;box-shadow:0 3px 6px 2px #ccc}
details[open] summary,summary:hover,label:hover{background:linear-gradient(to bottom,#eee,#ccc)}
details:not([open]) summary{border-radius:5px;border-bottom:1px solid #ccc}
details[open] summary .show{display:none}
details:not([open]) summary .hide{display:none}
summary+table,summary+pre{margin:0}
table tr:last-child td:first-child {border-bottom-left-radius:5px}
img{width:100%}
.sr-only{display:none}
</style>

<h1>PHP Gradient</h1>

<p>The <b>Gradient</b> package can be used an <a href="https://en.wikipedia.org/wiki/Intermediate_representation" target="_blank">intermediate representation</a> of an RGB color gradient.<br>It means that you can use it as an in-between state when you convert a concreate gradient implementation to another.</p>

<p><b>Gradient</b> can be also used as a standalone class for working with color gradients in PHP.<br>It has a very useful <code>getColorAt</code> method to calculate the RGB values at any given point on the gradient.</p>

<p>You can read the full souce of this page in <code>demo.php</code>, just <a href="https://github.com/psyklon-project/PHP-Gradient" target="_blank">visit the repository</a>.</p>

<p>
	<br>
	You can click this label to
	<span class="sr-only">toggle</span>
	<label>
		<input type="checkbox" onclick="toggleAllDetails(this)">
		<span class="show" aria-hidden="true">show</span>
		<span class="hide" aria-hidden="true">hide</span>
		<span>all details</span>
	</label>
	.
</p>

<script>
function toggleAllDetails(cb) {
	var details = document.querySelectorAll('details');
	for(var i = 0; i < details.length; i++) {
		details[i].open = cb.checked;
	}
}
</script>

<h2>Basic usage</h2>

<p>You can create a new black to white gradient like this:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> code</summary>
		<pre>$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>)<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">100</span>)<span class="symbol">;</span></pre>
</details>

<p>Then use the <code>getColorAt</code> method to retrieve colors from any location on the gradient:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<b>$grad->getColorAt(0);</b>
			</td>
			<td>
				<b>$grad->getColorAt(25);</b>
			</td>
			<td>
				<b>$grad->getColorAt(50);</b>
			</td>
			<td>
				<b>$grad->getColorAt(75);</b>
			</td>
			<td>
				<b>$grad->getColorAt(100);</b>
			</td>
		</tr>
		<tr>
			<td>
				<div class="color" style="background:rgb(<?= $col0[0] ?>, <?= $col0[1] ?>, <?= $col0[2] ?>)"></div>
				<div>rgb(<?= $col0[0] ?>, <?= $col0[1] ?>, <?= $col0[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $col25[0] ?>, <?= $col25[1] ?>, <?= $col25[2] ?>)"></div>
				<div>rgb(<?= $col25[0] ?>, <?= $col25[1] ?>, <?= $col25[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $col50[0] ?>, <?= $col50[1] ?>, <?= $col50[2] ?>)"></div>
				<div>rgb(<?= $col50[0] ?>, <?= $col50[1] ?>, <?= $col50[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $col75[0] ?>, <?= $col75[1] ?>, <?= $col75[2] ?>)"></div>
				<div>rgb(<?= $col75[0] ?>, <?= $col75[1] ?>, <?= $col75[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $col100[0] ?>, <?= $col100[1] ?>, <?= $col100[2] ?>)"></div>
				<div>rgb(<?= $col100[0] ?>, <?= $col100[1] ?>, <?= $col100[2] ?>)</div>
			</td>
		</tr>
	</table>
</details>

<p>This feature lets you build simple utilities, like generating darker/lighter variations of colors.<br>Here's an example using Bootstrap's palette:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>Code sample</td>
			<td>
				<div>Original</div>
				<b>$grad->getColorAt(50);</b>
			</td>
			<td>
				<div>Darker</div>
				<b>$grad->getColorAt(25);</b>
			</td>
			<td>
				<div>Lighter</div>
				<b>$grad->getColorAt(75);</b>
			</td>
		</tr>
		<tr>
			<td>
				<pre>$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>)<span class="symbol">;         // Black</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">123</span>, <span class="sign">255</span>, <span class="sign">50</span>)<span class="symbol">;    // Bootstrap PRIMARY color</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">100</span>)<span class="symbol">; // White</span></pre>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $primary50[0] ?>, <?= $primary50[1] ?>, <?= $primary50[2] ?>)"></div>
				<div>rgb(<?= $primary50[0] ?>, <?= $primary50[1] ?>, <?= $primary50[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $primary25[0] ?>, <?= $primary25[1] ?>, <?= $primary25[2] ?>)"></div>
				<div>rgb(<?= $primary25[0] ?>, <?= $primary25[1] ?>, <?= $primary25[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $primary75[0] ?>, <?= $primary75[1] ?>, <?= $primary75[2] ?>)"></div>
				<div>rgb(<?= $primary75[0] ?>, <?= $primary75[1] ?>, <?= $primary75[2] ?>)</div>
			</td>
		</tr>
		<tr>
			<td>
				<pre>$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>)<span class="symbol">;         // Black</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">40</span>, <span class="sign">167</span>, <span class="sign">69</span>, <span class="sign">50</span>)<span class="symbol">;    // Bootstrap SUCCESS color</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">100</span>)<span class="symbol">; // White</span></pre>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $success50[0] ?>, <?= $success50[1] ?>, <?= $success50[2] ?>)"></div>
				<div>rgb(<?= $success50[0] ?>, <?= $success50[1] ?>, <?= $success50[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $success25[0] ?>, <?= $success25[1] ?>, <?= $success25[2] ?>)"></div>
				<div>rgb(<?= $success25[0] ?>, <?= $success25[1] ?>, <?= $success25[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $success75[0] ?>, <?= $success75[1] ?>, <?= $success75[2] ?>)"></div>
				<div>rgb(<?= $success75[0] ?>, <?= $success75[1] ?>, <?= $success75[2] ?>)</div>
			</td>
		</tr>
		<tr>
			<td>
				<pre>$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>)<span class="symbol">;         // Black</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">220</span>, <span class="sign">53</span>, <span class="sign">69</span>, <span class="sign">50</span>)<span class="symbol">;    // Bootstrap DANGER color</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">100</span>)<span class="symbol">; // White</span></pre>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $danger50[0] ?>, <?= $danger50[1] ?>, <?= $danger50[2] ?>)"></div>
				<div>rgb(<?= $danger50[0] ?>, <?= $danger50[1] ?>, <?= $danger50[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $danger25[0] ?>, <?= $danger25[1] ?>, <?= $danger25[2] ?>)"></div>
				<div>rgb(<?= $danger25[0] ?>, <?= $danger25[1] ?>, <?= $danger25[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $danger75[0] ?>, <?= $danger75[1] ?>, <?= $danger75[2] ?>)"></div>
				<div>rgb(<?= $danger75[0] ?>, <?= $danger75[1] ?>, <?= $danger75[2] ?>)</div>
			</td>
		</tr>
		<tr>
			<td>
				<pre>$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>, <span class="sign">0</span>)<span class="symbol">;         // Black</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">193</span>, <span class="sign">7</span>, <span class="sign">50</span>)<span class="symbol">;    // Bootstrap WARNING color</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">255</span>, <span class="sign">100</span>)<span class="symbol">; // White</span></pre>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $warning50[0] ?>, <?= $warning50[1] ?>, <?= $warning50[2] ?>)"></div>
				<div>rgb(<?= $warning50[0] ?>, <?= $warning50[1] ?>, <?= $warning50[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $warning25[0] ?>, <?= $warning25[1] ?>, <?= $warning25[2] ?>)"></div>
				<div>rgb(<?= $warning25[0] ?>, <?= $warning25[1] ?>, <?= $warning25[2] ?>)</div>
			</td>
			<td>
				<div class="color" style="background:rgb(<?= $warning75[0] ?>, <?= $warning75[1] ?>, <?= $warning75[2] ?>)"></div>
				<div>rgb(<?= $warning75[0] ?>, <?= $warning75[1] ?>, <?= $warning75[2] ?>)</div>
			</td>
		</tr>
	</table>
</details>

<p>So far so good, but how are we going to actually render a gradient? Just read on...</p>

<h2>Css renderer</h2>

<p>Rendering a gradient is very simple, just choose one of the bundled renderer classes like <b>CssGradientRenderer</b>, and use it like this:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> code</summary>
		<pre>&lt;?php

$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">131</span>, <span class="sign">58</span>, <span class="sign">180</span>, <span class="sign">0</span>)<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">253</span>, <span class="sign">29</span>, <span class="sign">29</span>, <span class="sign">50</span>)<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">253</span>, <span class="sign">252</span>, <span class="sign">176</span>, <span class="sign">100</span>)<span class="symbol">;</span>

$render <span class="sign">=</span> <span class="new">new</span> <span class="class">CssGradientRenderer</span>($grad)<span class="symbol">;</span>

?&gt;

<span class="symbol">&lt;</span><span class="class">div</span> <span class="new">style</span><span class="symbol">=</span><i class="sign">"width:100%;height:50px;background:</i>&lt;?= $render ?&gt;<i class="sign">"</i><span class="symbol">&gt;&lt;/</span><span class="class">div</span><span class="symbol">&gt;</span>
<span class="symbol">&lt;</span><span class="class">pre</span><span class="symbol">&gt;</span>&lt;?= $render ?&gt;<span class="symbol">&lt;/</span><span class="class">pre</span><span class="symbol">&gt;</span></pre>
</details>

<p>This outputs something similar:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<div style="width:100%;height:50px;background:<?= $render ?>"></div>
				<pre style="margin:10px 0 0 0"><?= $render ?></pre>
			</td>
		</tr>
	</table>
</details>

<p><br><b>CssGradientRenderer</b> has a <code>setDirection</code> method, you can use this, well, to set the direction of the gradient.<br>Assuming the gradient is the same as in the previous example, the render will look like this after calling <code>$render->setDirection(45)</code>:<br><br>(Note that the div was resized to a square, so it's easier to see the direction)</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<div class="inline" style="width:200px;height:200px;background:<?= $render45 ?>"></div>
				<pre style="margin:10px 0 0 0"><?= $render45 ?></pre>
			</td>
		</tr>
	</table>
</details>

<h2>Image renderer</h2>

<p><b>ImageGradientRender</b> has two additional methods, <code>setSize</code> (default is 100x100) and <code>setFormat</code> (default is png).<br>Let's see the previous example using this renderer:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> code</summary>
		<pre>&lt;?php

$grad <span class="sign">=</span> <span class="new">new</span> <span class="class">Gradient</span>()<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">131</span>, <span class="sign">58</span>, <span class="sign">180</span>, <span class="sign">0</span>)<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">253</span>, <span class="sign">29</span>, <span class="sign">29</span>, <span class="sign">50</span>)<span class="symbol">;</span>
$grad<span class="symbol">-></span><span class="class">addStop</span>(<span class="sign">253</span>, <span class="sign">252</span>, <span class="sign">176</span>, <span class="sign">100</span>)<span class="symbol">;</span>

$render <span class="sign">=</span> <span class="new">new</span> <span class="class">ImageGradientRenderer</span>($grad)<span class="symbol">;</span>
$render<span class="symbol">-></span><span class="class">setSize</span>(<span class="sign">300</span>, <span class="sign">50</span>)<span class="symbol">;</span>

?&gt;

<span class="symbol">&lt;</span><span class="class">img</span> <span class="new">src</span><span class="symbol">=</span><i class="sign">"data:image/png;base64,</i>&lt;?= <span class="class">base64_encode</span>($render) ?&gt;<i class="sign">"</i><span class="symbol">&gt;
&lt;</span><span class="class">pre</span><span class="symbol">&gt;</span>&lt;?= <span class="class">substr</span>($render, <span class="sign">0</span>, <span class="sign">20</span>) ?&gt;...<span class="symbol">&lt;/</span><span class="class">pre</span><span class="symbol">&gt;</span></pre>
</details>

<p>This outputs the following:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<img src="data:image/png;base64,<?= base64_encode($imgrender) ?>" style="width:300px;height:50px">
				<pre style="margin:10px 0 0 0"><?= substr($imgrender, 0, 20) ?>...</pre>
			</td>
		</tr>
	</table>
</details>

<p>The same image can be rendered in different formats.<br>This is the output after calling <code>$render->setFormat('gif')</code>:

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<img src="data:image/gif;base64,<?= base64_encode($gifrender) ?>" style="width:300px;height:50px">
				<pre style="margin:10px 0 0 0"><?= substr($gifrender, 0, 20) ?>...</pre>
			</td>
		</tr>
	</table>
</details>

<h2>Image extractor</h2>

<p>An <b>ImageGradientExtractor</b> class is also provided to extract color gradients from images.<br>In this example we load an image, then pass it to the CSS renderer to replicate the gradient extracted from the image in pure CSS:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> code</summary>
		<pre>$grad   <span class="symbol">=</span> (<span class="new">new</span> <span class="class">ImageGradientExtractor</span>(<span class="new">__DIR__</span>.<span class="sign">'/image1.jpg'</span>, <span class="sign">'jpeg'</span>))<span class="symbol">-></span><span class="class">extract</span>()<span class="symbol">;</span>
$render <span class="symbol">=</span> <span class="new">new</span> <span class="class">CssGradientRenderer</span>($grad)<span class="symbol">;</span></pre>
</details>

<p>This outputs the following:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td rowspan="2">
				<b>image1.jpg</b>
			</td>
			<td>Source image</td>
			<td>
				<img src="./image1.jpg">
			</td>
		</tr>
		<tr>
			<td>CSS gradient</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $readcss1 ?>"></div>
			</td>
		</tr>
		<tr>
			<td rowspan="2">
				<b>image2.jpg</b>
			</td>
			<td>Source image</td>
			<td>
				<img src="./image2.jpg">
			</td>
		</tr>
		<tr>
			<td>CSS gradient</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $readcss2 ?>"></div>
			</td>
		</tr>
	</table>
</details>

<p><br>If you read images that contain a clear gradient, you're mostly fine with the default settings.<br><br>If not, <b>ImageGradientExtractor</b> has a third parameter to set the specific line (Y coordinate) you want to scan while extracting the gradient (you may also set this later by calling <code>setScanPosition</code>).<br>By default, the middle line of the image is scanned, however you can set it to any positive integer (Y position on the image), or a constant defined by the class.<br>There is one constant that is particularly interesting, <code>SCAN_AVERAGE</code>, which evaluates all of the colors at a given X coordinate and returns an average color.<br>This is of course slows down the process exponentially with the height of the image, so use it with caution.<br><br>Let's see some examples with more sophisticated images, so you can clearly see the differences given by this setting:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td rowspan="4" style="width:300px">
				<img src="scantest1.jpg">
			</td>
			<td style="width:300px">
				<b>SCAN_TOP</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan1top ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="max-width:300px">
				<b>SCAN_CENTER</b><br><i>(default)</i>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan1center ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_BOTTOM</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan1bottom ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_AVERAGE</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan1average ?>"></div>
			</td>
		</tr>
		<tr style="border-top:7px solid #ccc">
			<td rowspan="4" style="width:300px">
				<img src="scantest2.jpg">
			</td>
			<td style="width:300px">
				<b>SCAN_TOP</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan2top ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="max-width:300px">
				<b>SCAN_CENTER</b><br><i>(default)</i>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan2center ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_BOTTOM</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan2bottom ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_AVERAGE</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan2average ?>"></div>
			</td>
		</tr>
		<tr style="border-top:7px solid #ccc">
			<td rowspan="4" style="width:300px">
				<img src="scantest3.jpg">
			</td>
			<td style="width:300px">
				<b>SCAN_TOP</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan3top ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="max-width:300px">
				<b>SCAN_CENTER</b><br><i>(default)</i>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan3center ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_BOTTOM</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan3bottom ?>"></div>
			</td>
		</tr>
		<tr>
			<td style="width:300px">
				<b>SCAN_AVERAGE</b>
			</td>
			<td>
				<div class="inline" style="width:100%;height:50px;background:<?= $scan3average ?>"></div>
			</td>
		</tr>
	</table>
</details>

<p>And now, just for fun, let's use <code>setScanPositoin</code> to draw the Mona Lisa to 50 <code>div</code>s filled with linear gradients:</p>

<details>
	<summary><span class="sr-only">Toggle</span><span class="show" aria-hidden="true">Show</span><span class="hide" aria-hidden="true">Hide</span> example</summary>
	<table>
		<tr>
			<td>
				<div>
					<div class="inline">
<?php foreach($monalisa as $line): ?>

						<div style="width:120px;height:1px;background:<?= $line ?>"></div>
<?php endforeach; ?>
					</div>
				</div>
				<div style="margin-top:10px">
					<div class="inline">
<?php foreach($monalisa as $line): ?>

						<div style="width:240px;height:2px;background:<?= $line ?>"></div>
<?php endforeach; ?>
					</div>
				</div>
				<div style="margin-top:10px">
					<div class="inline">
<?php foreach($monalisa as $line): ?>

						<div style="width:480px;height:4px;background:<?= $line ?>"></div>
<?php endforeach; ?>
					</div>
				</div>
			</td>
		</tr>
	</table>
</details>

<h2>Future plans</h2>

<p>I will definetly add more renderers/extractors to the package, as well as simple helper classes to work with gradients.<br>For now, I'm happy with the results, especially the image-to-css part, as this is what I wanted to achieve in the first place with this project.</p>

<br><br><br><br><br>
<br><br><br><br><br>

<table>
	<tr>
		<td>Psyklon Project</td>
	</tr>
</table>

<?php

/**
 * Output the rendered page to index.html
 */
if(defined('RENDERING_DEMO_PAGE')) {
	file_put_contents(__DIR__.'/index.html', ob_get_flush());
}
