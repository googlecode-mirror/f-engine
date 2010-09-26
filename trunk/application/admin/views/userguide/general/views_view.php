<h1>Views</h1>
<p>
    A 
    <dfn>
        view
    </dfn>
    is simply a web page, or a page fragment, like a header, footer, sidebar, etc.
    In fact, views can flexibly be embedded within other views (within other views, etc., etc.) if you need this type
    of hierarchy.
</p>
<p>
    Views are never called directly, they must be loaded by a <a href="<? echo site_url();?>userguide/general/controllers">controller</a>.  
	Remember that in an MVC framework, the Controller acts as the 
    traffic cop, so it is responsible for fetching a particular view. If you have not read the <a href="<? echo site_url();?>userguide/general/controllers">Controllers</a>
    page
    you should do so before continuing.
</p>
<p>
    Using the example controller you created in the <a href="<? echo site_url();?>userguide/general/controllers">controller</a>
    page, let's add a view to it.
</p>
<h2>Creating a View</h2>
<p>
    Using your text editor, create a file called 
    <dfn>
        blog_view.php
    </dfn>, and put this in it:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="10">
    &lt;html>
    &lt;head>
    &lt;title>My Blog&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;h1>Welcome to my Blog!&lt;/h1>
    &lt;/body>
    &lt;/html>
</textarea>
<p>
    Then save the file in your 
    <dfn>
        application/views/
    </dfn>
    folder.
</p>
<p class="important">
    <strong>Important:</strong>&nbsp; View file name must end in <strong>_view.php</strong> as convention.
</p>
<h2>Loading a View</h2>
<p>
    To load a particular view file you will use the following function:
