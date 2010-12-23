<h1>URL Helper</h1>
<p>
    The URL Helper file contains functions that assist in working with URLs.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('url');
</code>
<p>
    The following functions are available:
</p>
<h2>site_url()</h2>
<p>
    Returns your site URL, as specified in your config file.  The index.php file (or whatever you have set as your 
    site 
    <dfn>
        index_page
    </dfn>
    in your config file) will be added to the URL, as will any URI segments you pass to the function.
</p>
<p>
    You are encouraged to use this function any time you need to generate a local URL so that your pages become more portable
    in the event your URL changes.
</p>
<p>
    Segments can be optionally passed to the function as a string or an array.  Here is a string example:
</p>
<code>
    echo site_url("news/local/123");
</code>
<p>
    The above example would return something like: http://example.com/index.php/news/local/123
</p>
<p>
    Here is an example of segments passed as an array:
</p>
<code>
    $segments = array('news', 'local', '123');
    <br/>
    <br/>
    echo site_url($segments);
</code>
<h2>base_url()</h2>
<p>
    Returns your site base URL, as specified in your config file.  Example:
</p>
<code>
    echo base_url();
</code>
<h2>current_url()</h2>
<p>
    Returns the full URL (including segments) of the page being currently viewed.
</p>
<h2>uri_segments()</h2>
<p>
    Returns the URI segments of any page that contains this function.  For example, if your URL was this:
</p>
<code>
    http://some-site.com/blog/comments/123
</code>
<p>
    The function would return:
</p>
<code>
    blog/comments/123
</code>
<h2>index_page()</h2>
<p>
    Returns your site "index" page, as specified in your config file.  Example:
</p>
<code>
    echo index_page();
</code>
<h2>anchor()</h2>
<p>
    Creates a standard HTML anchor link based on your local site URL:
</p>
<code>
    &lt;a href="http://example.com">Click Here&lt;/a>
</code>
<p>
    The tag has three optional parameters:
</p>
<code>
    anchor(
    <var>
        uri segments
    </var>, 
    <var>
        text
    </var>, 
    <var>
        attributes
    </var>)
</code>
<p>
    The first parameter can contain any segments you wish appended to the URL.  As with the 
    <dfn>
        site_url()
    </dfn>
    function above,
    segments can be a string or an array.
