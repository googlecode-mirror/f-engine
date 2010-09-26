<h1>Form Validation</h1>
<p>
    Before explaining F-engine's approach to data validation, let's describe the ideal scenario:
</p>
<ol>
    <li>
        A form is displayed.
    </li>
    <li>
        You fill it in and submit it.
    </li>
    <li>
        If you submitted something invalid, or perhaps missed a required item, the form is redisplayed containing your data along with an error message describing the problem.
    </li>
    <li>
        This process continues until you have submitted a valid form.
    </li>
</ol>
<p>
    On the receiving end, the script must:
</p>
<ol>
    <li>
        Check for required data.
    </li>
    <li>
        Verify that the data is of the correct type, and meets the correct criteria. (For example, if a username is submitted
        it must be validated to contain only permitted characters.  It must be of a minimum length,
        and not exceed a maximum length. The username can't be someone else's existing username, or perhaps even a reserved word. Etc.)
    </li>
    <li>
        Sanitize the data for security.
    </li>
    <li>
        Pre-format the data if needed (Does the data need to be trimmed?  HTML encoded?  Etc.)
    </li>
    <li>
        Prep the data for insertion in the database.
    </li>
</ol>
<p>
    Although there is nothing complex about the above process, it usually requires a significant
    amount of code, and to display error messages, various control structures are usually placed within the form HTML.
    Form validation, while simple to create, is generally very messy and tedious to implement.
</p>
<dfn>
    F-engine provides a comprehensive validation framework that truly minimizes the amount of code you'll write.
    It also removes all control structures from your form HTML, permitting it to be clean and free of code.
</dfn>
<h2>Overview</h2>
<p>
    In order to implement F-engine's form validation you'll need three things:
</p>
<ol>
    <li>
        A <a href="../general/views.html">View</a>
        file containing the form.
    </li>
    <li>
        A View file containing a "success" message to be displayed upon successful submission.
    </li>
    <li>
        A <a href="../general/controllers.html">controller</a>
        function to receive and process the submitted data.
    </li>
</ol>
<p>
    Let's create those three things, using a member sign-up form as the example.
</p>
<h2>The Form</h2>
<p>
    Using a text editor, create a form called 
    <dfn>
        myform.php
    </dfn>.  In it, place this code and save it to your 
    <samp>
        applications/views/
    </samp>
    folder:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="30">
    &lt;html>
    &lt;head>
    &lt;title>My Form&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;?php echo $this->validation->error_string; ?>
    &lt;?php echo form_open('form'); ?>
    &lt;h5>Username&lt;/h5>
    &lt;input type="text" name="username" value="" size="50" />
    &lt;h5>Password&lt;/h5>
    &lt;input type="text" name="password" value="" size="50" />
    &lt;h5>Password Confirm&lt;/h5>
    &lt;input type="text" name="passconf" value="" size="50" />
    &lt;h5>Email Address&lt;/h5>
    &lt;input type="text" name="email" value="" size="50" />
    &lt;div>&lt;input type="submit" value="Submit" />&lt;/div>
    &lt;/form>
    &lt;/body>
    &lt;/html>
</textarea>
<h2>The Success Page</h2>
<p>
    Using a text editor, create a form called 
    <dfn>
        formsuccess.php
    </dfn>.  In it, place this code and save it to your 
    <samp>
        applications/views/
    </samp>
    folder:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="14">
    &lt;html>
    &lt;head>
    &lt;title>My Form&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;h3>Your form was successfully submitted!&lt;/h3>
    &lt;p>&lt;?php echo anchor('form', 'Try it again!'); ?>&lt;/p>
    &lt;/body>
    &lt;/html>
</textarea>
<h2>The Controller</h2>
<p>
    Using a text editor, create a controller called 
    <dfn>
        form.php
    </dfn>.  In it, place this code and save it to your 
    <samp>
        applications/controllers/
    </samp>
    folder:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="21">
    &lt;?php
    class Form extends Controller {
    function index()
    {
    $this->load->helper(array('form', 'url'));
    $this->load->library('validation');
    if ($this->validation->run() == FALSE)
    {
    $this->load->view('myform');
    }
    else
    {
    $this->load->view('formsuccess');
    }
    }
    }
    ?>
</textarea>
<h2>Try it!</h2>
<p>
    To try your form, visit your site using a URL similar to this one:
</p>
<code>
    example.com/index.php/
    <var>
        form
    </var>/
