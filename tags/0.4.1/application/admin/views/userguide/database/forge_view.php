<h1>Database Forge Class</h1>
<p>
    The Database Forge Class contains functions that help you manage your database.
</p>
<h3>Table of Contents</h3>
<ul>
    <li>
        <a href="#init">Initializing the Forge Class</a>
    </li>
    <li>
        <a href="#create">Creating a Database</a>
    </li>
    <li>
        <a href="#drop">Dropping a Database</a>
    </li>
    <li>
        <a href="#add_field">Adding Fields</a>
    </li>
    <li>
        <a href="#add_key">Adding Keys</a>
    </li>
    <li>
        <a href="#create_table">Creating a Table</a>
    </li>
    <li>
        <a href="#drop_table">Dropping a Table</a>
    </li>
    <li>
        <a href="#rename_table">Renaming a Table</a>
    </li>
    <li>
        <a href="#modifying_tables">Modifying a Table</a>
    </li>
</ul>
<h2><a name="init"></a>Initializing the Forge Class</h2>
<p class="important">
    <strong>Important:</strong>&nbsp; In order to initialize the Forge class, your database driver must
    already be running, since the forge class relies on it.
</p>
<p>
    Load the Forge Class as follows:
</p>
<code>
    $this->load->dbforge()
</code>
<p>
    Once initialized you will access the functions using the 
    <dfn>
        $this->dbforge
    </dfn>
    object:
</p>
<code>
    $this->dbforge->some_function()
</code>
<h2><a name="create"></a>$this->dbforge->create_database('db_name')</h2>
<p>
    Permits you to create the database specified in the first parameter. Returns TRUE/FALSE based on success or failure:
