<h1>Config Class</h1>
<p>
    The Config class provides a means to retrieve configuration preferences.  These preferences can
    come from the default config file (
    <samp>
        application/config/config.php
    </samp>) or from your own custom config files.
</p>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<h2>Anatomy of a Config File</h2>
<p>
    By default, F-engine has a one primary config file, located at 
    <samp>
        application/config/config.php
    </samp>.  If you open the file using 
    your text editor you'll see that config items are stored in an array called 
    <var>
        $config
    </var>.
</p>
<p>
    You can add your own config items to
    this file, or if you prefer to keep your configuration items separate (assuming you even need config items), 
    simply create your own file and save it in 
    <dfn>
        config
    </dfn>
    folder.
</p>
<p>
    <strong>Note:</strong>
    If you do create your own config files use the same format as the primary one, storing your items in 
    an array called 
    <var>
        $config
    </var>. F-engine will intelligently manage these files so there will be no conflict even though
    the array has the same name (assuming an array index is not named the same as another).
</p>
<h2>Loading a Config File</h2>
<p>
    <strong>Note:</strong>
    F-engine automatically loads the primary config file (
    <samp>
        application/config/config.php
    </samp>),
    so you will only need to load a config file if you have created your own.
</p>
<p>
    There are two ways to load a config file:
</p>
<ol>
    <li>
        <strong>Manual Loading</strong>
        <p>
            To load one of your custom config files you will use the following function within the <a href="<?php echo site_url();?>userguide/general/controllers">controller</a>
            that needs it:
        </p>
        <code>
            $this->config->load('
            <var>
                filename
            </var>');
        </code>
        <p>
            Where 
            <var>
                filename
            </var>
            is the name of your config file, without the .php file extension.
        </p>
        <p>
            If you need to load multiple config files normally they will be merged into one master config array.  Name collisions can occur, however, if 
            you have identically named array indexes in different config files.  To avoid collisions you can set the second parameter to 
            <kbd>
                TRUE
            </kbd>
            and each config file will be stored in an array index corresponding to the name of the config file. Example:
        </p>
        <code>
            // Stored in an array with this prototype:  $this->config['blog_settings'] = $config
            <br/>
            $this->config->load('
            <var>
                blog_settings
            </var>', 
            <kbd>
                TRUE
            </kbd>);
        </code>
        <p>
            Please see the section entitled 
            <dfn>
                Fetching Config Items
            </dfn>
            below to learn how to retrieve config items set this way.
        </p>
        <p>
            The third parameter allows you to suppress errors in the event that a config file does not exist:
        </p>
        <code>
            $this->config->load('
            <var>
                blog_settings
            </var>', 
            <dfn>
                FALSE
            </dfn>, 
            <kbd>
                TRUE
            </kbd>);
        </code>
    </li>
    <li>
        <strong>Auto-loading</strong>
        <p>
            If you find that you need a particular config file globally, you can have it loaded automatically by the system.  To do this, 
            open the <strong>autoload.php</strong>
            file, located at 
            <samp>
                application/config/autoload.php
            </samp>, and add your config file as
            indicated in the file.
        </p>
    </li>
</ol>
<h2>Fetching Config Items</h2>
<p>
    To retrieve an item from your config file, use the following function:
</p>
<code>
    $this->config->item('
    <var>
        item name
    </var>');
</code>
<p>
    Where 
    <var>
        item name
    </var>
    is the $config array index you want to retrieve. For example, to fetch your language choice you'll do this:
</p>
<code>
    $lang = $this->config->item('language');
</code>
<p>
    The function returns FALSE (boolean) if the item you are trying to fetch does not exist.
</p>
<p>
    If you are using the second parameter of the 
    <kbd>
        $this->config->load
    </kbd>
    function in order to assign your config items to a specific index 
    you can retrieve it by specifying the index name in the second parameter of the 
    <kbd>
        $this->config->item()
    </kbd>
    function.  Example:
</p>
<code>
    // Loads a config file named blog_settings.php and assigns it to an index named "blog_settings"
    <br/>
    $this->config->load('
    <var>
        blog_settings
    </var>', 
    <kbd>
        TRUE
    </kbd>);
    <br/>
    <br/>
    // Retrieve a config item named site_name contained within the blog_settings array
    <br/>
    $site_name = $this->config->item('
    <dfn>
        site_name
    </dfn>', '
    <var>
        blog_settings
    </var>');
    <br/>
    <br/>
    // An alternate way to specify the same item:
    <br/>
    $blog_config = $this->config->item('
    <var>
        blog_settings
    </var>');
    <br/>
    $site_name = $blog_config['site_name'];
</code>
<h2>Setting a Config Item</h2>
<p>
    If you would like to dynamically set a config item or change an existing one, you can so using:
</p>
<code>
    $this->config->set_item('
    <var>
        item_name
    </var>', '
    <var>
        item_value
    </var>');
</code>
<p>
    Where 
    <var>
        item_name
    </var>
    is the $config array index you want to change, and 
    <var>
        item_value
    </var>
    is its value.
</p>
<h2>Helper Functions</h2>
<p>
    The config class has the following helper functions:
</p>
<h2>$this->config->site_url();</h2>
<p>
    This function retrieves the URL to your site, along with the "index" value you've specified in the config file.
</p>
<h2>$this->config->system_url();</h2>
<p>
    This function retrieves the URL to your 
    <dfn>
        system folder
    </dfn>.
</p>
