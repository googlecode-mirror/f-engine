<h1>String Helper</h1>
<p>
    The String Helper file contains functions that assist in working with strings.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('string');
</code>
<p>
    The following functions are available:
</p>
<h2>random_string()</h2>
<p>
    Generates a random string based on the type and length you specify.  Useful for creating passwords or generating random hashes.
</p>
<p>
    The first parameter specifies the type of string, the second parameter specifies the length.  The following choices are available:
</p>
<ul>
    <li>
        <strong>alnum</strong>:&nbsp; Alpha-numeric string with lower and uppercase characters.
    </li>
    <li>
        <strong>numeric</strong>:&nbsp; Numeric string.
    </li>
    <li>
        <strong>nozero</strong>:&nbsp; Numeric string with no zeros.
    </li>
    <li>
        <strong>unique</strong>:&nbsp; Encrypted with MD5 and uniqid(). Note: The length parameter is not available for this type.
        Returns a fixed length 32 character string.
    </li>
</ul>
<p>
    Usage example:
</p>
<code>
    echo random_string('alnum', 16);
</code>
<h2>alternator()</h2>
<p>
    Allows two or more items to be alternated between, when cycling through a loop.  Example:
</p>
<code>
    for ($i = 0; $i < 10; $i++)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo alternator('string one', 'string two');
    <br/>
    }
    <br/>
</code>
<p>
    You can add as many parameters as you want, and with each iteration of your loop the next item will be returned.
</p>
<code>
    for ($i = 0; $i < 10; $i++)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo alternator('one', 'two', 'three', 'four', 'five');
    <br/>
    }
    <br/>
</code>
<p>
    <strong>Note:</strong>
    To use multiple separate calls to this function simply call the function with no arguments to re-initialize.
</p>
<h2>repeater()</h2>
<p>
    Generates repeating copies of the data you submit. Example:
</p>
<code>
    $string = "\n";
    <br/>
    echo repeater($string, 30);
</code>
<p>
    The above would generate 30 newlines.
</p>
<h2>reduce_double_slashes()</h2>
<p>
    Converts double slashes in a string to a single slash, except those found in http://. Example: 
</p>
<code>
    $string = &quot;http://example.com//index.php&quot;;
    <br/>
    echo reduce_double_slashes($string); // results in &quot;http://example.com/index.php&quot;
</code>
<h2>trim_slashes()</h2>
<p>
    Removes any leading/trailing slashes from a string. Example:
    <br/>
    <br/>
    <code>
        $string = &quot;/this/that/theother/&quot;;
        <br/>
        echo trim_slashes($string); // results in this/that/theother
    </code>
</p>
<h2>reduce_multiples()</h2>
<p>
    Reduces multiple instances of a particular character occuring directly after each other. Example:
</p>
<code>
    $string="Fred, Bill,, Joe, Jimmy";
    <br/>
    $string=reduce_multiples($string,","); //results in "Fred, Bill, Joe, Jimmy"
</code>
<p>
    The function accepts the following parameters:
    <code>
        reduce_multiples(string: text to search in, string: character to reduce, boolean: whether to remove the character from the front and end of the string)
    </code>
    The first parameter contains the string in which you want to reduce the multiplies. The second parameter contains the character you want to have reduced.
    The third parameter is FALSE by default; if set to TRUE it will remove occurences of the character at the beginning and the end of the string. Example:
    <code>
        $string=",Fred, Bill,, Joe, Jimmy,";
        <br/>
        $string=reduce_multiples($string, ", ", TRUE); //results in "Fred, Bill, Joe, Jimmy"
    </code>
</p>
<h2>quotes_to_entities()</h2>
<p>
    Converts single and double quotes in a string to the corresponding HTML entities. Example:
</p>
<code>
    $string="Joe's \"dinner\"";
    <br/>
    $string=quotes_to_entities($string); //results in "Joe&amp;#39;s &amp;quot;dinner&amp;quot;"
</code>
<h2>strip_quotes()</h2>
<p>
    Removes single and double quotes from a string. Example:
</p>
<code>
    $string="Joe's \"dinner\"";
    <br/>
    $string=strip_quotes($string); //results in "Joes dinner"
</code>
