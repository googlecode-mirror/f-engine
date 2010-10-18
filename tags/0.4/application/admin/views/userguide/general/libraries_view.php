<h1>Using F-engine Libraries</h1>
<p>
    All of the available libraries are located in your 
    <dfn>
        system/libraries
    </dfn>
    folder. 
    In most cases, to use one of these classes involves initializing it within a 
	<a href="<? echo site_url();?>userguide/general/controllers">controller</a>
    using the following initialization function:
</p>
<code>
    $this->load->library('
    <var>
        class name
    </var>'); 
</code>
<p>
    Where 
    <var>
        class name
    </var>
    is the name of the class you want to invoke.  For example, to load the validation class you would do this:
</p>
<code>
    $this->load->library('
    <var>
        validation
    </var>'); 
</code>
<p>
    Once initialized you can use it as indicated in the user guide page corresponding to that class.
</p>
<h2>Creating Your Own Libraries</h2>
<p>
    Please read the section of the user guide that discusses how to <a href="<? echo site_url();?>userguide/general/creating_libraries">create your own libraries</a>
</p>
