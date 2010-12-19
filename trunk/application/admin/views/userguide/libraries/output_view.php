<h1>Output Class</h1>
<p>
    The Output class is a small class with one main function:  To send the finalized web page to the requesting browser.  It is 
    also responsible for <a href="<?php echo site_url();?>userguide/general/caching">caching</a>
    your web pages, if you use that feature.
</p>
<p class="important">
    <strong>Note:</strong>
    This class is initialized automatically by the system so there is no need to do it manually.
</p>
<p>
    Under normal circumstances you won't even notice the Output class since it works transparently without your intervention. 
    For example, when you use the <a href="<?php echo site_url();?>userguide/libraries/loader">Loader</a>
    class to load a view file, it's automatically
    passed to the Output class, which will be called automatically by F-engine at the end of system execution.
    It is possible, however, for you to manually intervene with the output if you need to, using either of the two following functions:
</p>
<h2>$this->output->set_output();</h2>
<p>
    Permits you to manually set the final output string.  Usage example:
</p>
<code>
    $this->output->set_output($data);
</code>
<p>
    <strong>Important:</strong>
    If you do set your output manually, it must be the last thing done in the function you call it from.
    For example, if you build a page in one of your controller functions, don't set the output until the end.
</p>
<h2>$this->output->get_output();</h2>
<p>
    Permits you to manually retrieve any output that has been sent for storage in the output class.  Usage example:
</p>
<code>
    $string = $this->output->get_output();
</code>
<p>
    Note that data will only be retrievable from this function if it has been previously sent to the output class by one of the 
    F-engine functions like 
    <var>
        $this->load->view()
    </var>.
</p>
<h2>$this->output->set_header();</h2>
<p>
    Permits you to manually set server headers, which the output class will send for you when outputting the final rendered display.  Example:
</p>
<code>
    $this->output->set_header("HTTP/1.0 200 OK");
    <br/>
    $this->output->set_header("HTTP/1.1 200 OK");
    <br/>
    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
    <br/>
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
    <br/>
    $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
    <br/>
    $this->output->set_header("Pragma: no-cache"); 
</code>
<h2>$this->output->set_status_header();</h2>
<p>
    Permits you to manually set a server status header.  Example:
</p>
<code>
    $this->output->set_status_header('401');
    <br/>
    // Sets the header as:  Unauthorized
</code>
<p>
    <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html">See here</a>
    for a full list of headers.
</p>
<h2>$this->output->enable_profiler();</h2>
<p>
    Permits you to enable/disable the <a href="<?php echo site_url();?>userguide/general/profiling">Profiler</a>, which will display benchmark and other data
    at the bottom of your pages for debugging and optimization purposes.
</p>
<p>
    To enable the profiler place the following function anywhere within your <a href="<?php echo site_url();?>userguide/general/controllers">Controller</a>
    functions:
</p>
<code>
    $this->output->enable_profiler(TRUE);
</code>
<p>
    When enabled a report will be generated and inserted at the bottom of your pages.
</p>
<p>
    To disable the profiler you will use:
</p>
<code>
    $this->output->enable_profiler(FALSE);
</code>
<h2>$this->output->cache();</h2>
<p>
    The F-engine output library also controls caching.  For more information, please see the <a href="<?php echo site_url();?>userguide/general/caching">caching documentation</a>.
</p>
