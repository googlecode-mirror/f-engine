<h1>Custom Function Calls</h1>
<h2>$this->db->call_function();</h2>
<p>
    This function enables you to call PHP database functions that are not natively included in F-engine, in a platform independent manner. 
    For example, lets say you want to call the 
    <dfn>
        mysql_get_client_info()
    </dfn>
    function, which is <strong>not</strong>
    natively supported
    by F-engine.  You could do so like this:
</p>
<code>
    $this->db->call_function('
    <var>
        get_client_info
    </var>');
</code>
<p>
    You must supply the name of the function, <strong>without</strong>
    the 
    <var>
        mysql_
    </var>
    prefix, in the first parameter.  The prefix is added
    automatically based on which database driver is currently being used.  This permits you to run the same function on different database platforms.
    Obviously not all function calls are identical between platforms, so there are limits to how useful this function can be in terms of portability.
</p>
<p>
    Any parameters needed by the function you are calling will be added to the second parameter.
</p>
<code>
    $this->db->call_function('
    <var>
        some_function
    </var>', $param1, $param2, etc..);
</code>
<p>
    Often, you will either need to supply a database connection ID or a database result ID.  The connection ID can be accessed using:
</p>
<code>
    $this->db->conn_id;
</code>
<p>
    The result ID can be accessed from within your result object, like this:
</p>
<code>
    $query = $this->db->query("SOME QUERY");
    <br/>
    <br/>
    <var>
        $query->result_id;
    </var>
</code>
