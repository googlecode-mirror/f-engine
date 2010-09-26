<h1>Web Page Caching</h1>
<p>
    F-engine lets you cache your pages in order to achieve maximum performance.
</p>
<p>
    Although F-engine is quite fast, the amount of dynamic information you display in your pages will correlate directly to the
    server resources, memory, and processing cycles utilized, which affect your page load speeds.
    By caching your pages, since they are saved in their fully rendered state, you can achieve performance that nears that of static web pages.
</p>
<h2>How Does Caching Work?</h2>
<p>
    Caching can be enabled on a per-page basis, and you can set the length of time that a page should remain cached before being refreshed. 
    When a page is loaded for the first time, the cache file will be written to your 
    <dfn>
        system/cache
    </dfn>
    folder.  On subsequent page loads the cache file will be retrieved
    and sent to the requesting user's browser.  If it has expired, it will be deleted and refreshed before being sent to the browser.
</p>
<p>
    Note: The Benchmark tag is not cached so you can still view your page load speed when caching is enabled.
</p>
<h2>Enabling Caching</h2>
<p>
    To enable caching, put the following tag in any of your controller functions:
</p>
<code>
    $this->output->cache(
    <var>
        n
    </var>);
</code>
<p>
    Where 
    <var>
        n
    </var>
    is the number of <strong>minutes</strong>
    you wish the page to remain cached between refreshes.
</p>
<p>
    The above tag can go anywhere within a function. It is not affected by the order that it appears, so place it wherever it seems
    most logical to you. Once the tag is in place, your pages will begin being cached.
</p>
<p class="important">
    <strong>Warning:</strong>
    Because of the way F-engine stores content for output, caching will only work if you are generating display for your controller with a 
	<a href="<? echo site_url();?>userguide/general/views">view</a>.
</p>
<p class="important">
    <strong>Note:</strong>
    Before the cache files can be written you must set the file permissions on your
    <dfn>
        system/cache
    </dfn>
    folder such that it is writable.
</p>
<h2>Deleting Caches</h2>
<p>
    If you no longer wish to cache a file you can remove the caching tag and it will no longer be refreshed when it expires.  Note:
    Removing the tag will not delete the cache immediately.  It will have to expire normally.  If you need to remove it earlier you
    will need to manually delete it from your cache folder.
</p>
