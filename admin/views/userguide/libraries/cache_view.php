<h1>Cache Class</h1>
<p>The Cache Class lets you cache any data in order to achieve maximum performance.</p>  
<p>
Caching consists in storing objects or pages in their fully rendered state so that they are directly 
loaded for next requests. Caching any objects or content requiring “heavy” dynamic generation allows 
to cut response times and save server resources and memory. 
</p>

<h2>Initializing the Cache Class</h2>

<p>To initialize the Ajax Class in your controller constructor, use the the following code:</p>
<code>
    $this->load->cache("drivername");
</code>
<p>The following drivers are supported:</p>
<ul>
	<li>APC</li>
	<li>Eaccelerator</li>
	<li>File</li>
	<li>Memcache</li>
	<li>Sqlite</li>
	<li>Xcache</li>
</ul>
<p>You can modify driver configuration by modifying projectName<strong>/config/cache.php</strong> file 
or re-define it when cache is loaded:</p>
<code>
    $this->load->cache("apc",array("default_expire" => 7400));
</code>

<br />
<h2>set</h2>

<p>Set a value to cache with id and lifetime.</p>
<code>
$this->cache->set($id, $data);
</code>

<br />
<h2>set_with_tags</h2>

<p>Set a value based on an id. Optionally add tags.</p>
<code>
$this->cache->set_with_tags($id, $data, $lifetime, $tags)
</code>
<p class="important">
    <strong>Note:</strong>
    Tags are only supported by sqlite cache driver.
</p>

<br />
<h2>get</h2>

<p>Retrieve a cached value entry by id.</p>
<code>
$this->cache->get($id, $default);
</code>

<br />
<h2>find</h2>

<p>Find cache entries based on a tag.</p>
<code>
$this->cache->find($tag);
</code>

<p class="important">
    <strong>Note:</strong>
    Only supported by sqlite cache driver.
</p>

<br />
<h2>delete</h2>

<p>Delete a cache entry based on id.</p>
<code>
$this->cache->delete($id);
</code>

<br />
<h2>delete_tag</h2>

<p>Delete cache entries based on a tag.</p>
<code>
$this->cache->delete_tag($tag);
</code>

<br />
<h2>delete_all</h2>

<p>Delete all cache entries.</p>
<code>
$this->cache->delete_all();
</code>

<br />
<h2>garbage_collector</h2>

<p>Cleans any expired cache entries from the cache.</p>
<code>
$this->cache->garbage_collect();
</code>
<p class="important">
    <strong>Note:</strong>
    Only supported by sqlite cache driver.
</p>