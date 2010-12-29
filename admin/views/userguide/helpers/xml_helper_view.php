<h1>XML Helper</h1>
<p>
    The XML Helper file contains functions that assist in working with XML data.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('xml');
</code>
<p>
    The following functions are available:
</p>
<h2>xml_convert('
    <var>
        string
    </var>')
</h2>
<p>
    Takes a string as input and converts the following reserved XML characters to entities:
</p>
<p>
    Ampersands: &amp;
    <br/>
    Less then and greater than characters: &lt; &gt;
    <br/>
    Single and double quotes: ' &nbsp;"
    <br/>
    Dashes: -
</p>
<p>
    This function ignores ampersands if they are part of existing character entities.  Example:
</p>
<code>
    $string = xml_convert($string);
</code>
