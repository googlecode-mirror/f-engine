<h1>Generating Query Results</h1>
<p>
    There are several ways to generate query results:
</p>
<h2>result()</h2>
<p>
    This function returns the query result as an array of <strong>objects</strong>, or <strong>an empty array</strong>
    on failure.
    Typically you'll use this in a foreach loop, like this:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    <br/>
    foreach ($query->result() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->name;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->body;
    <br/>
    }
</code>
<p>
    The above 
    <dfn>
        function
    </dfn>
    is an alias of 
    <dfn>
        result_object()
    </dfn>.
</p>
<p>
    If you run queries that might <strong>not</strong>
    produce a result, you are encouraged to test the result first:
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
<h2>result_array()</h2>
<p>
    This function returns the query result as a pure array, or an empty array when no result is produced.  Typically you'll use this in a foreach loop, like this:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    <br/>
    foreach ($query->result_array() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['title'];
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['name'];
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['body'];
    <br/>
    }
</code>
<h2>row()</h2>
<p>
    This function returns a single result row.  If your query has more than one row, it returns only the first row. 
    The result is returned as an <strong>object</strong>.  Here's a usage example:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    <br/>
    if ($query->num_rows() > 0)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;$row = $query->row();
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->name;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->body;
    <br/>
    }
</code>
<p>
    If you want a specific row returned you can submit the row number as a digit in the first parameter:
</p>
<code>
    $row = $query->row(
    <dfn>
        5
    </dfn>);
</code>
<h2>row_array()</h2>
<p>
    Identical to the above 
    <var>
        row()
    </var>
    function, except it returns an array.  Example:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    <br/>
    if ($query->num_rows() > 0)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;$row = $query->row_array();
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['title'];
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['name'];
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row['body'];
    <br/>
    }
</code>
<p>
    If you want a specific row returned you can submit the row number as a digit in the first parameter:
</p>
<code>
    $row = $query->row_array(
    <dfn>
        5
    </dfn>);
</code>
<p>
    In addition, you can walk forward/backwards/first/last through your results using these variations:
</p>
<p>
    <strong>$row = $query->first_row()</strong>
    <br/>
    <strong>$row = $query->last_row()</strong>
    <br/>
    <strong>$row = $query->next_row()</strong>
    <br/>
    <strong>$row = $query->previous_row()</strong>
</p>
<p>
    By default they return an object unless you put the word "array" in the parameter:
</p>
<p>
    <strong>$row = $query->first_row('array')</strong>
    <br/>
    <strong>$row = $query->last_row('array')</strong>
    <br/>
    <strong>$row = $query->next_row('array')</strong>
    <br/>
    <strong>$row = $query->previous_row('array')</strong>
</p>
<h1>Result Helper Functions</h1>
<h2>$query->num_rows()</h2>
<p>
    The number of rows returned by the query. Note: In this example, 
    <dfn>
        $query
    </dfn>
    is the variable that the query result object is assigned to:
</p>
<code>
    $query = $this->db->query('SELECT * FROM my_table');
    <br/>
    <br/>
    echo $query->num_rows();
</code>
<h2>$query->num_fields()</h2>
<p>
    The number of FIELDS (columns) returned by the query.  Make sure to call the function using your query result object:
</p>
<code>
    $query = $this->db->query('SELECT * FROM my_table');
    <br/>
    <br/>
    echo $query->num_fields();
</code>
<h2>$query->free_result()</h2>
<p>
    It frees the memory associated with the result and deletes the result resource ID.  Normally PHP frees its memory automatically at the end of script
    execution.  However, if you are running a lot of queries in a particular script you might want to free the result after each query result has been
    generated in order to cut down on memory consumptions.  Example:
</p>
<code>
    $query = $this->db->query('SELECT title FROM my_table');
    <br/>
    <br/>
    foreach ($query->result() as $row)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $row->title;
    <br/>
    }
    <br/>
    $query->free_result();  // The $query result object will no longer be available
    <br/>
    <br/>
    $query2 = $this->db->query('SELECT name FROM some_table');
    <br/>
    <br/>
    $row = $query2->row();
    <br/>
    echo $row->name;
    <br/>
    $query2->free_result();  // The $query2 result object will no longer be available
</code>
