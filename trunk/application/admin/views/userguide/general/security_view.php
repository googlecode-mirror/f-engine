<h1>Security</h1>
<p>
    This page describes some "best practices" regarding web security, and details
    F-engine's internal security features.
</p>
<h2>URI Security</h2>
<p>
    F-engine is fairly restrictive regarding which characters it allows in your URI strings in order to help
    minimize the possibility that malicious data can be passed to your application.  URIs may only contain the following:
</p>
<ul>
    <li>
        Alpha-numeric text
    </li>
    <li>
        Tilde: ~ 
    </li>
    <li>
        Period: .
    </li>
    <li>
        Colon: :
    </li>
    <li>
        Underscore: _
    </li>
    <li>
        Dash: -
    </li>
</ul>
<h2>GET, POST, and COOKIE Data</h2>
<p>
    GET data is simply disallowed by F-engine since the system utilizes URI segments rather than traditional URL query strings (unless
    you have the query string option enabled in your config file).  The global GET 
    array is <strong>unset</strong>
    by the Input class during system initialization.
</p>
<h2>Register_globals</h2>
<p>
    During system initialization all global variables are unset, except those found in the $_POST and $_COOKIE arrays. The unsetting
    routine is effectively the same as register_globals = off.
</p>
<h2>magic_quotes_runtime</h2>
<p>
    The magic_quotes_runtime directive is turned off during system initialization so that you don't have to remove slashes when
    retrieving data from your database.
</p>
<h1>Best Practices</h1>
<p>
    Before accepting any data into your application, whether it be POST data from a form submission, COOKIE data, URI data,
    XML-RPC data, or even data from the SERVER array, you are encouraged to practice this three step approach:
</p>
<ol>
    <li>
        Filter the data as if it were tainted.
    </li>
    <li>
        Validate the data to ensure it conforms to the correct  type, length, size, etc. (sometimes this step can replace step one)
    </li>
    <li>
        Escape the data before submitting it into your database.
    </li>
</ol>
<p>
    F-engine provides the following functions to assist in this process:
</p>
<ul>
    <li>
        <h2>XSS Filtering</h2>
        <p>
            F-engine comes with a Cross Site Scripting filter.  This filter looks for commonly
            used techniques to embed malicious Javascript into your data, or other types of code that attempt to hijack cookies 
            or do other malicious things. The XSS Filter is described 
			<a href="<?php echo site_url();?>userguide/libraries/input">here</a>.
        </p>
    </li>
    <li>
        <h2>Validate the data</h2>
        <p>
            F-engine has a 
			<a href="<?php echo site_url();?>userguide/libraries/form_validation">Form Validation Class</a>
            that assists you in validating, filtering, and prepping
            your data.
        </p>
    </li>
    <li>
        <h2>Escape all data before database insertion</h2>
        <p>
            Never insert information into your database without escaping it. Please see the section that discusses
			<a href="<?php echo site_url();?>userguide/database/queries">queries</a>
            for more information.
        </p>
    </li>
</ul>
