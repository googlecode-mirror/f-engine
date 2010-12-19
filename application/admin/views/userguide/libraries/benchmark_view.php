<h1>Benchmarking Class</h1>
<p>
    F-engine has a Benchmarking class that is always active, enabling the time difference between any
    two marked points to be calculated.
</p>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<p>
    In addition, the benchmark is always started the moment the framework is
    invoked, and ended by the output class right before sending the final view to the browser, enabling a very accurate
    timing of the entire system execution to be shown.
</p>
<h3>Table of Contents</h3>
<ul>
    <li>
        <a href="#using">Using the Benchmark Class</a>
    </li>
    <li>
        <a href="#profiler">Profiling Your Benchmark Points</a>
    </li>
    <li>
        <a href="#execution">Displaying Total Execution Time</a>
    </li>
    <li>
        <a href="#memory">Displaying Memory Consumption</a>
    </li>
</ul>
<a name="using"></a>
<h2>Using the Benchmark Class</h2>
<p>
    The Benchmark class can be used within your <a href="<?php echo site_url();?>userguide/general/controllers">controllers</a>, <a href="<? echo site_url();?>userguide/general/views">views</a>, or your <a href="<? echo site_url();?>userguide/general/models">Models</a>.  The process for usage is this:
</p>
<ol>
    <li>
        Mark a start point
    </li>
    <li>
        Mark an end point
    </li>
    <li>
        Run the "elapsed time" function to view the results
    </li>
</ol>
<p>
    Here's an example using real code:
</p>
<code>
    $this->benchmark->mark('code_start');
    <br/>
    <br/>
    // Some code happens here
    <br/>
    <br/>
    $this->benchmark->mark('code_end');
    <br/>
    <br/>
    echo $this->benchmark->elapsed_time('code_start', 'code_end');
</code>
<p class="important">
    <strong>Note:</strong>
    The words "code_start" and "code_end" are arbitrary.  They are simply words used to set two markers.  You can
    use any words you want, and you can set multiple sets of markers. Consider this example:
</p>
<code>
    $this->benchmark->mark('dog');
    <br/>
    <br/>
    // Some code happens here
    <br/>
    <br/>
    $this->benchmark->mark('cat');
    <br/>
    <br/>
    // More code happens here
    <br/>
    <br/>
    $this->benchmark->mark('bird');
    <br/>
    <br/>
    echo $this->benchmark->elapsed_time('dog', 'cat');
    <br/>
    echo $this->benchmark->elapsed_time('cat', 'bird');
    <br/>
    echo $this->benchmark->elapsed_time('dog', 'bird');
</code>
<a name="profiler"></a>
<h2>Profiling Your Benchmark Points</h2>
<p>
    If you want your benchmark data to be available to the <a href="<?php echo site_url();?>userguide/general/profiling">Profiler</a>
    all of your marked points must be set up in pairs, and 
    each mark point name must end with 
    <kbd>
        _start
    </kbd>
    and 
    <kbd>
        _end
    </kbd>.
    Each pair of points must otherwise be named identically. Example:
</p>
<code>
    $this->benchmark->mark('my_mark
    <kbd>
        _start
    </kbd>');
    <br/>
    <br/>
    // Some code happens here...
    <br/>
    <br/>
    $this->benchmark->mark('my_mark
    <kbd>
        _end
    </kbd>');
    <br/>
    <br/>
    $this->benchmark->mark('another_mark
    <kbd>
        _start
    </kbd>');
    <br/>
    <br/>
    // Some more code happens here...
    <br/>
    <br/>
    $this->benchmark->mark('another_mark
    <kbd>
        _end
    </kbd>');
</code>
<p>
    Please read the <a href="<?php echo site_url();?>userguide/general/profiling">Profiler page</a>
    for more information.
</p>
<a name="execution"></a>
<h2>Displaying Total Execution Time</h2>
<p>
    If you would like to display the total elapsed time from the moment F-engine starts to the moment the final output
    is sent to the browser, simply place this in one of your view templates:
</p>
<code>
    &lt;?php echo $this->benchmark->elapsed_time();?&gt;
</code>
<p>
    You'll notice that it's the same function used in the examples above to calculate the time between two point, except you are<strong>not</strong>
    using any parameters.  When the parameters are absent, F-engine does not stop the benchmark until right before the final
    output is sent to the browser.  It doesn't matter where you use the function call, the timer will continue to run until the very end.
</p>
<p>
    An alternate way to show your elapsed time in your view files is to use this pseudo-variable, if you prefer not to use the pure PHP:
</p>
<code>
    {elapsed_time}
</code>
<p class="important">
    <strong>Note:</strong>
    If you want to benchmark anything within your controller
    functions you must set your own start/end points.
</p>
<a name="memory"></a>
<h2>Displaying Memory Consumption</h2>
<p>
    If your PHP installation is configured with --enable-memory-limit, you can display the amount of memory consumed by the entire
    system using the following code in one of your view file:
</p>
<code>
    &lt;?php echo $this->benchmark->memory_usage();?&gt;
</code>
<p>
    Note: This function can only be used in your view files. The consumption will reflect the total memory used by the entire app.
</p>
<p>
    An alternate way to show your memory usage in your view files is to use this pseudo-variable, if you prefer not to use the pure PHP:
</p>
<code>
    {memory_usage}
</code>
