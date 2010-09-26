<h1>Typography Class</h1>
<p>
    The Typography Class provides functions that help you format text.
</p>
<h2>Initializing the Class</h2>
<p>
    Like most other classes in F-engine, the Typography class is initialized in your controller using the 
    <dfn>
        $this->load->library
    </dfn>
    function:
</p>
<code>
    $this->load->library('typography');
</code>
<p>
    Once loaded, the Typography library object will be available using: 
    <dfn>
        $this->typography
    </dfn>
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
    $string = $this->typography->auto_typography($string);
</code>
<h3>Parameters</h3>
<p>
    There are two optional parameters:
</p>
<ol>
    <li>
        <strong>Strip JavaScript Event Handlers</strong>. Determines whether the parser should strip all JavaScript event handlers for security.  Use bolean 
        <kbd>
            TRUE
        </kbd>
        or 
        <kbd>
            FALSE
        </kbd>.
    </li>
    <li>
        <strong>Reduce Linebreaks</strong>.  Determines whether the parser should reduce more then two consecutive linebreaks down to two. Use bolean 
        <kbd>
            TRUE
        </kbd>
        or 
        <kbd>
            FALSE
        </kbd>.
    </li>
</ol>
<p>
    By default the parser strips JS Event handlers and does not reduce line breaks. In other words, if no parameters are submitted, it is the same as doing this:
</p>
<code>
    $string = $this->typography->auto_typography($string, 
    <kbd>
        TRUE
    </kbd>, 
    <kbd>
        FALSE
    </kbd>);
</code>
<p class="important">
    <strong>Note:</strong>
    Typographic formatting can be processor intensive, particularly if you have a lot of content being formatted.
    If you choose to use this function you may want to consider <a href="<? echo site_url();?>userguide/general/caching">caching</a>
    your pages.
</p>
<h2>convert_characters()</h2>
<p>
    This function is similiar to the 
    <dfn>
        auto_typography
    </dfn>
    function above, except that it only does character conversion:
</p>
<ul>
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
    $string = $this->typography->convert_characters($string);
</code>
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
    $string = $this->typography->nl2br_except_pre($string);
</code>
<h2>protect_braced_quotes</h2>
<p>
    When using the Typography library in conjunction with the Template Parser library it can often be desirable to protect single 
    and double quotes within curly braces.  To enable this, set the 
    <kbd>
        protect_braced_quotes
    </kbd>
    class property to 
    <samp>
        TRUE
    </samp>.
    <p>
        Usage example:
    </p>
    <code>
        $this->load->library('typography');
        <br/>
        $this->typography->protect_braced_quotes = TRUE;
    </code>
