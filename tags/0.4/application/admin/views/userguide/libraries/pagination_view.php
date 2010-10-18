<h1>Pagination Class</h1>
<p>
    F-engine's Pagination class is very easy to use, and it is 100% customizable, either dynamically or via stored preferences.
</p>
<p>
    If you are not familiar with the term "pagination", it refers to links that allows you to navigate from page to page, like this:
</p>
<code>
    <a href="#">&laquo; First</a>&nbsp;&nbsp;<a href="#">&lt;</a>&nbsp;<a href="#">1</a>&nbsp;<a href="#">2</a>&nbsp;<b>3</b>&nbsp;<a href="#">4</a>&nbsp;<a href="#">5</a>&nbsp;<a href="#">&gt;</a>&nbsp;&nbsp;<a href="#">Last &raquo;</a>
</code>
<h2>Example</h2>
<p>
    Here is a simple example showing how to create pagination in one of your <a href="<? echo site_url();?>userguide/general/controllers">controller</a>
    functions:
</p>
<code>
    $this->load->library('pagination');
    <br/>
    <br/>
    $config['base_url'] = 'http://example.com/index.php/test/page/';
    <br/>
    $config['total_rows'] = '200';
    <br/>
    $config['per_page']  = '20';
    <br/>
    <br/>
    $this->pagination->initialize($config);
    <br/>
    <br/>
    echo  $this->pagination->create_links();
</code>
<h3>Notes:</h3>
<p>
    The 
    <var>
        $config
    </var>
    array contains your configuration variables.  It is passed to the 
    <dfn>
        $this->pagination->initialize
    </dfn>
    function as shown above.  Although there are some twenty items you can configure, at
    minimum you need the three shown.  Here is a description of what those items represent:
</p>
<ul>
    <li>
        <strong>base_url</strong>
        This is the full URL to the controller class/function containing your pagination.  In the example
        above, it is pointing to a controller called "Test" and a function called "page".  Keep in mind that you can<a href="<? echo site_url();?>userguide/general/routing">re-route your URI</a>
        if you need a different structure.
    </li>
    <li>
        <strong>total_rows</strong>
        This number represents the total rows in the result set you are creating pagination for.
        Typically this number will be the total rows that your database query returned.
    </li>
    <li>
        <strong>per_page</strong>
        The number of items you intend to show per page.  In the above example, you would be showing 20 items per page.
    </li>
</ul>
<p>
    The 
    <var>
        create_links()
    </var>
    function returns an empty string when there is no pagination to show.
</p>
<h3>Setting preferences in a config file</h3>
<p>
    If you prefer not to set preferences using the above method, you can instead put them into a config file. 
    Simply create a new file called 
    <var>
        pagination.php
    </var>,  add the 
    <var>
        $config
    </var>
    array in that file. Then save the file in: 
    <var>
        config/pagination.php
    </var>
    and it will be used automatically. You 
    will NOT need to use the 
    <dfn>
        $this->pagination->initialize
    </dfn>
    function if you save your preferences in a config file.
</p>
<h2>Customizing the Pagination</h2>
<p>
    The following is a list of all the preferences you can pass to the initialization function to tailor the display.
</p>
<h4>$config['uri_segment'] = 3;</h4>
<p>
    The pagination function automatically determines which segment of your URI contains the page number. If you need
    something different you can specify it.
</p>
<h4>$config['num_links'] = 2;</h4>
<p>
    The number of &quot;digit&quot; links you would like before and after the selected page number. For example, the number 2
    will place two digits on either side, as in the example links at the very top of this page.
</p>
<h4>$config['page_query_string'] = TRUE</h4>
<p>
    By default, the pagination library assume you are using <a href="<? echo site_url();?>userguide/general/urls">URI Segments</a>, and constructs your links something like
</p>
<p>
    <code>
        http://example.com/index.php/test/page/20
    </code>
</p>
<p>
    If you have $config['enable_query_strings']  set to TRUE your links will automatically be re-written using Query Strings. This option can also be explictly set. Using $config['page_query_string'] set to TRUE, the pagination link will become.
</p>
<p>
    <code>
        http://example.com/index.php?c=test&amp;m=page&amp;per_page=20
    </code>
</p>
<p>
    Note that &quot;per_page&quot; is the default query string  passed, however can be configured using $config['query_string_segment'] = 'your_string'
</p>
<h2>Adding Enclosing Markup</h2>
<p>
    If you would like to surround the entire pagination with some markup you can do it with these two prefs:
</p>
<h4>$config['full_tag_open'] = '&lt;p>';</h4>
<p>
    The opening tag placed on the left side of the entire result.
</p>
<h4>$config['full_tag_close'] = '&lt;/p>';</h4>
<p>
    The closing tag placed on the right side of the entire result.
</p>
<h2>Customizing the First Link</h2>
<h4>$config['first_link'] = 'First';</h4>
<p>
    The text you would like shown in the "first" link on the left.
</p>
<h4>$config['first_tag_open'] = '&lt;div>';</h4>
<p>
    The opening tag for the "first" link.
</p>
<h4>$config['first_tag_close'] = '&lt;/div>';</h4>
<p>
    The closing tag for the "first" link.
</p>
<h2>Customizing the Last Link</h2>
<h4>$config['last_link'] = 'Last';</h4>
<p>
    The text you would like shown in the "last" link on the right.
</p>
<h4>$config['last_tag_open'] = '&lt;div>';</h4>
<p>
    The opening tag for the "last" link.
</p>
<h4>$config['last_tag_close'] = '&lt;/div>';</h4>
<p>
    The closing tag for the "last" link.
</p>
<h2>Customizing the "Next" Link</h2>
<h4>$config['next_link'] = '&amp;gt;';</h4>
<p>
    The text you would like shown in the "next" page link.
</p>
<h4>$config['next_tag_open'] = '&lt;div>';</h4>
<p>
    The opening tag for the "next" link.
</p>
<h4>$config['next_tag_close'] = '&lt;/div>';</h4>
<p>
    The closing tag for the "next" link.
</p>
<h2>Customizing the "Previous" Link</h2>
<h4>$config['prev_link'] = '&amp;lt;';</h4>
<p>
    The text you would like shown in the "previous" page link.
</p>
<h4>$config['prev_tag_open'] = '&lt;div>';</h4>
<p>
    The opening tag for the "previous" link.
</p>
<h4>$config['prev_tag_close'] = '&lt;/div>';</h4>
<p>
    The closing tag for the "previous" link.
</p>
<h2>Customizing the "Current Page" Link</h2>
<h4>$config['cur_tag_open'] = '&lt;b>';</h4>
<p>
    The opening tag for the "current" link.
</p>
<h4>$config['cur_tag_close'] = '&lt;/b>';</h4>
<p>
    The closing tag for the "current" link.
</p>
<h2>Customizing the "Digit" Link</h2>
<h4>$config['num_tag_open'] = '&lt;div>';</h4>
<p>
    The opening tag for the "digit" link.
</p>
<h4>$config['num_tag_close'] = '&lt;/div>';</h4>
<p>
    The closing tag for the "digit" link.
</p>
