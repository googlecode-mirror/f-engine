<h1>Troubleshooting</h1>
<p>
    If you find that no matter what you put in your URL only your default page is loading, it might be that your server
    does not support the PATH_INFO variable needed to serve search-engine friendly URLs. 
    As a first step, open your 
    <dfn>
        application/config/config.php
    </dfn>
    file and look for the 
    <kbd>
        URI Protocol
    </kbd>
    information. It will recommend that you try a couple alternate settings.  If it still doesn't work after you've tried this you'll need 
    to force F-engine to add a question mark to your URLs.  To do this open your 
    <kbd>
        application/config/config.php
    </kbd>
    file and change this:
</p>
<code>
    $config['index_page'] = "index.php";
</code>
<p>
    To this:
</p>
<code>
    $config['index_page'] = "index.php?";
</code>
