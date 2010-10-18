<h1>Typography Helper</h1>
<p>
    The Typography Helper file contains functions that help your format text in semantically relevant ways.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('typography');
</code>
<p>
    The following functions are available:
</p>
<h2>auto_typography()</h2>
<p>
    Formats text so that it is semantically and typographically correct HTML.  Takes a string as input and returns it with
    the following formatting:
</p>
<ul>
    <li>
        Surrounds paragraphs within &lt;p&gt;&lt;/p&gt; (looks for double line breaks to identify paragraphs).
    </li>
    <li>
        Single line breaks are converted to &lt;br /&gt;, except those that appear within &lt;pre&gt; tags.
    </li>
    <li>
        Block level elements, like &lt;div&gt; tags, are not wrapped within paragraphs, but their contained text is if it contains paragraphs.
    </li>
    <li>
        Quotes are converted to correctly facing curly quote entities, except those that appear within tags.
    </li>
    <li>
        Apostrophes are converted to curly apostrophy entities.
    </li>
    <li>
        Double dashes (either like -- this or like--this) are converted to em&#8212;dashes.
    </li>
    <li>
        Three consecutive periods either preceding or following a word are converted to ellipsis&#8230;
    </li>
    <li>
        Double spaces following sentences are converted to non-breaking spaces to mimic double spacing.
    </li>
</ul>
<p>
    Usage example:
</p>
<code>
    $string = auto_typography($string);
</code>
<p>
    <strong>Note:</strong>
    Typographic formatting can be processor intensive, particularly if you have a lot of content being formatted.
    If you choose to use this function you may want to consider <a href="<? echo site_url();?>userguide/general/caching">caching</a>
    your pages.
</p>
<h2>nl2br_except_pre()</h2>
<p>
    Converts newlines to &lt;br /&gt; tags unless they appear within &lt;pre&gt; tags. 
    This function is identical to the native PHP 
    <dfn>
        nl2br()
    </dfn>
    function, except that it ignores &lt;pre&gt; tags.
</p>
<p>
    Usage example:
</p>
<code>
    $string = nl2br_except_pre($string);
</code>
