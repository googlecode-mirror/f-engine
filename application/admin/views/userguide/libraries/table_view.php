<h1>HTML Table Class</h1>
<p>
    The Table Class provides functions that enable you to auto-generate HTML tables from arrays or database result sets.
</p>
<h2>Initializing the Class</h2>
<p>
    Like most other classes in F-engine, the Table class is initialized in your controller using the 
    <dfn>
        $this->load->library
    </dfn>
    function:
</p>
<code>
    $this->load->library('table');
</code>
<p>
    Once loaded, the Table library object will be available using: 
    <dfn>
        $this->table
    </dfn>
</p>
<h2>Examples</h2>
<p>
    Here is an example showing how you can create a table from a multi-dimensional array.
    Note that the first array index will become the table heading (or you can set your own headings using the
    <dfn>
        set_heading()
    </dfn>
    function described in the function reference below).
</p>
<code>
    $this->load->library('table');
    <br/>
    <br/>
    $data = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array('Name', 'Color', 'Size'),
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array('Fred', 'Blue', 'Small'),
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array('Mary', 'Red', 'Large'),
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array('John', 'Green', 'Medium') 
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    echo $this->table->generate($data); 
</code>
<p>
    Here is an example of a table created from a database query result. The table class will automatically generate the 
    headings based on the table names (or you can set your own headings using the 
    <dfn>
        set_heading()
    </dfn>
    function described
    in the function reference below).
</p>
<code>
    $this->load->library('table');
    <br/>
    <br/>
    $query = $this->db->query("SELECT * FROM my_table");
    <br/>
    <br/>
    echo $this->table->generate($query); 
</code>
<p>
    Here is an example showing how you might create a table using discrete parameters:
</p>
<code>
    $this->load->library('table');
    <br/>
    <br/>
    $this->table->set_heading('Name', 'Color', 'Size');
    <br/>
    <br/>
    $this->table->add_row('Fred', 'Blue', 'Small');
    <br/>
    $this->table->add_row('Mary', 'Red', 'Large');
    <br/>
    $this->table->add_row('John', 'Green', 'Medium');
    <br/>
    <br/>
    echo $this->table->generate(); 
</code>
<p>
    Here is the same example, except instead of individual parameters, arrays are used:
</p>
<code>
    $this->load->library('table');
    <br/>
    <br/>
    $this->table->set_heading(array('Name', 'Color', 'Size'));
    <br/>
    <br/>
    $this->table->add_row(array('Fred', 'Blue', 'Small'));
    <br/>
    $this->table->add_row(array('Mary', 'Red', 'Large'));
    <br/>
    $this->table->add_row(array('John', 'Green', 'Medium'));
    <br/>
    <br/>
    echo $this->table->generate(); 
</code>
<h2>Changing the Look of Your Table</h2>
<p>
    The Table Class permits you to set a table template with which you can specify the design of your layout.  Here is the template
    prototype:
