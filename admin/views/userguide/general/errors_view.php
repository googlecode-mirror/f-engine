<h1>Error Handling</h1>
<p>
    F-engine lets you build error reporting into your applications using the functions described below.
    In addition, it has an error logging class that permits error and debugging messages to be saved as text files.
</p>
<p class="important">
    <strong>Note:</strong>
    By default, F-engine displays all PHP errors.  You might 
    wish to change this behavior once your development is complete.  You'll find the 
    <dfn>
        error_reporting()
    </dfn>
    function located at the top of your main index.php file. Disabling error reporting will NOT prevent log files
    from being written if there are errors.
</p>
<p>
    Unlike most systems in F-engine, the error functions are simple procedural interfaces that are available
    globally throughout the application.  This approach permits error messages to get triggered without having to worry
    about class/function scoping.
</p>
<p>
    The following functions let you generate errors:
</p>
<h2>show_error('
    <var>
        message
    </var>')
</h2>
<p>
    This function will display the error message supplied to it using the following error template:
</p>
<p>
    <dfn>
        application/errors/
    </dfn>
    <kbd>
        error_general.php
    </kbd>
</p>
<h2>show_404('
    <var>
        page
    </var>')
</h2>
<p>
    This function will display the 404 error message supplied to it using the following error template:
</p>
<p>
    <dfn>
        application/errors/
    </dfn>
    <kbd>
        error_404.php
    </kbd>
</p>
<p>
    The function expects the string passed to it to be the file path to the page that isn't found.
    Note that F-engine automatically shows 404 messages if controllers are not found.
</p>
<h2>log_message('
    <var>
        level
    </var>', '
    <samp>
        message
    </samp>')
</h2>
<p>
    This function lets you write messages to your log files.  You must supply one of three "levels"
    in the first parameter, indicating what type of message it is (debug, error, info), with the message
    itself in the second parameter.  Example:
</p>
<code>
    if ($some_var == "")
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;log_message('error', 'Some variable did not contain a value.');
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;log_message('debug', 'Some variable was correctly set');
    <br/>
    }
    <br/>
    <br/>
    log_message('info', 'The purpose of some variable is to provide some value.');
    <br/>
</code>
<p>
    There are three message types:
</p>
<ol>
    <li>
        Error Messages.  These are actual errors, such as PHP errors or user errors.
    </li>
    <li>
        Debug Messages.  These are messages that assist in debugging. For example, if a class has been initialized, you could log this as debugging info.
    </li>
    <li>
        Informational Messages.  These are the lowest priority messages, simply giving information regarding some process.  F-engine doesn't natively generate any info messages but you may want to in your application.
    </li>
</ol>
<p class="important">
    <strong>Note:</strong>
    In order for the log file to actually be written, the
    "logs" folder must be writable.  In addition, you must set the "threshold" for logging.
    You might, for example, only want error messages to be logged, and not the other two types.
    If you set it to zero logging will be disabled.
</p>
