<h1>F-engine URLs</h1>
<p>
    By default, URLs in F-engine are designed to be search-engine and human friendly.  Rather than using the standard "query string" 
    approach to URLs that is synonymous with dynamic systems, F-engine uses a <strong>segment-based</strong>
    approach:
</p>
<code>
    example.com/
    <var>
        news
    </var>/
    <dfn>
        article
    </dfn>/
    <samp>
        my_article
    </samp>
</code>
<p class="important">
    <strong>Note:</strong>
    Query string URLs can be optionally enabled, as described below.
</p>
<h2>URI Segments</h2>
<p>
    The segments in the URL, in following with the Model-View-Controller approach, usually represent:
</p>
<code>
    example.com/
    <var>
        optionalSubFolder
    </var>/
    <dfn>
        filename
    </dfn>/
    <samp>
        ID
    </samp>
</code>
<ol>
    <li>
        The first segment is needed only when the controller is located in a subfolder. Specify as much subfolder as needed separated by "/"
    </li>
    <li>
        The second segment represents the <strong>filename</strong> that should be called. If the file is located in a subfolder and it share name with, this segment becomes optional.
    </li>
    <li>
        The third, and any additional segments, represent the ID and any variables that will be passed to the controller.
    </li>
</ol>
<p>
    The <a href="<?php echo site_url();?>userguide/libraries/uri">URI Class</a>
    and the <a href="<?php echo site_url();?>userguide/helpers/url_helper">URL Helper</a>
    contain functions that make it easy to work with your URI data.  In addition, your URLs can be remapped using the <a href="<?php echo site_url();?>userguide/general/routing">URI Routing</a>
    feature for more flexibility.
</p>
<h2>Removing the index.php file</h2>
<p>
    By default, the <strong>index.php</strong>
    file will be included in your URLs:
</p>
<code>
    example.com/
    <var>
        index.php
    </var>/news/article/my_article
</code>
<p>
    You can easily remove this file by using a .htaccess file with some simple rules. Here is an example
    of such a file, using the "negative" method in which everything is redirected except the specified items:
</p>
<code>
    RewriteEngine on
    <br/>
    RewriteCond $1 !^(index\.php|public_data|robots\.txt)
    <br/>
    RewriteRule ^(.*)$ /index.php/$1 [L]
</code>
<p>
    In the above example, any HTTP request other than those for index.php, public_data, and robots.txt is treated as
    a request for your index.php file.
</p>
<h2>Adding a URL Suffix</h2>
<p>
    In your 
    <dfn>
        config/config.php
    </dfn>
    file you can specify a suffix that will be added to all URLs generated
    by F-engine.  For example, if a URL is this:
</p>
<code>
    example.com/index.php/products/view/shoes
</code>
<p>
    You can optionally add a suffix, like 
    <kbd>
        .html
    </kbd>, making the page appear to be of a certain type:
</p>
<code>
    example.com/index.php/products/view/shoes.html
</code>
