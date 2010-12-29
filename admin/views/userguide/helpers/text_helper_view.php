<h1>Text Helper</h1>
<p>
    The Text Helper file contains functions that assist in working with text.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('text');
</code>
<p>
    The following functions are available:
</p>
<h2>word_limiter()</h2>
<p>
    Truncates a string to the number of <strong>words</strong>
    specified.  Example:
</p>
<code>
    $string = "Here is a nice text string consisting of eleven words.";
    <br/>
    <br/>
    $string = word_limiter($string, 4);
    <br/>
    <br/>
    // Returns:  Here is a nice&#8230;
</code>
<p>
    The third parameter is an optional suffix added to the string.  By default it adds an ellipsis.
</p>
<h2>character_limiter()</h2>
<p>
    Truncates a string to the number of <strong>characters</strong>
    specified.  It maintains the integrity
    of words so the character count may be slightly more or less then what you specify. Example:
</p>
<code>
    $string = "Here is a nice text string consisting of eleven words.";
    <br/>
    <br/>
    $string = character_limiter($string, 20);
    <br/>
    <br/>
    // Returns:  Here is a nice text string&#8230;
</code>
<p>
    The third parameter is an optional suffix added to the string, if undeclared this helper uses an ellipsis.
</p>
<h2>ascii_to_entities()</h2>
<p>
    Converts ASCII values to character entities, including high ASCII and MS Word characters that can cause problems when used in a web page,
    so that they can be shown consistently regardless of browser settings or stored reliably in a database.
    There is some dependence on your server's supported character sets, so it may not be 100% reliable in all cases, but for the most
    part it should correctly identify characters outside the normal range (like accented characters). Example:
</p>
<code>
    $string = ascii_to_entities($string);
</code>
<h2>entities_to_ascii()</h2>
<p>
    This function does the opposite of the previous one; it turns character entities back into ASCII.
</p>
<h2>word_censor()</h2>
<p>
    Enables you to censor words within a text string.  The first parameter will contain the original string.  The
    second will contain an array of words which you disallow.  The third (optional) parameter can contain a replacement value
    for the words.  If not specified they are replaced with pound signs: ####.  Example:
</p>
<code>
    $disallowed = array('darn', 'shucks', 'golly', 'phooey');
    <br/>
    <br/>
    $string = word_censor($string, $disallowed, 'Beep!');
</code>
<h2>highlight_code()</h2>
<p>
    Colorizes a string of code (PHP, HTML, etc.).  Example:
</p>
<code>
    $string = highlight_code($string);
</code>
<p>
    The function uses PHP's highlight_string() function, so the colors used are the ones specified in your php.ini file.
</p>
<h2>highlight_phrase()</h2>
<p>
    Will highlight a phrase within a text string.  The first parameter will contain the original string, the second will
    contain the phrase you wish to highlight.  The third and fourth parameters will contain the opening/closing HTML tags
    you would like the phrase wrapped in.  Example:
</p>
<code>
    $string = "Here is a nice text string about nothing in particular.";
    <br/>
    <br/>
    $string = highlight_phrase($string, "nice text", '&lt;span style="color:#990000">', '&lt;/span>');
</code>
<p>
    The above text returns:
</p>
<p>
    Here is a <span style="color:#990000">nice text</span>
    string about nothing in particular.
</p>
<h2>word_wrap()</h2>
<p>
    Wraps text at the specified <strong>character</strong>
    count while maintaining complete words.  Example:
</p>
<code>
    $string = "Here is a simple string of text that will help us demonstrate this function.";
    <br/>
    <br/>
    echo word_wrap($string, 25);
    <br/>
    <br/>
    // Would produce:
    <br/>
    <br/>
    Here is a simple string
    <br/>
    of text that will help
    <br/>
    us demonstrate this
    <br/>
    function
</code>
