<h1>Common Functions</h1>
<p>
    F-engine uses a few functions for its operation that are globally defined, and are available to you at any point. These do not require loading any libraries or helpers.
</p>
<h2>is_really_writable('
    <var>
        path/to/file
    </var>')
</h2>
<p>
    is_writable() returns TRUE on Windows servers when you really can't write to the file as the OS reports to PHP as FALSE only if the read-only attribute is marked. This function determines if a file is actually writable by attempting to write to it first. Generally only recommended on platforms where this information may be unreliable.
</p>
<code>
    if (is_really_writable('file.txt'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;I could write to this if I wanted to&quot;;
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;File is not writable&quot;;
    <br/>
    }
</code>
<h2>config_item('
    <var>
        item_key
    </var>')
</h2>
<p>
    The <a href="../libraries/config.html">Config library</a>
    is the preferred way of accessing configuration information, however config_item() can be used to retrieve single keys. See Config library documentation for more information.
</p>
<h2>show_error('
    <var>
        message
    </var>'), show_404('
    <var>
        page
    </var>'), log_message('
    <var>
        level
    </var>', '
    <samp>
        message
    </samp>')
</h2>
<p>
    These are each outlined on the <a href="errors.html">Error Handling</a>
    page.
</p>
