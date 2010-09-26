<h1>Database Quick Start: Example Code</h1>
<p>
    The following page contains example code showing how the database class is used.  For complete details please
    read the individual pages describing each function.
</p>
<h2>Initializing the Database Class</h2>
<p>
    The following code loads and initializes the database class based on your <a href="<? echo site_url();?>userguide/database/configuration">configuration</a>
    settings:
</p>
<code>
    $this->load->database();
</code>
<p>
    Once loaded the class is ready to be used as described below.
</p>
<p>
    Note: If all your pages require database access you can connect automatically.  See the <a href="<? echo site_url();?>userguide/database/connecting">connecting</a>
    page for details.
</p>
<h2>Standard Query With Multiple Results (Object Version)</h2>
<code>
    $query = $this->db->query('SELECT name, title, email FROM my_table');
    <br/>
    <br/>
    foreach ($query->result() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row->name;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row->email;
    <br/>
    }
    <br/>
    <br/>
    echo 'Total Results: ' . $query->num_rows();
</code>
<p>
    The above 
    <dfn>
        result()
    </dfn>
    function returns an array of <strong>objects</strong>.  Example:  $row->title
</p>
<h2>Standard Query With Multiple Results (Array Version)</h2>
<code>
    $query = $this->db->query('SELECT name, title, email FROM my_table');
    <br/>
    <br/>
    foreach ($query->result_array() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row['title'];
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row['name'];
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row['email'];
    <br/>
    }
</code>
<p>
    The above 
    <dfn>
        result_array()
    </dfn>
    function returns an array of standard array indexes.  Example:  $row['title']
</p>
<h2>Testing for Results</h2>
<p>
    If you run queries that might <strong>not</strong>
    produce a result, you are encouraged to test for a result first 
    using the 
    <dfn>
        num_rows()
    </dfn>
    function:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    <br/>
    if ($query->num_rows() > 0)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;foreach ($query->result() as $row)
    <br/>
    &nbsp;&nbsp;&nbsp;{
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $row->name;
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $row->body;
    <br/>
    &nbsp;&nbsp;&nbsp;}
    <br/>
    }
</code>
<h2>Standard Query With Single Result</h2>
<code>
    $query = $this->db->query('SELECT name FROM my_table LIMIT 1');
    <br/>
    <br/>
    $row = $query->row();
    <br/>
    echo $row->name;
    <br/>
</code>
<p>
    The above 
    <dfn>
        row()
    </dfn>
    function returns an <strong>object</strong>.  Example:  $row->name
</p>
<h2>Standard Query With Single Result (Array version)</h2>
<code>
    $query = $this->db->query('SELECT name FROM my_table LIMIT 1');
    <br/>
    <br/>
    $row = $query->row_array();
    <br/>
    echo $row['name'];
    <br/>
</code>
<p>
    The above 
    <dfn>
        row_array()
    </dfn>
    function returns an <strong>array</strong>.  Example:  $row['name']
</p>
<h2>Standard Insert</h2>
<code>
    $sql = "INSERT INTO mytable (title, name) 
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALUES (".$this->db->escape($title).", ".$this->db->escape($name).")";
    <br/>
    <br/>
    $this->db->query($sql);
    <br/>
    <br/>
    echo $this->db->affected_rows();
</code>
<h2>Active Record Query</h2>
<p>
    The <a href="<? echo site_url();?>userguide/database/active_record">Active Record Pattern</a>
    gives you a simplified means of retrieving data:
</p>
<code>
    $query = $this->db->get('table_name');
    <br/>
    <br/>
    foreach ($query->result() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    }
</code>
<p>
    The above 
    <dfn>
        get()
    </dfn>
    function retrieves all the results from the supplied table. 
    The <a href="<? echo site_url();?>userguide/database/active_record">Active Record</a>
    class contains a full compliment of functions
    for working with data.
</p>
<h2>Active Record Insert</h2>
<code>
    $data = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'title' => $title,
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'name' => $name,
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'date' => $date
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    $this->db->insert('mytable', $data);
    <br/>
    <br/>
    // Produces: INSERT INTO mytable (title, name, date) VALUES ('{$title}', '{$name}', '{$date}')
</code>
