<h1>Creating Ancillary Classes</h1>
<p>
    In some cases you may want to develop classes that exist apart from your controllers but have the ability to
    utilize all of F-engine's resources. This is easily possible as you'll see.
</p>
<h2>get_instance()</h2>
<p>
    <strong>Any class that you instantiate within your controller functions can access CodeIgniter's native resources</strong>
    simply by using the 
    <kbd>
        get_instance()
    </kbd>
    function.
    This function returns the main F-engine object.
</p>
<p>
    Normally, to call any of the available F-engine functions requires you to use the 
    <kbd>
        $this
    </kbd>
    construct:
</p>
<code>
    <strong>$this</strong>->load->helper('url');
    <br/>
    <strong>$this</strong>->load->library('session');
    <br/>
    <strong>$this</strong>->config->item('base_url');
    <br/>
    etc.
</code>
<p>
    <kbd>
        $this
    </kbd>, however, only works within your controllers, your models, or your views.
    If you would like to use F-engine's classes from within your own custom classes you can do so as follows:
</p>
<p>
    First, assign the F-engine object to a variable:
</p>
<code>
    $CI =& get_instance();
</code>
<p>
    Once you've assigned the object to a variable, you'll use that variable <em>instead</em>
    of 
    <kbd>
        $this
    </kbd>:
</p>
<code>
    $CI =& get_instance();
    <br/>
    <br/>
    $CI->load->helper('url');
    <br/>
    $CI->load->library('session');
    <br/>
    $CI->config->item('base_url');
    <br/>
    etc.
</code>
<p class="important">
    <strong>Note:</strong>
    You'll notice that the above get_instance() function is being passed by reference:
    <br/>
    <br/>
    <var>
        $CI =& get_instance();
    </var>
    <br/>
    <br/>
    This is very important. Assigning by reference allows you to use the original F-engine object rather than creating a copy of it.
</p>
