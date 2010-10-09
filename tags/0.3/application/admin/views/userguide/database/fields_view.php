<h1>Field Data</h1>
<h2>$this->db->list_fields()</h2>
<p>
    Returns an array containing the field names. This query can be called two ways:
</p>
<p>
    1. You can supply the table name and call it from the 
    <dfn>
        $this->db->
    </dfn>
    object:
</p>
<code>
    $fields = $this->db->list_fields('table_name');
    <br/>
    <br/>
    foreach ($fields as $field)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field;
    <br/>
    }
</code>
<p>
    2. You can gather the field names associated with any query you run by calling the function
    from your query result object:
</p>
<code>
    $query = $this->db->query('SELECT * FROM some_table');
    <br/>
    <br/>
    foreach ($query->list_fields() as $field)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field;
    <br/>
    }
</code>
<h2>$this->db->field_exists()</h2>
<p>
    Sometimes it's helpful to know whether a particular field exists before performing an action.
    Returns a boolean TRUE/FALSE.  Usage example:
</p>
<code>
    if ($this->db->field_exists('field_name', 'table_name'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp; // some code...
    <br/>
    }
</code>
<p>
    Note:  Replace <em>field_name</em>
    with the name of the column you are looking for, and replace<em>table_name</em>
    with the name of the table you are looking for.
</p>
<h2>$this->db->field_data()</h2>
<p>
    Returns an array of objects containing field information.
</p>
<p>
    Sometimes it's helpful to gather the field names or other metadata, like the column type, max length, etc.
</p>
<p class="important">
    Note: Not all databases provide meta-data.
</p>
<p>
    Usage example:
</p>
<code>
    $fields = $this->db->field_data('table_name');
    <br/>
    <br/>
    foreach ($fields as $field)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field->name;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field->type;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field->max_length;
    <br/>
    &nbsp;&nbsp;&nbsp;echo $field->primary_key;
    <br/>
    }
</code>
<p>
    If you have run a query already you can use the result object instead of supplying the table name:
</p>
<code>
    $query = $this->db->query("YOUR QUERY");
    <br/>
    $fields = $query->field_data();
</code>
<p>
    The following data is available from this function if supported by your database:
</p>
<ul>
    <li>
        name - column name
    </li>
    <li>
        max_length - maximum length of the column
    </li>
    <li>
        primary_key - 1 if the column is a primary key
    </li>
    <li>
        type - the type of the column
    </li>
</ul>
