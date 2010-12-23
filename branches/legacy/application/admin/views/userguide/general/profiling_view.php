<h1>Profiling Your Application</h1>
<p>
    The Profiler Class will display benchmark results, queries you have run, and $_POST data at the bottom of your pages.
    This information can be useful during development in order to help with debugging and optimization.
</p>
<h2>Initializing the Class</h2>
<p class="important">
    <strong>Important:</strong>&nbsp; This class does 
    <kbd>
        NOT
    </kbd>
    need to be initialized. It is loaded automatically by the
	<a href="<?php echo site_url();?>userguide/libraries/output">Output Class</a>
    if profiling is enabled as shown below.
</p>
<h2>Enabling the Profiler</h2>
<p>
    To enable the profiler place the following function anywhere within your 
	<a href="<?php echo site_url();?>userguide/general/controllers">Controller</a>
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
<h2>Setting Benchmark Points</h2>
<p>
    In order for the Profiler to compile and display your benchmark data you must name your mark points using specific syntax.
</p>
<p>
    Please read the information on setting Benchmark points in 
	<a href="<?php echo site_url();?>userguide/libraries/benchmark">Benchmark Class</a>
    page.
</p>
