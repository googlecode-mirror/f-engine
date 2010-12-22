<h1>Input Class</h1>
<p>
    The Input Class serves two purposes:
</p>
<ol>
    <li>
        It pre-processes global input data for security.
    </li>
    <li>
        It provides some helper functions for fetching input data and pre-processing it.
    </li>
</ol>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<h2>Security Filtering</h2>
<p>
    The security filtering function is called automatically when a new <a href="../general/controllers.html">controller</a>
    is invoked.  It does the following:
</p>
<ul>
    <li>
        Destroys the global GET array.  Since F-engine does not utilize GET strings, there is no reason to allow it.
    </li>
    <li>
        Destroys all global variables in the event register_globals is turned on.
    </li>
    <li>
        Filters the POST/COOKIE array keys, permitting only alpha-numeric (and a few other) characters.
    </li>
    <li>
        Provides XSS (Cross-site Scripting Hacks) filtering.  This can be enabled globally, or upon request.
    </li>
    <li>
        Standardizes newline characters to \n
    </li>
</ul>
<h2>XSS Filtering</h2>
<p>
    F-engine comes with a Cross Site Scripting Hack prevention filter which can either run automatically to filter 
    all POST and COOKIE data that is encountered, or you can run it on a per item basis.  By default it does <strong>not</strong>
    run globally since it requires a bit of processing overhead, and since you may not need it in all cases.
</p>
<p>
    The XSS filter looks for commonly used techniques to trigger Javascript or other types of code that attempt to hijack cookies
    or do other malicious things.  If anything disallowed is encountered it is rendered safe by converting the data to character entities.
</p>
<p>
    Note: This function should only be used to deal with data upon submission. It's not something that should be used for general runtime processing since it requires a fair amount of processing overhead.
</p>
<p>
    To filter data through the XSS filter use this function:
</p>
<h2>$this->input->xss_clean()</h2>
<p>
    Here is an usage example:
</p>
<code>
    $data = $this->input->xss_clean($data);
</code>
<p>
    If you want the filter to run automatically every time it encounters POST or COOKIE data you can enable it by opening your
    <kbd>
        application/config/config.php
    </kbd>
    file and setting this:
</p>
<code>
    $config['global_xss_filtering'] = TRUE;
</code>
<p>
    Note: If you use the form validation class, it gives you the option of XSS filtering as well.
</p>
<p>
    An optional second parameter, 
    <dfn>
        is_image
    </dfn>, allows this function to be used to test images for potential XSS attacks, useful for file upload security.  When this second parameter is set to 
    <dfn>
        TRUE
    </dfn>, instead of returning an altered string, the function returns TRUE if the image is safe, and FALSE if it contained potentially malicious information that a browser may attempt to execute.
</p>
<code>
    if ($this->input->xss_clean($file, TRUE) === FALSE)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;// file failed the XSS test
    <br/>
    }
</code>
<h2>Using POST, COOKIE, or SERVER Data</h2>
<p>
    F-engine comes with three helper functions that let you fetch POST, COOKIE or SERVER items.  The main advantage of using the provided
    functions rather than fetching an item directly ($_POST['something']) is that the functions will check to see if the item is set and
    return false (boolean) if not.  This lets you conveniently use data without having to test whether an item exists first.
    In other words, normally you might do something like this:
</p>
<code>
    if ( ! isset($_POST['something']))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$something = FALSE;
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$something = $_POST['something'];
    <br/>
    }
</code>
<p>
    With F-engine's built in functions you can simply do this:
</p>
<code>
    $something = $this->input->post('something');
</code>
<p>
    The three functions are:
</p>
<ul>
    <li>
        $this->input->post()
    </li>
    <li>
        $this->input->cookie()
    </li>
    <li>
        $this->input->server()
    </li>
</ul>
<h2>$this->input->post()</h2>
<p>
    The first parameter will contain the name of the POST item you are looking for:
</p>
<code>
    $this->input->post('some_data');
</code>
<p>
    The function returns FALSE (boolean) if the item you are attempting to retrieve does not exist.
</p>
<p>
    The second optional parameter lets you run the data through the XSS filter.  It's enabled by setting the second parameter to boolean TRUE;
</p>
<code>
    $this->input->post('some_data', TRUE);
</code>
<h2>$this->input->get()</h2>
<p>
    This function is identical to the post function, only it fetches get data:
</p>
<code>
    $this->input->get('some_data', TRUE);
</code>
<h2>$this->input->get_post()</h2>
<p>
    This function will search through both the post and get streams for data, looking first in post, and then in get:
</p>
<code>
    $this->input->get_post('some_data', TRUE);
</code>
<h2>$this->input->cookie()</h2>
<p>
    This function is identical to the post function, only it fetches cookie data:
</p>
<code>
    $this->input->cookie('some_data', TRUE);
</code>
<h2>$this->input->server()</h2>
<p>
    This function is identical to the above functions, only it fetches server data:
</p>
<code>
    $this->input->server('some_data');
</code>
<h2>$this->input->ip_address()</h2>
<p>
    Returns the IP address for the current user.  If the IP address is not valid, the function will return an IP of: 0.0.0.0
</p>
<code>
    echo $this->input->ip_address();
</code>
<h2>$this->input->valid_ip(
    <var>
        $ip
    </var>)
</h2>
<p>
    Takes an IP address as input and returns TRUE or FALSE (boolean) if it is valid or not.  Note:  The $this->input->ip_address() function above
    validates the IP automatically.
</p>
<code>
    if ( ! $this-&gt;input-&gt;valid_ip($ip))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; echo 'Not Valid';
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; echo 'Valid';
    <br/>
    }
</code>
<h2>$this->input->user_agent()</h2>
<p>
    Returns the user agent (web browser) being used by the current user. Returns FALSE if it's not available.
</p>
<code>
    echo $this->input->user_agent();
</code>
