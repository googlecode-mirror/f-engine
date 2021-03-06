<h1>Loader Class</h1>
<p>
    Loader, as the name suggests, is used to load elements.  These elements can be libraries (classes) <a href="<?php echo site_url();?>userguide/general/views">View files</a>,<a href="<?php echo site_url();?>userguide/general/helpers">Helpers</a>, <a href="<? echo site_url();?>userguide/general/plugins">Plugins</a>, or your own files.
</p>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<p>
    The following functions are available in this class:
</p>
<h2>$this->load->library('
    <var>
        class_name
    </var>')
</h2>
<p>
    This function is used to load core classes.  Where 
    <var>
        class_name
    </var>
    is the name of the class you want to load.
    Note: We use the terms "class" and "library" interchangeably.
</p>
<p>
    For example, if you would like to send email with F-engine, the first step is to load the email class within your controller:
</p>
<code>
    $this->load->library('email');
</code>
<p>
    Once loaded, the library will be ready for use, using 
    <kbd>
        $this->email->
    </kbd>
    <samp>
        <em>some_function</em>()
    </samp>.
    <p>
        Library files can be stored in subdirectories within the main "libraries" folder, or within your personal 
        <dfn>
            application/libraries
        </dfn>
        folder. 
        To load a file located in a subdirectory, simply include the path, relative to the "libraries" folder. 
        For example, if you have file located at:
    </p>
    <code>
        libraries/flavors/chocolate.php
    </code>
    <p>
        You will load it using:
    </p>
    <code>
        $this->load->library('flavors/chocolate');
    </code>
    <p>
        You may nest the file in as many subdirectories as you want.
    </p>
    <h3>Setting options</h3>
    <p>
        The second parameter allows you to optionally pass configuration setting.  You will typically pass these as an array:
    </p>
    <code>
        $config = array (
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'mailtype' => 'html',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'charset'&nbsp; => 'utf-8,
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'priority' => '1'
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
        <br/>
        <br/>
        $this->load->library('email', $config);
    </code>
    <p>
        Config options can usually also be set via a config file. Each library is explained in detail in its own page, so please read the information regarding each one you would like to use.
    </p>
    <h3>Assigning a Library to a different object name</h3>
    <p>
        If the third parameter is blank, the library will usually be assigned to an object with the same name as the library.  For example, if the library is named 
        <dfn>
            Session
        </dfn>, it 
        will be assigned to a variable named 
        <dfn>
            $this->session
        </dfn>.
    </p>
    <p>
        If you prefer to set your own class names you can pass its value to the third parameter:
    </p>
    <code>
        $this->load->library('session', '', 'my_session');
        <br/>
        <br/>
        // Session class is now accessed using:
        <br/>
        <br/>
        $this->my_session
    </code>
    <h2>$this->load->view('
        <var>
            file_name
        </var>', 
        <samp>
            $data
        </samp>, 
        <kbd>
            true/false
        </kbd>)
    </h2>
    <p>
        This function is used to load your View files.  If you haven't read the <a href="<?php echo site_url();?>userguide/general/views">Views</a>
        section of the
        user guide it is recommended that you do since it shows you how this function is typically used.
    </p>
    <p>
        The first parameter is required.  It is the name of the view file you would like to load. &nbsp;Note: The .php file extension does not need to be specified unless you use something other then 
        <kbd>
            .php
        </kbd>.
    </p>
    <p>
        The second <strong>optional</strong>
        parameter can take 
        an associative array or an object as input, which it runs through the PHP <a href="http://www.php.net/extract">extract</a>
        function to 
        convert to variables that can be used in your view files.  Again, read the <a href="<?php echo site_url();?>userguide/general/views">Views</a>
        page to learn
        how this might be useful.
    </p>
    <p>
        The third <strong>optional</strong>
        parameter lets you change the behavior of the function so that it returns data as a string
        rather than sending it to your browser.  This can be useful if you want to process the data in some way.  If you 
        set the parameter to 
        <kbd>
            true
        </kbd>
        (boolean) it will return data.  The default behavior is 
        <kbd>
            false
        </kbd>, which sends it
        to your browser.  Remember to assign it to a variable if you want the data returned:
    </p>
    <code>
        $string = $this->load->view('
        <var>
            myfile
        </var>', '', 
        <kbd>
            true
        </kbd>);
    </code>
    <h2>$this-&gt;load-&gt;model('
        <var>
            Model_name
        </var>');
    </h2>
    <p>
        <code>
            $this-&gt;load-&gt;model('
            <var>
                Model_name
            </var>');
        </code>
    </p>
    <p>
        If your model is located in a sub-folder, include the relative path from your models folder. For example, if you have a model located at application/models/blog/queries.php you'll load it using:
    </p>
    <p>
        <code>
            $this-&gt;load-&gt;model('
            <var>
                blog/queries
            </var>');
        </code>
    </p>
    <p>
        If you would like your model assigned to a different object name you can specify it via the second parameter of the loading
        function:
    </p>
    <code>
        $this-&gt;load-&gt;model('
        <var>
            Model_name
        </var>', '
        <kbd>
            fubar
        </kbd>');
        <br/>
        <br/>
        $this-&gt;
        <kbd>
            fubar
        </kbd>-&gt;function();
    </code>
    <h2>$this->load->database('
        <var>
            options
        </var>', 
        <kbd>
            true/false
        </kbd>)
    </h2>
    <p>
        This function lets you load the database class.  The two parameters are <strong>optional</strong>.  Please see the <a href="<?php echo site_url();?>userguide/database/examples">database</a>
        section for more info.
    </p>
    <h2>$this->load->scaffolding('
        <var>
            table_name
        </var>')
    </h2>
    <!--<p>
        This function lets you enable scaffolding.  Please see the<a href="<?php echo site_url();?>userguide/general/scaffolding">scaffolding</a>
        section for more info.
    </p>-->
    <h2>$this->load->vars(
        <samp>
            $array
        </samp>)
    </h2>
    <p>
        This function takes an associative array as input and generates variables using the PHP <a href="http://www.php.net/extract">extract</a>
        function. 
        This function produces the same result as using the second parameter of the 
        <dfn>
            $this->load->view()
        </dfn>
        function above.  The reason you might
        want to use this function independently is if you would like to set some global variables in the constructor of your controller
        and have them become available in any view file loaded from any function.  You can have multiple calls to this function.  The data get cached
        and merged into one array for conversion to variables.
    </p>
    <h2>$this->load->helper('
        <var>
            file_name
        </var>')
    </h2>
    <p>
        This function loads helper files, where 
        <var>
            file_name
        </var>
        is the name of the file, without the 
        <kbd>
            _helper.php
        </kbd>
        extension.
    </p>
    <h2>$this->load->plugin('
        <var>
            file_name
        </var>')
    </h2>
    <p>
        This function loads plugins files, where 
        <var>
            file_name
        </var>
        is the name of the file, without the 
        <kbd>
            _plugin.php
        </kbd>
        extension.
    </p>
    <h2>$this->load->file('
        <var>
            filepath/filename
        </var>', 
        <kbd>
            true/false
        </kbd>)
    </h2>
    <p>
        This is a generic file loading function.  Supply the filepath and name in the first parameter and it will open and read the file. 
        By default the data is sent to your browser, just like a View file, but if you set the second parameter to 
        <kbd>
            true
        </kbd>
        (boolean)
        it will instead return the data as a string.
    </p>
    <h2>$this->load->lang('
        <var>
            file_name
        </var>')
    </h2>
    <p>
        This function is an alias of the <a href="<?php echo site_url();?>userguide/libraries/language">language loading function</a>: $this->lang->load()
    </p>
    <h2>$this->load->config('
        <var>
            file_name
        </var>')
    </h2>
    <p>
        This function is an alias of the <a href="<?php echo site_url();?>userguide/libraries/config">config file loading function</a>: $this->config->load()
    </p>
