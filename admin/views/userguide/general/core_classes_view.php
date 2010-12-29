<h1>Creating Core System Classes</h1>
<p>
    Every time F-engine runs there are several base classes that are initialized automatically as part of the core framework.
    It is possible, however, to swap any of the core system classes with your own versions or even extend the core versions.
</p>
<p>
    <strong>Most users will never have any need to do this,
        but the option to replace or extend them does exist for those who would like to significantly alter the F-engine core.</strong>
</p>
<p class="important">
    <strong>Note:</strong>&nbsp; Messing with a core system class has a lot of implications, so make sure you
    know what you are doing before attempting it.
</p>
<h2>System Class List</h2>
<p>
    The following is a list of the core system files that are invoked every time F-engine runs:
</p>
<ul>
    <li>
        Benchmark
    </li>
    <li>
        Config
    </li>
    <li>
        Controller
    </li>
    <li>
        Exceptions
    </li>
    <li>
        Hooks
    </li>
    <li>
        Input
    </li>
    <li>
        Language
    </li>
    <li>
        Loader
    </li>
    <li>
        Log
    </li>
    <li>
        Output
    </li>
    <li>
        Router
    </li>
    <li>
        URI
    </li>
</ul>
<h2>Replacing Core Classes</h2>
<p>
    To use one of your own system classes instead of a default one simply place your version inside your local 
    <dfn>
        application/libraries
    </dfn>
    directory:
</p>
<code>
    application/libraries/
    <dfn>
        some-class.php
    </dfn>
</code>
<p>
    If this directory does not exist you can create it.
</p>
<p>
    Any file named identically to one from the list above will be used instead of the one normally used.
</p>
<p>
    Please note that your class must use 
    <kbd>
        CI
    </kbd>
    as a prefix. For example, if your file is named 
    <kbd>
        Input.php
    </kbd>
    the class will be named:
</p>
<code>
    class CI_Input {
    <br/>
    <br/>
    }
</code>
<h2>Extending Core Class</h2>
<p>
    If all you need to do is add some functionality to an existing library - perhaps add a function or two - then
    it's overkill to replace the entire library with your version.  In this case it's better to simply extend the class.
    Extending a class is nearly identical to replacing a class with a couple exceptions:
</p>
<ul>
    <li>
        The class declaration must extend the parent class.
    </li>
    <li>
        Your new class name and filename must be prefixed with 
        <kbd>
            MY_
        </kbd>
        (this item is configurable.  See below.).
    </li>
</ul>
<p>
    For example, to extend the native 
    <kbd>
        Input
    </kbd>
    class you'll create a file named 
    <dfn>
        application/libraries/
    </dfn>
    <kbd>
        MY_Input.php
    </kbd>, and declare your class with:
</p>
<code>
    class MY_Input extends CI_Input {
    <br/>
    <br/>
    }
</code>
<p>
    Note: If you need to use a constructor in your class make sure you extend the parent constructor:
</p>
<code>
    class MY_Input extends CI_Input {
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function My_Input()
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::CI_Input();
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    }
</code>
<p class="important">
    <strong>Tip:</strong>&nbsp; Any functions in your class that are named identically to the functions in the parent class will be used instead of the native ones
    (this is known as "method overriding").
    This allows you to substantially alter the F-engine core.
</p>
<p>
    If you are extending the Controller core class, then be sure to extend your new class in your application controller's constructors.
</p>
<code>
    class Welcome extends MY_Controller {
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function Welcome()
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::MY_Controller();
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function index()
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->load->view('welcome_message');
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    }
</code>
<h3>Setting Your Own Prefix</h3>
<p>
    To set your own sub-class prefix, open your 
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