</p>
<p>
    <strong>Note:</strong>&nbsp; If you are building links that are internal to your application do not include the base URL (http://...).  This
    will be added automatically from the information specified in your config file. Include only the URI segments you wish appended to the URL.
</p>
<p>
    The second segment is the text you would like the link to say.  If you leave it blank, the URL will be used.
</p>
<p>
    The third parameter can contain a list of attributes you would like added to the link.  The attributes can be a simple string or an associative array.
</p>
<p>
    Here are some examples:
</p>
<code>
    echo anchor('news/local/123', 'My News');
</code>
<p>
    Would produce: &lt;a href="http://example.com/index.php/news/local/123" title="My News">My News&lt;/a>
</p>
<code>
    echo anchor('news/local/123', 'My News', array('title' => 'The best news!'));
</code>
<p>
    Would produce: &lt;a href="http://example.com/index.php/news/local/123" title="The best news!">My News&lt;/a>
</p>
<h2>anchor_popup()</h2>
<p>
    Nearly identical to the 
    <dfn>
        anchor()
    </dfn>
    function except that it opens the URL in a new window.
    You can specify JavaScript window attributes in the third parameter to control how the window is opened. If
    the third parameter is not set it will simply open a new window with your own browser settings.  Here is an example
    with attributes:
</p>
<code>
    $atts = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'width'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '800',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'height'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '600',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'scrollbars' => 'yes',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'status'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> 'yes',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'resizable'&nbsp;&nbsp;=> 'yes',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'screenx'&nbsp;&nbsp;&nbsp;&nbsp;=> '0',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'screeny'&nbsp;&nbsp;&nbsp;&nbsp;=> '0'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    echo anchor_popup('news/local/123', 'Click Me!', $atts);
</code>
<p>
    Note: The above attributes are the function defaults so you only need to set the ones that are different from what you need.
    If you want the function to use all of its defaults simply pass an empty array in the third parameter:
</p>
<code>
    echo anchor_popup('news/local/123', 'Click Me!', array());
</code>
<h2>mailto()</h2>
<p>
    Creates a standard HTML email link.  Usage example:
</p>
<code>
    echo mailto('me@my-site.com', 'Click Here to Contact Me');
</code>
<p>
    As with the 
    <dfn>
        anchor()
    </dfn>
    tab above, you can set attributes using the third parameter.
</p>
<h2>safe_mailto()</h2>
<p>
    Identical to the above function except it writes an obfuscated version of the mailto tag using ordinal numbers
    written with JavaScript to help prevent the email address from being harvested by spam bots.
</p>
<h2>auto_link()</h2>
<p>
    Automatically turns URLs and email addresses contained in a string into links.  Example:
</p>
<code>
    $string = auto_link($string);
</code>
<p>
    The second parameter determines whether URLs and emails are converted or just one or the other.  Default behavior is both
    if the parameter is not specified.  Email links are encoded as safe_mailto() as shown above.
</p>
<p>
    Converts only URLs:
</p>
<code>
    $string = auto_link($string, 'url');
</code>
<p>
    Converts only Email addresses:
</p>
<code>
    $string = auto_link($string, 'email');
</code>
<p>
    The third parameter determines whether links are shown in a new window.  The value can be TRUE or FALSE (boolean):
</p>
<code>
    $string = auto_link($string, 'both', TRUE);
</code>
<h2>url_title()</h2>
<p>
    Takes a string as input and creates a human-friendly URL string. This is useful if, for example, you have a blog
    in which you'd like to use the title of your entries in the URL.  Example:
</p>
<code>
    $title = "What's wrong with CSS?";
    <br/>
    <br/>
    $url_title = url_title($title);
    <br/>
    <br/>
    // Produces:  whats-wrong-with-css
</code>
<p>
    The second parameter determines the word delimiter.  By default dashes are used.  Options are: 
    <dfn>
        dash
    </dfn>, or 
    <dfn>
        underscore
    </dfn>:
</p>
<code>
    $title = "What's wrong with CSS?";
    <br/>
    <br/>
    $url_title = url_title($title, 'underscore');
    <br/>
    <br/>
    // Produces:  whats_wrong_with_css
</code>
<h3>prep_url()</h3>
<p>
    This function will add 
    <kbd>
        http://
    </kbd>
    in the event it is missing from a URL.  Pass the URL string to the function like this:
</p>
<code>
    $url = "example.com";
    <br/>
    <br/>
    $url = prep_url($url);
</code>
<h2>redirect()</h2>
<p>
    Does a "header redirect" to the local URI specified. Just like other functions in this helper, this one is designed 
    to redirect to a local URL within your site.  You will <strong>not</strong>
    specify the full site URL, but rather simply the URI segments
    to the controller you want to direct to. The function will build the URL based on your config file values.
</p>
<p>
    The optional second parameter allows you to choose between the "location" 
    method (default) or the "refresh" method.  Location is faster, but on Windows servers it can sometimes be a problem.  The optional third parameter allows you to send a specific HTTP Response Code - this could be used for example to create 301 redirects for search engine purposes. The default Response Code is 302. The third parameter is <em>only</em>
    available with 'location' redirects, and not 'refresh'. Examples:
</p>
<code>
    if ($logged_in == FALSE)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;redirect('/login/form/', 'refresh');
    <br/>
    }
    <br/>
    <br/>
    // with 301 redirect
    <br/>
    redirect('/article/13', 'location', 301);
</code>
<p class="important">
    <strong>Note:</strong>
    In order for this function to work it must be used before anything is outputted
    to the browser since it utilizes server headers.
    <br/>
    <strong>Note:</strong>
    For  very fine grained control over headers, you should use the <a href="<?php echo site_url();?>userguide/libraries/output">Output  Library</a>'s set_header() function.
</p>
