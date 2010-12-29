<h1>Path Helper</h1>
<p>
    The Path Helper file contains functions that permits you to work with file paths on the server.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('path');
</code>
<p>
    The following functions are available:
</p>
<h2>set_realpath()</h2>
<p>
    Checks to see if the path exists. This function will return a server path without symbolic links or relative directory structures. An optional second argument will cause an error to be triggered if the path cannot be resolved.
</p>
<code>
    $directory = '/etc/passwd';
    <br/>
    echo set_realpath($directory);
    <br/>
    // returns &quot;/etc/passwd&quot;
    <br/>
    <br/>
    $non_existent_directory = '/path/to/nowhere';
    <br/>
    echo set_realpath($non_existent_directory, TRUE);
    <br/>
    // returns an <strong>error</strong>, as the path could not be resolved
    <br/>
    <br/>
    echo set_realpath($non_existent_directory, FALSE);
    <br/>
    // returns &quot;/path/to/nowhere&quot;
</code>
<h2>&nbsp;</h2>
