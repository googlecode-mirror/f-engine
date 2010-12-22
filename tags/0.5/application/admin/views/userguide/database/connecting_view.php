<h1>Connecting to your Database</h1>
<p>
    There are two ways to connect to a database:
</p>
<h2>Automatically Connecting</h2>
<p>
    The "auto connect" feature will load and instantiate the database class with every page load. 
    To enable "auto connecting", add the word 
    <var>
        database
    </var>
    to the library array, as indicated in the following file:
</p>
<p>
    <kbd>
        application/config/autoload.php
    </kbd>
</p>
<h2>Manually Connecting</h2>
<p>
    If only some of your pages require database connectivity you can manually connect to your database by adding this
    line of code in any function where it is needed, or in your class constructor to make the database
    available globally in that class.
</p>
<code>
    $this->load->database();
</code>
<p class="important">
    If the above function does <strong>not</strong>
    contain any information in the first parameter it will connect
    to the group specified in your database config file. For most people, this is the preferred method of use.
</p>
<h3>Available Parameters</h3>
<ol>
    <li>
        The database connection values, passed either as an array or a DSN string.
    </li>
    <li>
        TRUE/FALSE (boolean).  Whether to return the connection ID (see Connecting to Multiple Databases below).
    </li>
    <li>
        TRUE/FALSE (boolean).  Whether to enable the Active Record class.  Set to FALSE by default.
    </li>
</ol>
<h3>Manuallly Connecting to a Database</h3>
<p>
    The first parameter of this function can <strong>optionally</strong>
    be used to specify a particular database group
    from your config file, or you can even submit connection values for a database that is not specified in your config file.
    Examples:
</p>
<p>
    To choose a specific group from your config file you can do this:
</p>
<code>
    $this->load->database('
    <samp>
        group_name
    </samp>');
</code>
<p>
    Where 
    <samp>
        group_name
    </samp>
    is the name of the connection group from your config file.
</p>
<p>
    To connect manually to a desired database you can pass an array of values:
</p>
<code>
    $config['hostname'] = "localhost";
    <br/>
    $config['username'] = "myusername";
    <br/>
    $config['password'] = "mypassword";
    <br/>
    $config['database'] = "mydatabase";
    <br/>
    $config['dbdriver'] = "mysql";
    <br/>
    $config['dbprefix'] = "";
    <br/>
    $config['pconnect'] = FALSE;
    <br/>
    $config['db_debug'] = TRUE;
    <br/>
    $config['cache_on'] = FALSE;
    <br/>
    $config['cachedir'] = "";
    <br/>
    $config['char_set'] = "utf8";
    <br/>
    $config['dbcollat'] = "utf8_general_ci";
    <br/>
    <br/>
    $this->load->database(
    <samp>
        $config
    </samp>);
</code>
<p>
    For information on each of these values please see the <a href="configuration.html">configuration page</a>.
</p>
<p>
    Or you can submit your database values as a Data Source Name. DSNs must have this prototype:
</p>
<code>
    $dsn = 'dbdriver://username:password@hostname/database';
    <br/>
    <br/>
    $this->load->database(
    <samp>
        $dsn
    </samp>);
</code>
<p>
    To override default config values when connecting with a DSN string, add the config variables as a query string.
</p>
<code>
    $dsn = 'dbdriver://username:password@hostname/database?char_set=utf8&amp;dbcollat=utf8_general_ci&amp;cache_on=true&amp;cachedir=/path/to/cache';
    <br/>
    <br/>
    $this->load->database(
    <samp>
        $dsn
    </samp>);
</code>
<h2>Connecting to Multiple Databases</h2>
<p>
    If you need to connect to more than one database simultaneously you can do so as follows:
</p>
<code>
    $DB1 = $this->load->database('group_one', TRUE);
    <br/>
    $DB2 = $this->load->database('group_two', TRUE);
</code>
<p>
    Note: Change the words "group_one" and "group_two" to the specific group names you are connecting to (or
    you can pass the connection values as indicated above).
</p>
<p>
    By setting the second parameter to TRUE (boolean) the function will return the database object.
</p>
<div class="important">
    <p>
        When you connect this way, you will use your object name to issue commands rather than the syntax used throughout this guide.  In other words, rather than issuing commands with:
    </p>
    <p>
        $this->db->query();
        <br/>
        $this->db->result();
        <br/>
        etc...
    </p>
    <p>
        You will instead use:
    </p>
    <p>
        $DB1->query();
        <br/>
        $DB1->result();
        <br/>
        etc...
    </p>
</div>
