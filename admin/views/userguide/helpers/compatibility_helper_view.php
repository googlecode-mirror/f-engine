<h1>Compatibility Helper</h1>
<p>
    The Compatibility Helper file contains PHP 4 implementations of some PHP 5 only native PHP functions and constants.  This can be useful
    if you'd like to take advantage of some of these native function but your application may end up running on a PHP 4 server. 
    In these cases, it may be advantageous to <a href="<?php echo site_url();?>userguide/general/autoloader">Auto-load</a>
    the Compatibility Helper so you
    do not have to load it in each controller.
</p>
<p class="important">
    <strong>Note:</strong>
    There are a few compatibility functions that are in F-engine's native Compat.php file.
    You may use those functions without loading this helper.  The functions are split between that file and this Helper so that only
    functions required by the framework are included by default.  This way, whether or not you load the additional functions in this Helper
    remains your choice.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('compatibility');
</code>
<h2>Available Constants</h2>
<p>
    The following constants are available:
</p>
<h3>PHP_EOL</h3>
<p>
    The newline character for the server's current OS, e.g. on Windows systems "\r\n", on *nix "\n".<h2>Available Functions</h2>
    <p>
        The following functions are available (see linked PHP documentation for documentation):
    </p>
    <h3><a href="http://us.php.net/manual/en/function.file-put-contents.php">file_put_contents()</a> - The fourth parameter, 
        <var>
            $context
        </var>, is not supported.
    </h3>
    <h3><a href="http://us.php.net/manual/en/function.fputcsv.php">fputcsv()</a></h3>
    <h3><a href="http://us.php.net/manual/en/function.http-build-query.php">http_build_query()</a></h3>
    <h3><a href="http://us.php.net/manual/en/function.str-ireplace.php">str_ireplace()</a> - The fourth parameter, 
        <var>
            $count
        </var>, is not supported, as PHP 4 would make it become required.
    </h3>
    <h3><a href="http://us.php.net/manual/en/function.stripos.php">stripos()</a></h3>
