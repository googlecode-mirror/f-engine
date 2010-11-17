<h1>Ajax Class</h1>
<p>
    Ajax is a static class that provides a collection of helper methods for creating ajax calls without the need 
    of typing a single javascript line.
</p>
<h2>Initializing the Ajax Class</h2>

<p>To initialize the Ajax Class in your controller constructor, use the the following code:</p>
    
	<code>
	    $this->load->ajax();
	</code>

<h1>Function Reference</h1>
<br />
<h2>$this-&gt;ajax-&gt;link();</h2>

<p>Creates a html anchor that triggers an ajax request when is clicked and updates selected page area with returned content.</p>
<p>
	<code>
	    $this-&gt;ajax-&gt;link($anchorText, $targetUrl, $updateArea);
	</code>
</p>
<h3>Example:</h3>
<code>
&lt;p&gt;&lt;?php echo $this->ajax->link("ajax link","ajax/link","#target"); ?&gt;.&lt;/p&gt;<br />
&lt;div id="target"&gt;&lt;/div&gt;
</code>

<h2>$this-&gt;ajax-&gt;submitButton();</h2>

<p>Creates ajax form submit button. It is able to show any server response, validation response for example, 
and redirect your page to selected url once the job is done.
</p>
<p>
	<code>
	    $this-&gt;ajax-&gt;link($buttonText,$updateArea,$redirectUrl);
	</code>
</p>
<h3>Example:</h3>
<code>
&lt;form method="post" action="&lt;?php echo current_url();?&gt;"><br />
&nbsp;&nbsp;&lt;label for="some_text">Some text</label> <br />
&nbsp;&nbsp;&lt;input type="text" id="some_text" name="some_text" value="06:55:49"><br />
&nbsp;&nbsp;&lt;?php echo $this->ajax->submitButton("send","#req_resp"); ?&gt;<br />
&lt;/form><br />
&lt;div id="req_resp"&gt;&lt;/div&gt;
</code>

<h2>$this-&gt;ajax-&gt;element();</h2>

<p>Triggers an ajax request and updates selected page area with returned content. This ajax method is 
compatible with any existing html element in webpage and any jQuery compatible javascript event.</p>
<p>
	<code>
	    $this-&gt;ajax-&gt;element($cssSelectorToElement,$event, $requesturl, $updateArea);
	</code>
</p>
<h3>Examples:</h3>
<code>
	&lt;select style="width: 95px;" id="country"&gt;<br />
	&nbsp;&nbsp;&lt;option value="spain">Spain&lt;/option&gt;<br />
	&nbsp;&nbsp;&lt;option value="germany">Germany&lt;/option&gt;<br />
	&nbsp;&nbsp;&lt;option value="france">France&lt;/option&gt;<br />
	&lt;/select&gt;<br />
	&lt;?php $this->ajax->element('#country','change',current_url(),'#resp'); ?&gt;<br />
	&lt;div id="resp"&gt;&lt;/div&gt;
</code>

<code>
	&lt;input type="text" value="" id="nickname" name="nickname" /&gt;<br />
	&lt;div id="checkNickname">&lt;/div&gt;<br />
	&lt;?php $this->ajax->element('#nickname','blur',site_url(),'#checkNickname'); ?&gt;
</code>

<code>
	&lt;img src="http://www.google.com/images/nav_logo22.png" /&gt;<br />
	&lt;?php $this->ajax->element('img','click',site_url(),'#response'); ?&gt;<br />
	&lt;div id="response">&lt;/div&gt;<br />
</code>

<h2>$this-&gt;ajax-&gt;timer();</h2>

<p>Triggers an ajax request every <i>n</i> miliseconds and updates selected page area with returned content.</p>
<p>
	<code>
	    $this-&gt;ajax-&gt;timer($miliSeconds,$targetUrl,$updateArea);
	</code>
</p>
<h3>Example:</h3>
<code>
&lt;div id="timerReqHandler"&gt;&lt;/div&gt;<br />
&lt;?php $this->ajax->timer(3000,"ajax/timer",'#timerReqHandler');?&gt;
</code>

<h2>$this-&gt;ajax-&gt;clearTimer();</h2>

<p>Removes timer event added with timer() method.</p>
<p>
	<code>
	    $this-&gt;ajax-&gt;clearTimer($updatedArea);
	</code>
</p>
<h3>Example:</h3>
<code>
$this->ajax->clearTimer('#timerReqHandler');
</code>

<h2>$this-&gt;ajax-&gt;autocomplete();</h2>

<p>Removes timer event added with timer() method.</p>
<h3>Example:</h3>
<strong>View:</strong><br />
<code>
&lt;input type="text" name="languages" id="programing_languages" /&gt;<br />
&lt;?php $this->ajax->autocomplete('#programing_languages','ajax/languages');?&gt;
</code><br />
<strong>Controller:</strong>
<code style="white-space:pre;">$items = array(
	"ActionScript",
	"AppleScript",
	"Asp",
	"BASIC",
	"C",
	"C++",
	"Clojure",
	"COBOL",
	"ColdFusion",
	"Erlang",
	"Fortran",
	"Groovy",
	"Haskell",
	"Java",
	"JavaScript",
	"Lisp",
	"Perl",
	"PHP",
	"Python",
	"Ruby",
	"Scala",
	"Scheme"
);

$data = array("response" => array());
foreach($items as $item) {

	$data['response'][] = array('label'=> $item, 'value'=> $item);
}

echo json_encode($data);
</code>

<h2>$this-&gt;ajax-&gt;datePicker();</h2>

<p>Removes timer event added with timer() method.</p>
<h3>Example:</h3>
<code>
	&lt;input type="text" name="date" id="datepicker" /&gt;<br />
	&lt;?php $this->ajax->datePicker("#datepicker");?&gt;
</code>