</p>
<code>
    $this->load->view('
    <var>
        name
    </var>');
</code>
<p>
    Where 
    <var>
        name
    </var>
    is the name of your view file.
</p>
<p>
    Now, open the controller file you made earlier called 
    <dfn>
        blog.php
    </dfn>, and replace the echo statement with the view loading function:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="10">
&lt;?php
class Blog extends Controller {

	function index()
	{
		$this->load->view('blog');
	}
}
?>
</textarea>
<p>
    If you visit the your site using the URL you did earlier you should see your new view.  The URL was similar to this:
</p>
<code>
    example.com/index.php/
    <var>
        blog
    </var>/
</code>
<h2>Loading multiple views</h2>
<p>
    F-engine will intelligently handle  multiple calls to $this-&gt;load-&gt;view from within a controller.  If more then one call happens they will be appended together. For example, you may wish to have a header view, a menu view, a content view, and a footer view. That might look something like this:
</p>
<p>
    <code>
        &lt;?php
        <br/>
        <br/>
        class Page extends Controller {
        <br/>
        <br/>
        &nbsp;&nbsp;&nbsp;function index()
        <br/>
        &nbsp;&nbsp;&nbsp;{
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data['page_title'] =  'Your title';
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;load-&gt;view('header');
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;load-&gt;view('menu');
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;load-&gt;view('content', $data);
        <br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;load-&gt;view('footer');
        <br/>
        &nbsp;&nbsp;&nbsp;}
        <br/>
        <br/>
        }
        <br/>
        ?&gt;
    </code>
</p>
<p>
    In the example above, we are using &quot;dynamically added data&quot;, which you will see below.
</p>
<h2>Storing Views within Sub-folders</h2>
<p>
    Your view files can also be stored within sub-folders if you prefer that type of organization.  When doing so you will need
    to include the folder name loading the view.  Example:
</p>
<code>
    $this->load->view('
    <kbd>
        folder_name
    </kbd>/
    <var>
        file_name
    </var>');
</code>
<h2>Adding Dynamic Data to the View</h2>
<p>
    Data is passed from the controller to the view by way of an <strong>array</strong>
    or an <strong>object</strong>
    in the second
    parameter of the view loading function. Here is an example using an array:
</p>
<code>
    $data = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'title' => 'My Title',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'heading' => 'My Heading',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'message' => 'My Message'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    $this->load->view('blog', 
    <var>
        $data
    </var>);
</code>
<p>
    And here's an example using an object:
</p>
<code>
    $data = new Someclass();
    <br/>
    $this->load->view('blog', 
    <var>
        $data
    </var>);
</code>
<p>
    Note: If you use an object, the class variables will be turned into array elements.
</p>
<p>
    Let's try it with your controller file.  Open it add this code:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="14">
    &lt;?php
    class Blog extends Controller {
    function index()
    {
    $data['title'] = "My Real Title";
    $data['heading'] = "My Real Heading";
    $this->load->view('blog', $data);
    }
    }
    ?&gt;
</textarea>
<p>
    Now open your view file and change the text to variables that correspond to the array keys in your data:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="10">
    &lt;html>
    &lt;head>
    &lt;title>&lt;?php echo $title;?>&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;h1>&lt;?php echo $heading;?>&lt;/h1>
    &lt;/body>
    &lt;/html>
</textarea>
<p>
    Then load the page at the URL you've been using and you should see the variables replaced.
</p>
<h2>Creating Loops</h2>
<p>
    The data array you pass to your view files is not limited to simple variables.  You can
    pass multi dimensional arrays, which can be looped to generate multiple rows.  For example, if you
    pull data from your database it will typically be in the form of a multi-dimensional array.
</p>
<p>
    Here's a simple example. Add this to your controller:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="12">
    &lt;?php
    class Blog extends Controller {
    function index()
    {
    $data['todo_list'] = array('Clean House', 'Call Mom', 'Run Errands');
    $data['title'] = "My Real Title";
    $data['heading'] = "My Real Heading";
    $this->load->view('blog', $data);
    }
    }
    ?&gt;
</textarea>
<p>
    Now open your view file and create a loop:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="15">
    &lt;html>
    &lt;head>
    &lt;title>&lt;?php echo $title;?>&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;h1>&lt;?php echo $heading;?>&lt;/h1>
    &lt;h3>My Todo List&lt;/h3> 
    &lt;ul>
    &lt;?php foreach($todo_list as $item):?>
    &lt;li>&lt;?php echo $item;?>&lt;/li>
    &lt;?php endforeach;?>
    &lt;/ul>
    &lt;/body>
    &lt;/html>
</textarea>
<p>
    <strong>Note:</strong>
    You'll notice that in the example above we are using PHP's alternative syntax.  If you 
    are not familiar with it you can read about it <a href="<? echo site_url();?>userguide/general/alternative_php">here</a>.
</p>
<h2>Master views: Avoiding recurrent data</h2>
<p>
	There is an alternative way to load a view by calling <strong>masterview()</strong> function. 
	The point of this function is to avoid sending recurrent data such as css files, javascripts, headers, footers, etc to the views.
	Recurrent data will be automatically loaded from <strong>masterview.php</strong> file located in <strong>config</strong> directory where you can define any var by way of associative array.
</p>
<p> Here is an example:</p>

<textarea rows="12" cols="50" style="width: 100%;" class="textarea">
$conf['default'] =  array (
		'js'  			=>	array (),
		'css' 			=>	array ("default.css"),
		'header'		=>	'header/default',
		'footer'		=>	'footer/default',
		'title'			=>	'Powered by f-engine',
		'lang'			=>	'es_ES',
		'description'	=>	'Lorem ipsum dolor sit amet',
		'keywords'		=>	'Lorem, ipsum, dolor, sit, amet',
	);
	
$conf['feedback'] =  array (
		'js'  			=>	array ("feedback.js"),
		'css' 			=>	array ("default.css","feedback.js"),
		'header'		=>	'header/feedback',
		'footer'		=>	'footer/default',
		'title'			=>	'Powered by f-engine',
		'lang'			=>	'es_ES',
		'description'	=>	'Lorem ipsum dolor sit amet',
		'keywords'		=>	'Lorem, ipsum, dolor, sit, amet',
	);
</textarea>

<p>Assuming that content view to load is named "welcome_view.php", you could load the page, headers and css files included, this way:</p>
<code>
    $data = array(
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'title' =&gt; 'My Title',
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'message' =&gt; 'My Message'
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br>
    <br>
    $this-&gt;load-&gt;masterview(
    <kbd>
        'welcome'
    </kbd>,
    <dfn>$data</dfn>,'default');
</code>
<p>
The last parameter is optional when you are loading default configuration.
</p>
<p>
This method calls <strong>wrapper_view.php</strong> main view first and loads content and assets (headers, footers, content, javascript files, etc) next.
</p>
<p>
All the data defined in masterview.php will be marged with the one sent through the controller, having the last one preference over the data defined inside the config directory. 
</p>
<p>
wrapper_view.php file has some predefined variables ($js,$css,$title,$view,etc), beware conflicts between your application var names and predefined ones.
Fell free to modify this view as desired.
</p>
<h2>Returning views as data</h2>
<p>
    There is a third <strong>optional</strong>
    parameter that lets you change the behavior of the function. With this parameter set to ture, data will be returned as a string rather than sending it to your browser.  
    This can be useful if you want to process the data in some way.  If you 
    set the parameter to 
    <kbd>
        true
    </kbd>
    (boolean) it will return data.  The default behavior is 
    <kbd>
        false
    </kbd>, which sends it
    to your browser.  Remember to assign it to a variable if you want the data returned:
</p>
<code>
    $string = $this->load->view('
    <var>
        myfile
    </var>', '', 
    <kbd>
        true
    </kbd>);
</code>