</p>
<code>
    if ($this->dbforge->create_database('my_db'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp; echo 'Database created!';
    <br/>
    }
</code>
<h2><a name="drop"></a>$this->dbforge->drop_database('db_name')</h2>
<p>
    Permits you to drop the database specified in the first parameter. Returns TRUE/FALSE based on success or failure:
</p>
<code>
    if ($this->dbforge->drop_database('my_db'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp; echo 'Database deleted!';
    <br/>
    }
</code>
<h1>Creating and Dropping Tables</h1>
<p>
    There are several things you may wish to do when creating tables. Add fields, add keys to the table, alter columns. F-engine provides a mechanism for this.
</p>
<h2><a name="add_field" id="add_field"></a>Adding fields</h2>
<p>
    Fields are created via an associative array. Within the array you must include a 'type' key that relates to the datatype of the field. For example, INT, VARCHAR, TEXT, etc. Many datatypes (for example VARCHAR) also require a 'constraint' key.
</p>
<p>
    <code>
        $fields = array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'users' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt; 'VARCHAR',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'constraint' =&gt; '100',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
        <br/>
        <br/>
        // will translate to &quot;users VARCHAR(100)&quot; when the field is added.
    </code>
</p>
<p>
    Additionally, the following key/values can be used:
</p>
<ul>
    <li>
        unsigned/true : to generate &quot;UNSIGNED&quot; in the field definition.
    </li>
    <li>
        default/value : to generate a default value in the field definition.
    </li>
    <li>
        null/true : to generate &quot;NULL&quot; in the field definition. Without this, the field will default to &quot;NOT NULL&quot;.
    </li>
    <li>
        auto_increment/true : generates an auto_increment flag on the field. Note that the field type must be a type that supports this, such as integer.
    </li>
</ul>
<p>
    <code>
        $fields = array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'blog_id' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt; 'INT',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'constraint' =&gt; 5, 
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'unsigned' =&gt; TRUE,
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'auto_increment' =&gt; TRUE
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'blog_title' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt; 'VARCHAR',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'constraint' =&gt; '100',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'blog_author' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt;'VARCHAR',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'constraint' =&gt; '100',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'default' =&gt; 'King of Town',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'blog_description' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt; 'TEXT',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'null' =&gt; TRUE,
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
        <br/>
    </code>
</p>
<p>
    After the fields have been defined, they can  be added  using 
    <dfn>
        $this-&gt;dbforge-&gt;add_field($fields);
    </dfn>
    followed by a call to the 
    <dfn>
        create_table()
    </dfn>
    function.
</p>
<h3>$this-&gt;dbforge-&gt;add_field()</h3>
<p>
    The add fields function will accept the above array.
</p>
<h3>Passing strings as fields</h3>
<p>
    If you know exactly how you want a field to be created, you can pass the string into the field definitions with add_field()
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;add_field(&quot;label varchar(100) NOT NULL DEFAULT 'default label'&quot;);
    </code>
</p>
<p class="important">
    Note: Multiple calls to 
    <dfn>
        add_field()
    </dfn>
    are cumulative.
</p>
<h3>Creating an id field</h3>
<p>
    There is a special exception for creating id fields. A field with type id will automatically be assinged as an INT(9) auto_incrementing Primary Key.
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;add_field('id');
        <br/>
        // gives id INT(9) NOT NULL AUTO_INCREMENT
    </code>
</p>
<h2><a name="add_key" id="add_key"></a>Adding Keys</h2>
<p>
    Generally speaking, you'll want your table to have Keys. This is accomplished with 
    <dfn>
        $this-&gt;dbforge-&gt;add_key('field')
    </dfn>. An optional second parameter set to TRUE will make it a primary key. Note that 
    <dfn>
        add_key()
    </dfn>
    must be followed by a call to 
    <dfn>
        create_table()
    </dfn>.
</p>
<p>
    Multiple column non-primary keys must be sent as an array.  Sample output below is for MySQL.
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;add_key('blog_id', TRUE);
        <br/>
        // gives PRIMARY KEY `blog_id` (`blog_id`)
        <br/>
        <br/>
        $this-&gt;dbforge-&gt;add_key('blog_id', TRUE);
        <br/>
        $this-&gt;dbforge-&gt;add_key('site_id', TRUE);
        <br/>
        // gives PRIMARY KEY `blog_id_site_id` (`blog_id`, `site_id`)
        <br/>
        <br/>
        $this-&gt;dbforge-&gt;add_key('blog_name');
        <br/>
        // gives KEY `blog_name` (`blog_name`)
        <br/>
        <br/>
        $this-&gt;dbforge-&gt;add_key(array('blog_name', 'blog_label'));
        <br/>
        // gives KEY `blog_name_blog_label` (`blog_name`, `blog_label`)
    </code>
</p>
<h2><a name="create_table" id="create_table"></a>Creating a table</h2>
<p>
    After fields and keys have been declared, you can create a new table with
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;create_table('table_name');
        <br/>
        // gives CREATE TABLE table_name
    </code>
</p>
<p>
    An optional second parameter set to TRUE adds an &quot;IF NOT EXISTS&quot; clause into the definition
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;create_table('table_name', TRUE);
        <br/>
        // gives CREATE TABLE IF NOT EXISTS table_name
    </code>
</p>
<h2><a name="drop_table" id="drop_table"></a>Dropping a table</h2>
<p>
    Executes a DROP TABLE sql
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;drop_table('table_name');
        <br/>
        // gives DROP TABLE IF EXISTS  table_name
    </code>
</p>
<h2><a name="rename_table" id="rename_table"></a>Renaming a table</h2>
<p>
    Executes a TABLE rename
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;rename_table('old_table_name', 'new_table_name');
        <br/>
        // gives ALTER TABLE old_table_name RENAME TO new_table_name
    </code>
</p>
<h1><a name="modifying_tables" id="modifying_tables"></a>Modifying Tables</h1>
<h2>$this-&gt;dbforge-&gt;add_column()</h2>
<p>
    The add_column() function is used to modify an existing table. It accepts the same field array as above, and can be used for an unlimited number of additional fields.
</p>
<p>
    <code>
        $fields = array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'preferences' =&gt; array('type' =&gt; 'TEXT')
        <br/>
        );
        <br/>
        $this-&gt;dbforge-&gt;add_column('table_name', $fields);
        <br/>
        <br/>
        // gives ALTER TABLE table_name ADD   	preferences TEXT
    </code>
</p>
<h2>$this-&gt;dbforge-&gt;drop_column()</h2>
<p>
    Used to remove a column from a table. 
</p>
<p>
    <code>
        $this-&gt;dbforge-&gt;drop_column('table_name', 'column_to_drop');
    </code>
</p>
<h2>$this-&gt;dbforge-&gt;modify_column()</h2>
<p>
    The usage of this function is identical to add_column(), except it alters an existing column rather than adding a new one. In order to use it you must add a &quot;name&quot; key into the field defining array.
</p>
<p>
    <code>
        $fields = array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'old_name' =&gt; array(
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'name' =&gt; 'new_name',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'type' =&gt; 'TEXT',
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
        <br/>
        );
        <br/>
        $this-&gt;dbforge-&gt;modify_column('table_name', $fields);
        <br/>
        <br/>
        // gives ALTER TABLE table_name CHANGE   	old_name new_name TEXT 
    </code>
</p>
<p>
    &nbsp;
</p>
