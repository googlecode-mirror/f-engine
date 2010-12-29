<h1>Unit Testing Class</h1>
<p>
    Unit testing is an approach to software development in which tests are written for each function in your application.
    If you are not familiar with the concept you might do a little googling on the subject.
</p>
<p>
    F-engine's Unit Test class is quite simple, consisting of an evaluation function and two result functions.
    It's not intended to be a full-blown test suite but rather a simple mechanism to evaluate your code
    to determine if it is producing the correct data type and result.
</p>
<h2>Initializing the Class</h2>
<p>
    Like most other classes in F-engine, the Unit Test class is initialized in your controller using the 
    <dfn>
        $this->load->library
    </dfn>
    function:
</p>
<code>
    $this->load->library('unit_test');
</code>
<p>
    Once loaded, the Unit Test object will be available using: 
    <dfn>
        $this->unit
    </dfn>
</p>
<h2>Running Tests</h2>
<p>
    Running a test involves supplying a test and an expected result to the following function:
</p>
<h2>$this->unit->run( 
    <var>
        test
    </var>, 
    <var>
        expected result
    </var>, '
    <var>
        test name
    </var>' );
</h2>
<p>
    Where 
    <var>
        test
    </var>
    is the result of the code you wish to test,
    <var>
        expected result
    </var>
    is the data type you expect, and 
    <var>
        test name
    </var>
    is an optional name you can give your test. Example:
</p>
<code>
    $test = 1 + 1;
    <br/>
    <br/>
    $expected_result = 2;
    <br/>
    <br/>
    $test_name = 'Adds one plus one';
    <br/>
    <br/>
    $this->unit->run($test, $expected_result, $test_name);
</code>
<p>
    The expected result you supply can either be a literal match, or a data type match.  Here's an example of a literal:
</p>
<code>
    $this->unit->run('Foo', 'Foo');
</code>
<p>
    Here is an example of a data type match:
</p>
<code>
    $this->unit->run('Foo', 'is_string');
</code>
<p>
    Notice the use of "is_string" in the second parameter?  This tells the function to evaluate whether your test is producing a string
    as the result.  Here is a list of allowed comparison types:
</p>
<ul>
    <li>
        is_string
    </li>
    <li>
        is_bool
    </li>
    <li>
        is_true
    </li>
    <li>
        is_false
    </li>
    <li>
        is_int
    </li>
    <li>
        is_numeric
    </li>
    <li>
        is_float
    </li>
    <li>
        is_double
    </li>
    <li>
        is_array
    </li>
    <li>
        is_null
    </li>
</ul>
<h2>Generating Reports</h2>
<p>
    You can either display results after each test, or your can run several tests and generate a report at the end. 
    To show a report directly simply echo or return the 
    <var>
        run
    </var>
    function:
</p>
<code>
    echo $this->unit->run($test, $expected_result);
</code>
<p>
    To run a full report of all tests, use this:
</p>
<code>
    echo $this->unit->report();
</code>
<p>
    The report will be formatted in an HTML table for viewing.  If you prefer the raw data you can retrieve an array using:
</p>
<code>
    echo $this->unit->result();
</code>
<h2>Strict Mode</h2>
<p>
    By default the unit test class evaluates literal matches loosely.  Consider this example:
</p>
<code>
    $this->unit->run(1, TRUE);
</code>
<p>
    The test is evaluating an integer, but the expected result is a boolean.  PHP, however, due to it's loose data-typing
    will evaluate the above code as TRUE using a normal equality test:
</p>
<code>
    if (1 == TRUE) echo 'This evaluates as true';
</code>
<p>
    If you prefer, you can put the unit test class in to strict mode, which will compare the data type as well as the value:
</p>
<code>
    if (1 === TRUE) echo 'This evaluates as FALSE';
</code>
<p>
    To enable strict mode use this:
</p>
<code>
    $this->unit->use_strict(TRUE);
</code>
<h2>Enabling/Disabling Unit Testing</h2>
<p>
    If you would like to leave some testing in place in your scripts, but not have it run unless you need it, you can disable
    unit testing using:
</p>
<code>
    $this->unit->active(FALSE)
</code>
<h2>Creating a Template</h2>
<p>
    If you would like your test results formatted differently then the default you can set your own template.  Here is an
    example of a simple template.  Note the required pseudo-variables:
</p>
<code>
    $str = '
    <br/>
    &lt;table border="0" cellpadding="4" cellspacing="1">
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <kbd>
        {rows}
    </kbd>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;tr>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;td>
    <kbd>
        {item}
    </kbd>&lt;/td>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;td>
    <kbd>
        {result}
    </kbd>&lt;/td>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/tr>
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <kbd>
        {/rows}
    </kbd>
    <br/>
    &lt;/table>';
    <br/>
    <br/>
    $this->unit->set_template($str);
</code>
<p class="important">
    <strong>Note:</strong>
    Your template must be declared <strong>before</strong>
    running the unit test process.
</p>
