<h1>Helper Functions</h1>
<p>
    Helpers, as the name suggests, help you with tasks.  Each helper file is simply a collection of functions in a particular 
    category.  There are 
    <dfn>
        URL Helpers
    </dfn>, that assist in creating links, there are 
    <dfn>
        Form Helpers
    </dfn>
    that help you create form elements, 
    <dfn>
        Text Helpers
    </dfn>
    perform various text formatting routines,
    <dfn>
        Cookie Helpers
    </dfn>
    set and read cookies, 
    <dfn>
        File Helpers
    </dfn>
    help you deal with files, etc.
</p>
<p>
    Unlike most other systems in F-engine, Helpers are not written in an Object Oriented format.  They are simple, procedural functions.
    Each helper function performs one specific task, with no dependence on other functions.
</p>
<p>
    F-engine does not load Helper Files by default, so the first step in using 
    a Helper is to load it.  Once loaded, it becomes globally available in your 
	<a href="<? echo site_url();?>userguide/general/controllers">controller</a>
    and <a href="<? echo site_url();?>userguide/general/views">views</a>.
</p>
<p>
    Helpers are typically stored in your 
    <dfn>
        system/helpers
    </dfn>, or 
    <dfn>
        system/application/helpers 
    </dfn>directory.	F-engine will look first in your 
    <dfn>
        system/application/helpers
    </dfn>
    directory.  If the directory does not exist or the specified helper is not located there CI will instead look in your global
    <dfn>
        system/helpers
    </dfn>
    folder.
</p>
<h2>Loading a Helper</h2>
<p>
    Loading a helper file is quite simple using the following function:
</p>
<code>
    $this->load->helper('
    <var>
        name
    </var>');
</code>
<p>
    Where 
    <var>
        name
    </var>
    is the file name of the helper, without the .php file extension or the "helper" part.
</p>
<p>
    For example, to load the 
    <dfn>
        URL Helper
    </dfn>
    file, which is named 
    <var>
        url_helper.php
    </var>, you would do this:
</p>
<code>
    $this->load->helper('
    <var>
        url
    </var>');
</code>
<p>
    A helper can be loaded anywhere within your controller functions (or even within your View files, although that's not a good practice),
    as long as you load it before you use it.  You can load your helpers in your controller constructor so that they become available
    automatically in any function, or you can load a helper in a specific function that needs it.
</p>
<p class="important">
    Note: The Helper loading function above does not return a value, so don't try to assign it to a variable.  Just use it as shown.
</p>
<h2>Loading Multiple Helpers</h2>
<p>
    If you need to load more than one helper you can specify them in an array, like this:
</p>
<code>
    $this->load->helper( 
    <samp>
        array(
    </samp>'
    <var>
        helper1
    </var>', '
    <var>
        helper2
    </var>', '
    <var>
        helper3
    </var>'
    <samp>
        )
    </samp>
    );
</code>
<h2>Auto-loading Helpers</h2>
<p>
    If you find that you need a particular helper globally throughout your application, you can tell F-engine to auto-load it during system initialization. 
    This is done by opening the 
    <var>
        application/config/autoload.php
    </var>
    file and adding the helper to the autoload array.
</p>
<h2>Using a Helper</h2>
<p>
    Once you've loaded the Helper File containing the function you intend to use, you'll call it the way you would a standard PHP function.
</p>
<p>
    For example, to create a link using the 
    <dfn>
        anchor()
    </dfn>
    function in one of your view files you would do this:
</p>
<code>
    &lt;?php echo anchor('blog/comments', 'Click Here');?&gt;
</code>
<p>
    Where "Click Here" is the name of the link, and "blog/comments" is the URI to the controller/function you wish to link to.
</p>
<h2>"Extending" Helpers</h2>
<p>
    To "extend" Helpers, create a file in your 
    <dfn>
        application/helpers/
    </dfn>
    folder with an identical name to the existing Helper, but prefixed with 
    <kbd>
        MY_
    </kbd>
    (this item is configurable.  See below.).
</p>
<p>
    If all you need to do is add some functionality to an existing helper - perhaps add a function or two, or change how a particular
    helper function operates - then it's overkill to replace the entire helper with your version.  In this case it's better to simply
    "extend" the Helper.  The term "extend" is used loosely since Helper functions are procedural and discrete and cannot be extended
    in the traditional programmatic sense.  Under the hood, this gives you the ability to add to the functions a Helper provides,
    or to modify how the native Helper functions operate.
</p>
<p>
    For example, to extend the native 
    <kbd>
        Array Helper
    </kbd>
    you'll create a file named 
    <dfn>
        application/helpers/
    </dfn>
    <kbd>
        MY_array_helper.php
    </kbd>, and add or override functions:
</p>
<code>
    // any_in_array() is not in the Array Helper, so it defines a new function
    <br/>
    function any_in_array($needle, $haystack)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$needle = (is_array($needle)) ? $needle : array($needle);
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;foreach ($needle as $item)
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (in_array($item, $haystack))
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return TRUE;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;return FALSE;
    <br/>
    }
    <br/>
    <br/>
    // random_element() is included in Array Helper, so it overrides the native function
    <br/>
    function random_element($array)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;shuffle($array);
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;return array_pop($array);
    <br/>
    }
    <br/>
</code>
<h3>Setting Your Own Prefix</h3>
<p>
    The filename prefix for "extending" Helpers is the same used to extend libraries and Core classes.  To set your own prefix, open your 
    <dfn>
        application/config/config.php
    </dfn>
    file and look for this item:
</p>
<code>
    $config['subclass_prefix'] = 'MY_';
</code>
<p>
    Please note that all native F-engine libraries are prefixed with 
    <kbd>
        CI_
    </kbd>
    so DO NOT use that as your prefix.
</p>
<h2>Now What?</h2>
<p>
    In the Table of Contents you'll find a list of all the available Helper Files.  Browse each one to see what they do.
</p>
