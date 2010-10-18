<h1>Email Helper</h1>
<p>
    The Email Helper provides some assistive functions for working with Email. For a more robust email solution, see F-engine's <a href="<? echo site_url();?>userguide/libraries/email">Email Class</a>.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<p>
    <code>
        $this->load->helper('email');
    </code>
</p>
<p>
    The following functions are available:
</p>
<h2>valid_email('
    <var>
        email
    </var>')
</h2>
<p>
    Checks if an email is a correctly formatted email. Note that is doesn't actually prove the email will recieve mail, simply that it is a validly formed address.
</p>
<p>
    It returns TRUE/FALSE
</p>
<code>
    $this-&gt;load-&gt;helper('email');
    <br/>
    <br/>
    if (valid_email('email@somesite.com'))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo 'email is valid';
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;echo 'email is not valid';
    <br/>
    }
</code>
<h2>send_email('
    <var>
        recipient
    </var>', '
    <var>
        subject
    </var>', '
    <var>
        message
    </var>')
</h2>
<p>
    Sends an email using PHP's native <a href="http://www.php.net/function.mail">mail()</a>
    function. For a more robust email solution, see F-engine's <a href="<? echo site_url();?>userguide/libraries/email">Email Class</a>.
</p>
</div>
