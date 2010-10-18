<h1>Creating Libraries</h1>
<p>
    When we use the term "Libraries" we are normally referring to the classes that are located in the 
    <kbd>
        libraries
    </kbd>
    directory and described in the Class Reference of this user guide.  In this case, however, we will instead describe how you can create 
    your own libraries within your 
    <dfn>
        application/libraries
    </dfn>
    directory in order to maintain separation between your local resources
    and the global framework resources.
</p>
<p>
    As an added bonus, F-engine permits your libraries to 
    <kbd>
        extend
    </kbd>
    native classes if you simply need to add some functionality 
    to an existing library. Or you can even replace native libraries just by placing identically named versions in your 
    <dfn>
        application/libraries
    </dfn>
    folder.
</p>
<p>
    In summary:
</p>
<ul>
    <li>
        You can create entirely new libraries.
    </li>
    <li>
        You can extend native libraries.
    </li>
    <li>
        You can replace native libraries.
    </li>
</ul>
<p>
    The page below explains these three concepts in detail.
</p>
<p class="important">
    <strong>Note:</strong>
    The Database classes can not be extended or replaced with your own classes,
    nor can the Loader class in PHP 4.  All other classes are able to be replaced/extended.
</p>
<h2>Storage</h2>
<p>
    Your library classes should be placed within your 
    <dfn>
        application/libraries
    </dfn>
    folder, as this is where F-engine will look for them when
    they are initialized.
</p>
<h2>Naming Conventions</h2>
<ul>
    <li>
        File names must be capitalized. For example:&nbsp; 
        <dfn>
            Myclass.php
        </dfn>
    </li>
    <li>
        Class declarations must be capitalized. For example:&nbsp; 
        <kbd>
            class Myclass
        </kbd>
    </li>
    <li>
        Class names and file names must match.
    </li>
</ul>
<h2>The Class File</h2>
<p>
    Classes should have this basic prototype (Note:  We are using the name 
    <kbd>
        Someclass
    </kbd>
    purely as an example):
</p>
<code>
    &lt;?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    <br/>
    <br/>
    class Someclass {
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function some_function()
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    }
    <br/>
    <br/>
    ?&gt;
</code>
<h2>Using Your Class</h2>
<p>
    From within any of your <a href="<? echo site_url();?>userguide/general/controllers">Controller</a>
    functions you can initialize your class using the standard:
</p>
<code>
    $this->load->library('
    <kbd>
        someclass
    </kbd>');
</code>
<p>
    Where <em>someclass</em>
    is the file name, without the ".php" file extension. You can submit the file name capitalized or lower case.
    F-engine doesn't care.
</p>
<p>
    Once loaded you can access your class using the 
    <kbd>
        lower case
    </kbd>
    version:
</p>
<code>
    $this->
    <kbd>
        someclass
    </kbd>->some_function();&nbsp; // Object instances will always be lower case
</code>
<h2>Passing Parameters When Initializing Your Class</h2>
<p>
    In the library loading function you can dynamically pass data via the second parameter and it will be passed to your class
    constructor:
</p>
<code>
    $params = array('type' => 'large', 'color' => 'red');
    <br/>
    <br/>
    $this->load->library('Someclass', 
    <kbd>
        $params
    </kbd>);
</code>
<p>
    If you use this feature you must set up your class constructor to expect data:
</p>
<code>
    &lt;?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    <br/>
    <br/>
    class Someclass {
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function Someclass($params)
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Do something with $params
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    }
    <br/>
    <br/>
    ?&gt;
</code>
<p class="important">
    You can also pass parameters stored in a config file.  Simply create a config file named identically to the class 
    <kbd>
        file name
    </kbd>
    and store it in your 
    <dfn>
        application/config/
    </dfn>
    folder.  Note that if you dynamically pass parameters as described above,
    the config file option will not be available.
</p>
<h2>Utilizing F-engine Resources within Your Library</h2>
<p>
    To access F-engine native resources within your library use the 
    <kbd>
        get_instance()
    </kbd>
    function.
    This function returns the F-engine super object.
</p>
<p>
    Normally from within your controller functions you will call any of the available F-engine functions using the 
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
    </kbd>, however, only works directly within your controllers, your models, or your views.
    If you would like to use F-engine's classes from within your own custom classes you can do so as follows:
</p>
<p>
    First, assign the F-engine object to a variable:
</p>
<code>
    $CI =&amp; get_instance();
</code>
<p>
    Once you've assigned the object to a variable, you'll use that variable <em>instead</em>
    of 
    <kbd>
        $this
    </kbd>:
</p>
<code>
    $CI =&amp; get_instance();
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
        $CI =&amp; get_instance();
    </var>
    <br/>
    <br/>
    <kbd>
        This is very important.
    </kbd>
    Assigning by reference allows you to use the original F-engine object rather than creating a copy of it.
    <br/>
    <br/>
    <kbd>
        Also, please note:
    </kbd>
    If you are running PHP 4 it's usually best to avoid calling 
    <dfn>
        get_instance()
    </dfn>
    from within your class constructors.  PHP 4 has trouble referencing the CI super object within application constructors 
    since objects do not exist until the class is fully instantiated.
</p>
<h2>Replacing Native Libraries with Your Versions</h2>
<p>
    Simply by naming your class files identically to a native library will cause F-engine to use it instead of the native one. To use this 
    feature you must name the file and the class declaration exactly the same as the native library.  For example, to replace the native 
    <kbd>
        Email
    </kbd>
    library 
    you'll create a file named 
    <dfn>
        application/libraries/Email.php
    </dfn>, and declare your class with:
</p>
<code>
    class CI_Email {
    <br/>
    <br/>
    }
</code>
<p>
    Note that most native classes are prefixed with 
    <kbd>
        CI_
    </kbd>.
</p>
<p>
    To load your library you'll see the standard loading function:
</p>
<code>
    $this->load->library('
    <kbd>
        email
    </kbd>');
</code>
<p class="important">
    <strong>Note:</strong>
    At this time the Database classes can not be replaced with your own versions.
</p>
<h2>Extending Native Libraries</h2>
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
        Email
    </kbd>
    class you'll create a file named 
    <dfn>
        application/libraries/
    </dfn>
    <kbd>
        MY_Email.php
    </kbd>, and declare your class with:
</p>
<code>
    class MY_Email extends CI_Email {
    <br/>
    <br/>
    }
</code>
<p>
    Note: If you need to use a constructor in your class make sure you extend the parent constructor:
</p>
<code>
    class MY_Email extends CI_Email {
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;function My_Email()
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::CI_Email();
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;}
    <br/>
    }
</code>
<h3>Loading Your Sub-class</h3>
<p>
    To load your sub-class you'll use the standard syntax normally used.  DO NOT include your prefix.  For example,
    to load the example above, which extends the Email class, you will use:
</p>
<code>
    $this->load->library('
    <kbd>
        email
    </kbd>');
</code>
<p>
    Once loaded you will use the class variable as you normally would for the class you are extending.  In the case of
    the email class all calls will use:
</p>
<code>
    $this->
    <kbd>
        email
    </kbd>->some_function();
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
