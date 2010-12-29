<h1>Quick Queries</h1>
<style>
code, pre {
white-space:pre-line;
}
</style>
<p>F-engines "quick queries" is a set of functions that allows traditional sql sintax abstraction and contributes with some benefit such as
safer queries. This is because the values are escaped automatically by the system.</p> 

<p>Unlike active record database pattern, these functions have no perceptible impact in application performance or memory usage.</p> 


<a name="select">&nbsp;</a>
<h1>Selecting Data</h1>

<p>Retrieve all records from a table</p>
<pre>
$table = 'users';
$fields = '*';
$this->db->f_select(table,$fields);
</pre>

<h2>Where clauses</h2>
<pre>
$table = 'users';
$fields = 'users.idu, users.name ,users.lastname';
$where = array('users.active' => '1', 'name != "admin" ');
$extra = 'order by idu desc';

$this->db->f_select(table,$fields,$where,$extra);
</pre>


<h2>LIKE clauses</h2>

<pre>
$table = 'users';
$fields = 'users.idu, users.name ,users.lastname';
$where = array('users.active' => '1',"users.name like '%m%' ");
$extra = array('order by idu desc','limit 5');

$this->db->f_select(table,$fields,$where,$extra);
</pre>


<h2>Joins</h2>
<pre>
$table = 'users LEFT JOIN comments ON users.idu = comments.iduser';
$fields = 'users.idu, users.name ,users.lastname,comments.*';
$where = array('users.idu' => '1');

$this->db->f_select(table,$fields,$where);
</pre>


<a name="insert">&nbsp;</a>
<h1>Inserting Data</h1>
<pre>
$data = array(
	'name' => $_POST["nombre"],
	'lastname' => $_POST["lastname"]
);

$this-&gt;db-&gt;f_insert('users',$data);
</pre>


<a name="update">&nbsp;</a>
<h1>Updating Data</h1>
<pre>
$data = array(
	'name' => $_POST["nombre"],
	'lastname' => $_POST["lastname"]
);				
$where = array('users.idu' => "1");

$this-&gt;db-&gt;f_update('users',$data,$where);
</pre>

<a name="delete">&nbsp;</a>
<h1>Deleting Data</h1>

<code>
$where = array(
	'users.idu' => "1"
);
//optional:
$limit = 1;
<br>
$this-&gt;db-&gt;f_delete('users',$where,$limit);
<br>
</code>
