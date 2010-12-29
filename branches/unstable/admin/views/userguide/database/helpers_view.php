<h1>Query Helper Functions</h1>
<h2>$this->db->insert_id()</h2>
<p>
    The insert ID number when performing database inserts.
</p>
<h2>$this->db->affected_rows()</h2>
<p>
    Displays the number of affected rows, when doing "write" type queries (insert, update, etc.).
</p>
<p>
    Note:  In MySQL "DELETE FROM TABLE" returns 0 affected rows. The database class has a small hack that allows it to return the
    correct number of affected rows.  By default this hack is enabled but it can be turned off in the database driver file.
</p>
<h2>$this->db->count_all();</h2>
<p>
    Permits you to determine the number of rows in a particular table.  Submit the table name in the first parameter. Example:
</p>
<code>
    echo $this->db->count_all('
    <var>
        my_table
    </var>');
    <br/>
    <br/>
    // Produces an integer, like 25
</code>
<h2>$this->db->platform()</h2>
<p>
    Outputs the database platform you are running (MySQL, MS SQL, Postgres, etc...):
</p>
<code>
    echo $this->db->platform();
</code>
<h2>$this->db->version()</h2>
<p>
    Outputs the database version you are running:
</p>
<code>
    echo $this->db->version();
</code>
<h2>$this->db->last_query();</h2>
<p>
    Returns the last query that was run (the query string, not the result).  Example:
</p>
<code>
    $str = $this->db->last_query();
    <br/>
    <br/>
    // Produces:  SELECT * FROM sometable....
</code>
<p>
    The following two functions help simplify the process of writing database INSERTs and UPDATEs.
</p>
<h2>$this->db->insert_string(); </h2>
<p>
    This function simplifies the process of writing database inserts. It returns a correctly formatted SQL insert string. Example:
</p>
<code>
    $data = array('name' => $name, 'email' => $email, 'url' => $url);
    <br/>
    <br/>
    $str = $this->db->insert_string('table_name', $data);
</code>
<p>
    The first parameter is the table name, the second is an associative array with the data to be inserted.  The above example produces:
</p>
<code>
    INSERT INTO table_name (name, email, url) VALUES ('Rick', 'rick@example.com', 'example.com')
</code>
<p class="important">
    Note: Values are automatically escaped, producing safer queries.
</p>
<h2>$this->db->update_string(); </h2>
<p>
    This function simplifies the process of writing database updates. It returns a correctly formatted SQL update string. Example:
</p>
<code>
    $data = array('name' => $name, 'email' => $email, 'url' => $url);
    <br/>
    <br/>
    $where = "author_id = 1 AND status = 'active'";
    <br/>
    <br/>
    $str = $this->db->update_string('table_name', $data, $where);
</code>
<p>
    The first parameter is the table name, the second is an associative array with the data to be updated, and the third parameter is the "where" clause. The above example produces:
</p>
<code>
    UPDATE table_name SET name = 'Rick', email = 'rick@example.com', url = 'example.com' WHERE author_id = 1 AND status = 'active'
</code>
<p class="important">
    Note: Values are automatically escaped, producing safer queries.
</p>
