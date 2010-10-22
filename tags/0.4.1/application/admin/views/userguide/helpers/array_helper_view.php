<h1>Array Helper</h1>
<p>
    The Array Helper file contains functions that assist in working with arrays.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('array');
</code>
<p>
    The following functions are available:
</p>
<h2>element()</h2>
<p>
    Lets you fetch an item from an array.  The function tests whether the array index is set and whether it has a value.  If
    a value exists it is returned.  If a value does not exist it returns FALSE, or whatever you've specified as the default value via the third parameter.  Example:
</p>
<code>
    $array = array('color' => 'red', 'shape' => 'round', 'size' => '');
    <br/>
    <br/>
    // returns "red"
    <br/>
    echo element('color', $array);
    <br/>
    <br/>
    // returns NULL
    <br/>
    echo element('size', $array, NULL);
</code>
<h2>random_element()</h2>
<p>
    Takes an array as input and returns a random element from it.  Usage example:
</p>
<code>
    $quotes = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"I find that the harder I work, the more luck I seem to have. - Thomas Jefferson",
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Don't stay in bed, unless you can make money in bed. - George Burns",
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"We didn't lose the game; we just ran out of time. - Vince Lombardi",
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"If everything seems under control, you're not going fast enough. - Mario Andretti",
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Reality is merely an illusion, albeit a very persistent one. - Albert Einstein",
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Chance favors the prepared mind - Louis Pasteur"
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    echo random_element($quotes);
</code>