</p>
<code>
    $tmpl =  array (
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'table_open'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;table border="0" cellpadding="4" cellspacing="0">',
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'heading_row_start'&nbsp;&nbsp;&nbsp;=> '&lt;tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'heading_row_end'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'heading_cell_start'&nbsp;&nbsp;=> '&lt;th>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'heading_cell_end'&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/th>',
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'row_start'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'row_end'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'cell_start'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;td>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'cell_end'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/td>',
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'row_alt_start'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'row_alt_end'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/tr>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'cell_alt_start'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;td>',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'cell_alt_end'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/td>',
    <br/>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'table_close'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> '&lt;/table>'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    $this->table->set_template($tmpl);
</code>
<p class="important">
    <strong>Note:</strong>&nbsp; You'll notice there are two sets of "row" blocks in the template.  These permit you to create alternating row colors or design elements that alternate with each
    iteration of the row data.
</p>
<p>
    You are NOT required to submit a complete template.  If you only need to change parts of the layout you can simply submit those elements.
    In this example, only the table opening tag is being changed:
</p>
<code>
    $tmpl =  array ( 'table_open'&nbsp;&nbsp;=> '&lt;table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    <br/>
    <br/>
    $this->table->set_template($tmpl);
</code>
<br/>
<h1>Function Reference</h1>
<h2>$this->table->generate()</h2>
<p>
    Returns a string containing the generated table.  Accepts an optional parameter which can be an array or a database result object.
</p>
<h2>$this->table->set_caption()</h2>
<p>
    Permits you to add a caption to the table.
</p>
<code>
    $this->table->set_caption('Colors');
</code>
<h2>$this->table->set_heading()</h2>
<p>
    Permits you to set the table heading.  You can submit an array or discrete params:
</p>
<code>
    $this->table->set_heading('Name', 'Color', 'Size');
</code>
<code>
    $this->table->set_heading(array('Name', 'Color', 'Size'));
</code>
<h2>$this->table->add_row()</h2>
<p>
    Permits you to add a row to your table.  You can submit an array or discrete params:
</p>
<code>
    $this->table->add_row('Blue', 'Red', 'Green');
</code>
<code>
    $this->table->add_row(array('Blue', 'Red', 'Green'));
</code>
<h2>$this->table->make_columns()</h2>
<p>
    This function takes a one-dimensional array as input and creates
    a multi-dimensional array with a depth equal to the number of
    columns desired.  This allows a single array with many elements to  be
    displayed in a table that has a fixed column count.  Consider this example:
</p>
<code>
    $list = array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve');
    <br/>
    <br/>
    $new_list = $this->table->make_columns($list, 3);
    <br/>
    <br/>
    $this->table->generate($new_list);
    <br/>
    <br/>
    // Generates a table with this prototype
    <br/>
    <br/>
    &lt;table border="0" cellpadding="4" cellspacing="0"&gt;
    <br/>
    &lt;tr&gt;
    <br/>
    &lt;td&gt;one&lt;/td&gt;&lt;td&gt;two&lt;/td&gt;&lt;td&gt;three&lt;/td&gt;
    <br/>
    &lt;/tr&gt;&lt;tr&gt;
    <br/>
    &lt;td&gt;four&lt;/td&gt;&lt;td&gt;five&lt;/td&gt;&lt;td&gt;six&lt;/td&gt;
    <br/>
    &lt;/tr&gt;&lt;tr&gt;
    <br/>
    &lt;td&gt;seven&lt;/td&gt;&lt;td&gt;eight&lt;/td&gt;&lt;td&gt;nine&lt;/td&gt;
    <br/>
    &lt;/tr&gt;&lt;tr&gt;
    <br/>
    &lt;td&gt;ten&lt;/td&gt;&lt;td&gt;eleven&lt;/td&gt;&lt;td&gt;twelve&lt;/td&gt;&lt;/tr&gt;
    <br/>
    &lt;/table&gt;
</code>
<h2>$this->table->set_template()</h2>
<p>
    Permits you to set your template. You can submit a full or partial template.
</p>
<code>
    $tmpl =  array ( 'table_open'&nbsp;&nbsp;=> '&lt;table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    <br/>
    <br/>
    $this->table->set_template($tmpl);
</code>
<h2>$this->table->set_empty()</h2>
<p>
    Let's you set a default value for use in any table cells that are empty.  You might, for example, set a non-breaking space:
</p>
<code>
    $this->table->set_empty("&amp;nbsp;");
</code>
<h2>$this->table->clear()</h2>
<p>
    Lets you clear the table heading and row data.  If you need to show multiple tables with different data you should
    to call this function after each table has been generated to empty the previous table information. Example:
</p>
<code>
    $this->load->library('table');
    <br/>
    <br/>
    $this->table->set_heading('Name', 'Color', 'Size');
    <br/>
    $this->table->add_row('Fred', 'Blue', 'Small');
    <br/>
    $this->table->add_row('Mary', 'Red', 'Large');
    <br/>
    $this->table->add_row('John', 'Green', 'Medium');
    <br/>
    <br/>
    echo $this->table->generate();
    <br/>
    <br/>
    <kbd>
        $this->table->clear();
    </kbd>
    <br/>
    <br/>
    $this->table->set_heading('Name', 'Day', 'Delivery');
    <br/>
    $this->table->add_row('Fred', 'Wednesday', 'Express');
    <br/>
    $this->table->add_row('Mary', 'Monday', 'Air');
    <br/>
    $this->table->add_row('John', 'Saturday', 'Overnight');
    <br/>
    <br/>
    echo $this->table->generate();
</code>