</code>
<p>
    <strong>If you submit the form you should simply see the form reload.  That's because you haven't set up any validation
        rules yet, which we'll get to in a moment.</strong>
</p>
<h2>Explanation</h2>
<p>
    You'll notice several things about the above pages:
</p>
<p>
    The 
    <dfn>
        form
    </dfn>
    (myform.php) is a standard web form with a couple exceptions:
</p>
<ol>
    <li>
        It uses a 
        <dfn>
            form helper
        </dfn>
        to create the form opening.
        Technically, this isn't necessary.  You could create the form using standard HTML.  However, the benefit of using the helper
        is that it generates the action URL for you, based on the URL in your config file.  This makes your application more portable
        and flexible in the event your URLs change.
    </li>
    <li>
        At the top of the form you'll notice the following variable:
        <code>
            &lt;?php echo $this->validation->error_string; ?&gt;
        </code>
        <p>
            This variable will display any error messages sent back by the validator. If there are no messages it returns nothing.
        </p>
    </li>
</ol>
<p>
    The 
    <dfn>
        controller
    </dfn>
    (form.php) has one function: 
    <dfn>
        index()
    </dfn>. This function initializes the validation class and 
    loads the 
    <var>
        form helper
    </var>
    and 
    <var>
        URL helper
    </var>
    used by your view files. It also 
    <samp>
        runs
    </samp>
    the validation routine. Based on
    whether the validation was successful it either presents the form or the success page.
</p>
<p>
    <strong>Since you haven't told the validation class to validate anything yet, it returns "false" (boolean false) by default.  The 
        <samp>
            run()
        </samp>
        function only returns "true" if it has successfully applied your rules without any of them failing.
    </strong>
</p>
<h2>Setting Validation Rules</h2>
<p>
    F-engine lets you set as many validation rules as you need for a given field, cascading them in order, and it even lets you prep and pre-process the field data
    at the same time. Let's see it in action, we'll explain it afterwards.
</p>
<p>
    In your 
    <dfn>
        controller
    </dfn>
    (form.php), add this code just below the validation initialization function:
</p>
<code>
    $rules['username']	= "required";
    <br/>
    $rules['password']	= "required";
    <br/>
    $rules['passconf']	= "required";
    <br/>
    $rules['email']		= "required";
    <br/>
    <br/>
    $this->validation->set_rules($rules);
</code>
<p>
    Your controller should now look like this:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="28">
    <?php

class Form extends Controller {
	
	function index()
	{
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('validation');
			
		$rules['username']	= "required";
		$rules['password']	= "required";
		$rules['passconf']	= "required";
		$rules['email']		= "required";
		
		$this->validation->set_rules($rules);
			
		if ($this->validation->run() == FALSE)
		{
			$this->load->view('myform');
		}
		else
		{
			$this->load->view('formsuccess');
		}
	}
}
    ?>
</textarea>
<p>
    <dfn>
        Now submit the form with the fields blank and you should see the error message.
        If you submit the form with all the fields populated you'll see your success page.
    </dfn>
</p>
<p class="important">
    <strong>Note:</strong>
    The form fields are not yet being re-populated with the data when
    there is an error.  We'll get to that shortly, once we're through explaining the validation rules.
</p>
<h2>Changing the Error Delimiters</h2>
<p>
    By default, the system adds a paragraph tag (&lt;p&gt;) around each error message shown. You can easily change these delimiters with
    this code, placed in your controller:
