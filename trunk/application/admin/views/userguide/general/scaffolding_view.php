<h1>Scaffolding</h1>

<p>CodeIgniter's Scaffolding feature provides a fast and very convenient way to add, edit, or delete information in your database
during development.</p>

<p class="important"><strong>Very Important:</strong>  Scaffolding is intended for development use only.  It provides very little
security other than a "secret" word, so anyone who has access to your CodeIgniter site can potentially edit or delete your information.
If you use scaffolding make sure you disable it immediately after you are through using it.  DO NOT leave it enabled on a live site.
And please, set a secret word before you use it.</p>


<h2>Why would someone use scaffolding?</h2>

<p>Here's a typical scenario:  You create a new database table during development and you'd like a quick way to insert some data
into it to work with.  Without scaffolding your choices are either to write some inserts using the command line or to use a
database management tool like phpMyAdmin.  With CodeIgniter's scaffolding feature you can quickly add some data using its browser
interface.  And when you are through using the data you can easily delete it.</p>

<h2>Setting a Secret Word</h2>

<p>Before enabling scaffolding please take a moment to set a secret word.  This word, when encountered in your URL,
will launch the scaffolding interface, so please pick something obscure that no one is likely to guess.</p>

<p>To set a secret word, open your <kbd>application/config/routes.php</kbd> file and look for this item:</p>

<code>$route['scaffolding_trigger'] = '';</code>

<p>Once you've found it add your own unique word.</p>

<p class="important"><strong>Note:</strong> The scaffolding word can <strong>not</strong> start with an underscore.</p>


<h2>Enabling Scaffolding</h2>

<p>Note: The information on this page assumes you already know how 
<a href="<? echo site_url();?>userguide/general/controllers">controllers</a> work, and that you have
a working one available.  It also assumes you have configured CodeIgniter to auto-connect to your 
<a href="<? echo site_url();?>userguide/database/index">database</a>.
If not, the information here won't be very relevant, so you are encouraged to go through those sections first.
Lastly, it assumes you understand what a class constructor is.  If not, read the last section of the 
<a href="<? echo site_url();?>userguide/general/controllers">controllers</a>
page.</p>

<p>To enable scaffolding you will initialize it in your constructor like this:</p>

<code>
&lt;?php<br />
class Blog extends Controller {<br />
<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;function Blog()<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::Controller();<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<samp>$this->load->scaffolding(</samp><kbd>'table_name'</kbd>);<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}<br />
?&gt;</code>

<p>Where <kbd>table_name</kbd> is the name of the table (table, not database) you wish to work with.</p>

<p>Once you've initialized scaffolding, you will access it with this URL prototype:</p>

<code>example.com/index.php/<var>class</var>/<dfn>secret_word</dfn>/</code>

<p>For example, using a controller named <var>Blog</var>, and <dfn>abracadabra</dfn> as the secret word,
you would access scaffolding like this:</p>

<code>example.com/index.php/<var>blog</var>/<dfn>abracadabra</dfn>/</code>

<p>The scaffolding interface should be self-explanatory.  You can add, edit or delete records.</p>


<h2>A Final Note:</h2>

<p>The scaffolding feature will only work with tables that contain a primary key, as this is information is needed to perform the various
database functions.</p>