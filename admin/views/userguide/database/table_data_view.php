<h1>Table Data</h1>
<p>
    These functions let you fetch table information.
</p>
<h2>$this->db->list_tables();</h2>
<p>
    Returns an array containing the names of all the tables in the database you are currently connected to.  Example:
</p>
<code>
    $tables = $this->db->list_tables();
    <br/>
    <br/>
    foreach ($tables as $table)
    <br/>
    {
    <br/>
    &nbsp;&nbsp; echo $table;
    <br/>
    }
</code>
<h2>$this->db->table_exists();</h2>
<p>
    Sometimes it's helpful to know whether a particular table exists before running an operation on it.
    Returns a boolean TRUE/FALSE.  Usage example:
</p>
<code>
    if ($this->db->table_exists('table_name'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp; // some code...
    <br/>
    }
</code>
<p>
    Note:  Replace <em>table_name</em>
    with the name of the table you are looking for.
</p>
