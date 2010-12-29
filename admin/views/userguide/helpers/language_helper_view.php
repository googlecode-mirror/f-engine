<h1>Language Helper</h1>
<p>
    The Language Helper file contains functions that assist in working with language files.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('language');
</code>
<p>
    The following functions are available:
</p>
<h2>lang('
    <var>
        language line
    </var>', '
    <var>
        element id
    </var>')
</h2>
<p>
    This function returns a line of text from a loaded language file with simplified syntax 
    that may be more desirable for view files than calling 
    <kbd>
        $this-&gt;lang-&gt;line()
    </kbd>.
    The optional second parameter will also output a form label for you.  Example:
</p>
<code>
    echo lang('
    <samp>
        language_key
    </samp>', '
    <samp>
        form_item_id
    </samp>');
    <br/>
    // becomes &lt;label for="form_item_id"&gt;language_key&lt;/label&gt;
</code>
