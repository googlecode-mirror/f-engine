<h1>CSS Tidy</h1>
<p>
	Converts to and from JSON format.
</p>
<p>
CSSTidy is an opensource CSS parser and optimiser. It is available as executeable file (available for Windows, Linux and OSX) which can be controlled per command line and as PHP script (both with almost the same functionality).
</p>
<p>
In opposite to most other CSS parsers, no regular expressions are used and thus CSSTidy has full CSS2 support and a higher reliability.
</p>

<h2>Features</h2>
<p>
<ul>
	<li>Colours like "black" or rgb(0,0,0) are converted to #000000 or rather #000 if possible. Some hex-codes are replaced by their colour names if they are shorter.</li>
	<li>a{property:x;property:y;} becomes a{property:y;} (all duplicate properties are merged)</li>
	<li>margin:1px 1px 1px 1px; becomes margin:1px;</li>
	<li>margin:0px; becomes margin:0;</li>
	<li>a{margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;} becomes a{margin:10px;}</li>
	<li>margin:010.0px; becomes margin:10px;</li>
	<li>all unnecessary whitespace is removed, depending on the compression-level</li>
	<li>all background-properties are merged</li>
	<li>all comments are removed</li>
	<li>the last semicolon in every block can be removed</li>
	<li>missing semicolons are added, incorrect newlines in strings are fixed, missing units are added, bad colors (and color names) are fixed</li>
	<li>property:value ! important; becomes property:value !important;</li>
</ul>
</p>

<h2>Why optimise?</h2>
<p>
If you optimise your CSS code you have faster loading pages and lower traffic costs. So both you and your visitors benefit from an optimisation. If you are interested in a faster loading webpage, websiteoptimization.com might also be an interesting resource.
</p>

<h2>Compression ratio</h2>
<p>
The compression ratio mostly depends on the level of whitespace-removal. Using standard whitespace-removal (which preserves the readability) the compression ratio often is 30% and more. In theory the compression ratio can be 99,99% but only very "stupid" stylesheets will allow those ratios. Also have a look at the examples.
</p>

<h2>Apart from compression</h2>
<p>
If a high compression is not important for you, you can also use CSSTidy to format or fix CSS code for a higher browser compatibility. Apart from the 4 default templates you can specify custom templates so that you can easily format a lot of CSS code using your own coding style. Other features are sorting and changing the case of selectors and properties.
</p>


<h2>More info</h2>
<p>
	<a href="http://csstidy.sourceforge.net/">Project page</a>
</p>