</p>
<code>
    $this->validation->set_error_delimiters('
    <kbd>
        &lt;div class="error">
    </kbd>', '
    <kbd>
        &lt;/div>
    </kbd>');
</code>
<p>
    In this example, we've switched to using div tags.
</p>
<h2>Cascading Rules</h2>
<p>
    F-engine lets you pipe multiple rules together.  Let's try it. Change your rules array like this:
</p>
<code>
    $rules['username']	= "required|min_length[5]|max_length[12]";
    <br/>
    $rules['password']	= "required|matches[passconf]";
    <br/>
    $rules['passconf']	= "required";
    <br/>
    $rules['email']		= "required|valid_email";
</code>
<p>
    The above code requires that:
</p>
<ol>
    <li>
        The username field be no shorter than 5 characters and no longer than 12.
    </li>
    <li>
        The password field must match the password confirmation field.
    </li>
    <li>
        The email field must contain a valid email address.
    </li>
</ol>
<p>
    Give it a try!
</p>
<p class="important">
    <strong>Note:</strong>
    There are numerous rules available which you can read about in the validation reference.
</p>
<h2>Prepping Data</h2>
<p>
    In addition to the validation functions like the ones we used above, you can also prep your data in various ways.
    For example, you can set up rules like this:
</p>
<code>
    $rules['username']	= "
    <kbd>
        trim
    </kbd>|required|min_length[5]|max_length[12]|
    <kbd>
        xss_clean
    </kbd>";
    <br/>
    $rules['password']	= "
    <kbd>
        trim
    </kbd>|required|matches[passconf]|
    <kbd>
        md5
    </kbd>";
    <br/>
    $rules['passconf']	= "
    <kbd>
        trim
    </kbd>|required";
    <br/>
    $rules['email']		= "
    <kbd>
        trim
    </kbd>|required|valid_email";
</code>
<p>
    In the above example, we are "trimming" the fields, converting the password to MD5, and running the username through
    the "xss_clean" function, which removes malicious data.
</p>
<p class="important">
    <strong>Any native PHP function that accepts one parameter can be used as a rule, like 
        <dfn>
            htmlspecialchars
        </dfn>,
        <dfn>
            trim
        </dfn>, 
        <dfn>
            MD5
        </dfn>, etc.
    </strong>
</p>
<p>
    <strong>Note:</strong>
    You will generally want to use the prepping functions <strong>after</strong>
    the validation rules so if there is an error, the original data will be shown in the form.
</p>
<h2>Callbacks: Your own Validation Functions</h2>
<p>
    The validation system supports callbacks to your own validation functions.  This permits you to extend the validation class
    to meet your needs.  For example, if you need to run a database query to see if the user is choosing a unique username, you can
    create a callback function that does that.  Let's create a simple example.
</p>
<p>
    In your controller, change the "username" rule to this:
</p>
<code>
    $rules['username'] = "callback_username_check"; 
</code>
<p>
    Then add a new function called 
    <dfn>
        username_check
    </dfn>
    to your controller.  Here's how your controller should look:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="44">
    <?php

class Form extends Controller {
	
	function index()
	{
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('validation');
			
		$rules['username']	= "callback_username_check";
		$rules['password']	= "required";
		$rules['passconf']	= "required";
		$rules['email']		= "required";
		
		$this->validation->set_rules($rules);
			
		if ($this->validation->run() == FALSE)
		{
			$this->load->view('myform');
		}
		else
		{
			$this->load->view('formsuccess');
		}
	}
	
	function username_check($str)
	{
		if ($str == 'test')
		{
			$this->validation->set_message('username_check', 'The %s field can not be the word "test"');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
}
    ?>
</textarea>
<p>
    Reload your form and submit it with the word "test" as the username.  You can see that the form field data was passed to your
    callback function for you to process.
</p>
<p>
    <strong>To invoke a callback just put the function name in a rule, with "callback_" as the rule prefix.</strong>
</p>
<p>
    The error message was set using the 
    <dfn>
        $this->validation->set_message
    </dfn>
    function.
    Just remember that the message key (the first parameter) must match your function name.
</p>
<p class="important">
    <strong>Note:</strong>
    You can apply your own custom error messages to any rule, just by setting the
    message similarly. For example, to change the message for the "required" rule you will do this:
</p>
<code>
    $this->validation->set_message('required', 'Your custom message here');
</code>
<h2>Re-populating the form</h2>
<p>
    Thus far we have only been dealing with errors.  It's time to repopulate the form field with the submitted data.
    This is done similarly to your rules.  Add the following code to your controller, just below your rules:
</p>
<code>
    $fields['username'] = 'Username';
    <br/>
    $fields['password'] = 'Password';
    <br/>
    $fields['passconf'] = 'Password Confirmation';
    <br/>
    $fields['email'] = 'Email Address';
    <br/>
    <br/>
    $this->validation->set_fields($fields);
</code>
<p>
    The array keys are the actual names of the form fields, the value represents the full name that you want shown in the
    error message.
</p>
<p>
    The index function of your controller should now look like this:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="30">
    function index()
    {
    $this->load->helper(array('form', 'url'));
    $this->load->library('validation');
    $rules['username']	= "required";
    $rules['password']	= "required";
    $rules['passconf']	= "required";
    $rules['email']		= "required";
    $this->validation->set_rules($rules);
    $fields['username']	= 'Username';
    $fields['password']	= 'Password';
    $fields['passconf']	= 'Password Confirmation';
    $fields['email']	= 'Email Address';
    $this->validation->set_fields($fields);
    if ($this->validation->run() == FALSE)
    {
    $this->load->view('myform');
    }
    else
    {
    $this->load->view('formsuccess');
    }
    }
</textarea>
<p>
    Now open your 
    <dfn>
        myform.php
    </dfn>
    view file and update the value in each field so that it has an attribute corresponding to its name:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="30">
    &lt;html>
    &lt;head>
    &lt;title>My Form&lt;/title>
    &lt;/head>
    &lt;body>
    &lt;?php echo $this->validation->error_string; ?>
    &lt;?php echo form_open('form'); ?>
    &lt;h5>Username&lt;/h5>
    &lt;input type="text" name="username" value="&lt;?php echo $this->validation->username;?>" size="50" />
    &lt;h5>Password&lt;/h5>
    &lt;input type="text" name="password" value="&lt;?php echo $this->validation->password;?>" size="50" />
    &lt;h5>Password Confirm&lt;/h5>
    &lt;input type="text" name="passconf" value="&lt;?php echo $this->validation->passconf;?>" size="50" />
    &lt;h5>Email Address&lt;/h5>
    &lt;input type="text" name="email" value="&lt;?php echo $this->validation->email;?>" size="50" />
    &lt;div>&lt;input type="submit" value="Submit" />&lt;/div>
    &lt;/form>
    &lt;/body>
    &lt;/html>
</textarea>
<p>
    Now reload your page and submit the form so that it triggers an error.  Your form fields should be populated
    and the error messages will contain a more relevant field name.
</p>
<h2>Showing Errors Individually</h2>
<p>
    If you prefer to show an error message next to each form field, rather than as a list, you can change your form so that it looks like this:
</p>
<textarea class="textarea" style="width:100%" cols="50" rows="20">
    &lt;h5>Username&lt;/h5>
    &lt;?php echo $this->validation->username_error; ?>
    &lt;input type="text" name="username" value="&lt;?php echo $this->validation->username;?>" size="50" />
    &lt;h5>Password&lt;/h5>
    &lt;?php echo $this->validation->password_error; ?>
    &lt;input type="text" name="password" value="&lt;?php echo $this->validation->password;?>" size="50" />
    &lt;h5>Password Confirm&lt;/h5>
    &lt;?php echo $this->validation->passconf_error; ?>
    &lt;input type="text" name="passconf" value="&lt;?php echo $this->validation->passconf;?>" size="50" />
    &lt;h5>Email Address&lt;/h5>
    &lt;?php echo $this->validation->email_error; ?>
    &lt;input type="text" name="email" value="&lt;?php echo $this->validation->email;?>" size="50" />
</textarea>
<p>
    If there are no errors, nothing will be shown.  If there is an error, the message will appear, wrapped in the delimiters you
    have set (&lt;p> tags by default).
</p>
<p class="important">
    <strong>Note: </strong>To display errors this way you must remember to set your fields using the 
    <kbd>
        $this->validation->set_fields
    </kbd>
    function described earlier. The errors will be turned into variables that have "_error" after your field name.
    For example, your "username" error will be available at:
    <br/>
    <dfn>
        $this->validation->username_error
    </dfn>.
</p>
<h2>Rule Reference</h2>
<p>
    The following is a list of all the native rules that are available to use:
</p>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
    <tr>
        <th>
            Rule
        </th>
        <th>
            Parameter
        </th>
        <th>
            Description
        </th>
        <th>
            Example
        </th>
    </tr>
    <tr>
        <td class="td">
            <strong>required</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element is empty.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>matches</strong>
        </td>
        <td class="td">
            Yes
        </td>
        <td class="td">
            Returns FALSE if the form element does not match the one in the parameter.
        </td>
        <td class="td">
            matches[form_item]
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>min_length</strong>
        </td>
        <td class="td">
            Yes
        </td>
        <td class="td">
            Returns FALSE if the form element is shorter then the parameter value.
        </td>
        <td class="td">
            min_length[6]
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>max_length</strong>
        </td>
        <td class="td">
            Yes
        </td>
        <td class="td">
            Returns FALSE if the form element is longer then the parameter value.
        </td>
        <td class="td">
            max_length[12]
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>exact_length</strong>
        </td>
        <td class="td">
            Yes
        </td>
        <td class="td">
            Returns FALSE if the form element is not exactly the parameter value.
        </td>
        <td class="td">
            exact_length[8]
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>alpha</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element contains anything other than alphabetical characters.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>alpha_numeric</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element contains anything other than alpha-numeric characters.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>alpha_dash</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>numeric</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element contains anything other than numeric characters.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>integer</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element contains anything other than an integer.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>valid_email</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the form element does not contain a valid email address.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>valid_emails</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if any value provided in a comma separated list is not a valid email.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>valid_ip</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the supplied IP is not valid.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>valid_base64</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Returns FALSE if the supplied string contains anything other than valid Base64 characters.
        </td>
        <td class="td">
            &nbsp;
        </td>
    </tr>
</table>
<p>
    <strong>Note:</strong>
    These rules can also be called as discrete functions. For example:
</p>
<code>
    $this->validation->required($string);
</code>
<p class="important">
    <strong>Note:</strong>
    You can also use any native PHP functions that permit one parameter.
</p>
<h2>Prepping Reference</h2>
<p>
    The following is a list of all the prepping functions that are available to use:
</p>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
    <tr>
        <th>
            Name
        </th>
        <th>
            Parameter
        </th>
        <th>
            Description
        </th>
    </tr>
    <tr>
        <td class="td">
            <strong>xss_clean</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Runs the data through the XSS filtering function, described in the <a href="input.html">Input Class</a>
            page.
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>prep_for_form</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Converts special characters so that HTML data can be shown in a form field without breaking it.
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>prep_url</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Adds "http://" to URLs if missing.
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>strip_image_tags</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Strips the HTML from image tags leaving the raw URL.
        </td>
    </tr>
    <tr>
        <td class="td">
            <strong>encode_php_tags</strong>
        </td>
        <td class="td">
            No
        </td>
        <td class="td">
            Converts PHP tags to entities.
        </td>
    </tr>
</table>
<p class="important">
    <strong>Note:</strong>
    You can also use any native PHP functions that permit one parameter, 
    like 
    <kbd>
        trim
    </kbd>, 
    <kbd>
        htmlspecialchars
    </kbd>, 
    <kbd>
        urldecode
    </kbd>, etc.
</p>
<h2>Setting Custom Error Messages</h2>
<p>
    All of the native error messages are located in the following language file: 
    <dfn>
        language/english/validation_lang.php
    </dfn>
</p>
<p>
    To set your own custom message you can either edit that file, or use the following function:
</p>
<code>
    $this->validation->set_message('
    <var>
        rule
    </var>', '
    <var>
        Error Message
    </var>');
</code>
<p>
    Where 
    <var>
        rule
    </var>
    corresponds to the name of a particular rule, and 
    <var>
        Error Message
    </var>
    is the text you would like displayed.
</p>
<h2>Dealing with Select Menus, Radio Buttons, and Checkboxes</h2>
<p>
    If you use select menus, radio buttons or checkboxes, you will want the state of
    these items to be retained in the event of an error.  The Validation class has three functions that help you do this:
</p>
<h2>set_select()</h2>
<p>
    Permits you to display the menu item that was selected.  The first parameter
    must contain the name of the select menu, the second parameter must contain the value of
    each item. Example:
</p>
<code>
    &lt;select name="myselect">
    <br/>
    &lt;option value="one" 
    <dfn>
        &lt;?php echo  $this->validation->set_select('myselect', 'one'); ?>
    </dfn>
    >One&lt;/option>
    <br/>
    &lt;option value="two" 
    <dfn>
        &lt;?php echo  $this->validation->set_select('myselect', 'two'); ?>
    </dfn>
    >Two&lt;/option>
    <br/>
    &lt;option value="three" 
    <dfn>
        &lt;?php echo  $this->validation->set_select('myselect', 'three'); ?>
    </dfn>
    >Three&lt;/option>
    <br/>
    &lt;/select>
</code>
<h2>set_checkbox()</h2>
<p>
    Permits you to display a checkbox in the state it was submitted.  The first parameter
    must contain the name of the checkbox, the second parameter must contain its value. Example:
</p>
<code>
    &lt;input type="checkbox" name="mycheck" value="1" 
    <dfn>
        &lt;?php echo  $this->validation->set_checkbox('mycheck', '1'); ?>
    </dfn>
    />
</code>
<h2>set_radio()</h2>
<p>
    Permits you to display radio buttons in the state they were submitted.  The first parameter
    must contain the name of the radio button, the second parameter must contain its value. Example:
</p>
<code>
    &lt;input type="radio" name="myradio" value="1" 
    <dfn>
        &lt;?php echo  $this->validation->set_radio('myradio', '1'); ?>
    </dfn>
    />
</code>
