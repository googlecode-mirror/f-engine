<h1>URI Class</h1>
<p>
    The URI Class provides functions that help you retrieve information from your URI strings. If you use URI routing, you can
    also retrieve information about the re-routed segments.
</p>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<h2>$this->uri->segment(
    <var>
        n
    </var>)
</h2>
<p>
    Permits you to retrieve a specific segment. Where 
    <var>
        n
    </var>
    is the segment number you wish to retrieve.
    Segments are numbered from left to right. For example, if your full URL is this:
</p>
<code>
    http://example.com/index.php/news/local/metro/crime_is_up
</code>
<p>
    The segment numbers would be this:
</p>
<ol>
    <li>
        news
    </li>
    <li>
        local
    </li>
    <li>
        metro
    </li>
    <li>
        crime_is_up
    </li>
</ol>
<p>
    By default the function returns FALSE (boolean) if the segment does not exist. There is an optional second parameter that
    permits you to set your own default value if the segment is missing.
    For example, this would tell the function to return the number zero in the event of failure:
</p>
<code>
    $product_id = $this->uri->segment(3, 0);
</code>
<p>
    It helps avoid having to write code like this:
</p>
<code>
    if ($this->uri->segment(3) === FALSE)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$product_id = 0;
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$product_id = $this->uri->segment(3);
    <br/>
    }
    <br/>
</code>

<h2>$this->uri->param(
    <var>
        n
    </var>)
</h2>
<p>
    This function is identical to the previous one, except that retrieved values starts as of controller name.
</p>


<h2>$this->uri->rsegment(
    <var>
        n
    </var>)
</h2>
<p>
    This function is identical to the first one, except that it lets you retrieve a specific segment from your 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
<h2>$this->uri->slash_segment(
    <var>
        n
    </var>)
</h2>
<p>
    This function is almost identical to 
    <dfn>
        $this->uri->segment()
    </dfn>, except it adds a trailing and/or leading slash based on the second
    parameter.  If the parameter is not used, a trailing slash added.  Examples:
</p>
<code>
    $this->uri->slash_segment(
    <var>
        3
    </var>);
    <br/>
    $this->uri->slash_segment(
    <var>
        3
    </var>, 'leading');
    <br/>
    $this->uri->slash_segment(
    <var>
        3
    </var>, 'both');
</code>
<p>
    Returns:
</p>
<ol>
    <li>
        segment/
    </li>
    <li>
        /segment
    </li>
    <li>
        /segment/
    </li>
</ol>
<h2>$this->uri->slash_rsegment(
    <var>
        n
    </var>)
</h2>
<p>
    This function is identical to the previous one, except that it lets you add slashes a specific segment from your 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
<h2>$this->uri->uri_to_assoc(
    <var>
        n
    </var>)
</h2>
<p>
    This function lets you turn URI segments into and associative array of key/value pairs.  Consider this URI:
</p>
<code>
    index.php/user/search/name/joe/location/UK/gender/male
</code>
<p>
    Using this function you can turn the URI into an associative array with this prototype:
</p>
<code>
    [array]
    <br/>
    (
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;'name' => 'joe'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;'location'	=> 'UK'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;'gender'	=> 'male'
    <br/>
    )
</code>
<p>
    The first parameter of the function lets you set an offset.  By default it is set to 
    <kbd>
        3
    </kbd>
    since your
    URI will normally contain a controller/function in the first and second segments. Example:
</p>
<code>
    $array = $this->uri->uri_to_assoc(3);
    <br/>
    <br/>
    echo $array['name'];
</code>
<p>
    The second parameter lets you set default key names, so that the array returned by the function will always contain expected indexes, even if missing from the URI. Example:
</p>
<code>
    $default = array('name', 'gender', 'location', 'type', 'sort');
    <br/>
    <br/>
    $array = $this->uri->uri_to_assoc(3, $default);
</code>
<p>
    If the URI does not contain a value in your default, an array index will be set to that name, with a value of FALSE.
</p>
<p>
    Lastly, if a corresponding value is not found for a given key (if there is an odd number of URI segments) the value will be set to FALSE (boolean).
</p>
<h2>$this->uri->ruri_to_assoc(
    <var>
        n
    </var>)
</h2>
<p>
    This function is identical to the previous one, except that it creates an associative array using the 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
<h2>$this->uri->assoc_to_uri()</h2>
<p>
    Takes an associative array as input and generates a URI string from it.  The array keys will be included in the string.  Example:
</p>
<code>
    $array = array('product' => 'shoes', 'size' => 'large', 'color' => 'red');
    <br/>
    <br/>
    $str = $this->uri->assoc_to_uri($array);
    <br/>
    <br/>
    // Produces:  product/shoes/size/large/color/red
</code>
<h2>$this->uri->uri_string()</h2>
<p>
    Returns a string with the complete URI.  For example, if this is your full URL:
</p>
<code>
    http://example.com/index.php/news/local/345
</code>
<p>
    The function would return this:
</p>
<code>
    /news/local/345
</code>
<h2>$this->uri->ruri_string(
    <var>
        n
    </var>)
</h2>
<p>
    This function is identical to the previous one, except that it returns the 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
<h2>$this->uri->total_segments()</h2>
<p>
    Returns the total number of segments.
</p>
<h2>$this->uri->total_rsegments()</h2>
<p>
    This function is identical to the previous one, except that it returns the total number of segments in your 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
<h2>$this->uri->segment_array()</h2>
<p>
    Returns an array containing the URI segments.  For example:
</p>
<code>
    $segs = $this->uri->segment_array();
    <br/>
    <br/>
    foreach ($segs as $segment)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $segment;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo '&lt;br />';
    <br/>
    }
</code>
<h2>$this->uri->rsegment_array()</h2>
<p>
    This function is identical to the previous one, except that it returns the array of segments in your 
    re-routed URI in the event you are using F-engine's <a href="<? echo site_url();?>userguide/general/routing">URI Routing</a>
    feature.
</p>
