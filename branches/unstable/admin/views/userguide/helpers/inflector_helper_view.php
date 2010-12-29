<h1>Inflector Helper</h1>

<p>The Inflector Helper file contains functions that permits you to change words to plural, singular, camel case, etc.</p>


<h2>Loading this Helper</h2>

<p>This helper is loaded using the following code:</p>
<code>$this->load->helper('inflector');</code>

<p>The following functions are available:</p>


<h2>singular()</h2>

<p>Changes a plural word to singular.  Example:</p>

<code>
$word = "dogs";<br />
echo singular($word); // Returns "dog"
</code>


<h2>plural()</h2>

<p>Changes a singular word to plural.  Example:</p>

<code>
$word = "dog";<br />
echo plural($word); // Returns "dogs"
</code>


<p>To force a word to end with &quot;es&quot; use a second &quot;true&quot; argument. </p>
<code> $word = &quot;pass&quot;;<br />
echo plural($word, TRUE); // Returns &quot;passes&quot; </code>

<h2>camelize()</h2>
<p>Changes a string of words separated by spaces or underscores to camel case.  Example:</p>

<code>
$word = "my_dog_spot";<br />
echo camelize($word); // Returns "myDogSpot"
</code>


<h2>underscore()</h2>

<p>Takes multiple words separated by spaces and underscores them.  Example:</p>

<code>
$word = "my dog spot";<br />
echo underscore($word); // Returns "my_dog_spot"
</code>


<h2>humanize()</h2>

<p>Takes multiple words separated by underscores and adds spaces between them.  Each word is capitalized. Example:</p>

<code>
$word = "my_dog_spot";<br />
echo humanize($word); // Returns "My Dog Spot"
</code>