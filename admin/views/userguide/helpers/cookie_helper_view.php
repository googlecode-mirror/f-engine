<h1>Cookie Helper</h1>
<p>
    The Cookie Helper file contains functions that assist in working with cookies.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('cookie');
</code>
<p>
    The following functions are available:
</p>
<h2>set_cookie()</h2>
<p>
    Sets a cookie containing the values you specify.  There are two ways to pass information to this function so that a cookie can be set:
    Array Method, and Discrete Parameters:
</p>
<h4>Array Method</h4>
<p>
    Using this method, an associative array is passed to the first parameter:
</p>
<code>
    $cookie = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'name'&nbsp;&nbsp;&nbsp;=> 'The Cookie Name',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'value'&nbsp;&nbsp;=> 'The Value',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'expire' => '86500',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'domain' => '.some-domain.com',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'path'&nbsp;&nbsp;&nbsp;=> '/',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'prefix' => 'myprefix_',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    set_cookie($cookie);
</code>
<p>
    <strong>Notes:</strong>
</p>
<p>
    Only the name and value are required.
</p>
<p>
    The expiration is set in <strong>seconds</strong>, which will be added to the current time.  Do not include the time, but rather only the 
    number of seconds from <em>now</em>
    that you wish the cookie to be valid.  If the expiration is set to
    zero the cookie will only last as long as the browser is open.
</p>
<p>
    To delete a cookie set it with the expiration blank.
</p>
<p>
    For site-wide cookies regardless of how your site is requested, add your URL to the <strong>domain</strong>
    starting with a period, like this:  .your-domain.com
</p>
<p>
    The path is usually not needed since the function sets a root path.
</p>
<p>
    The prefix is only needed if you need to avoid name collisions with other identically named cookies for your server.
</p>
<h4>Discrete Parameters</h4>
<p>
    If you prefer, you can set the cookie by passing data using individual parameters:
</p>
<code>
    set_cookie($name, $value, $expire, $domain, $path, $prefix);
</code>
<h2>get_cookie()</h2>
<p>
    Lets you fetch a cookie.  The first parameter will contain the name of the cookie you are looking for (including any prefixes):
</p>
<code>
    get_cookie('some_cookie');
</code>
<p>
    The function returns FALSE (boolean) if the item you are attempting to retrieve does not exist.
</p>
<p>
    The second optional parameter lets you run the data through the XSS filter.  It's enabled by setting the second parameter to boolean TRUE;
</p>
<p>
    <code>
        get_cookie('some_cookie', TRUE);
    </code>
</p>
<h2>delete_cookie()</h2>
<p>
    Lets you delete a cookie.  Unless you've set a custom path or other values, only the name of the cookie is needed:
</p>
<code>
    delete_cookie("name");
</code>
<p>
    This function is otherwise identical to 
    <dfn>
        set_cookie()
    </dfn>, except that it does not have the value and expiration parameters.  You can submit an array
    of values in the first parameter or you can set discrete parameters.
</p>
<code>
    delete_cookie($name, $domain, $path, $prefix)
</code>
