<h1>Auto-loading Resources</h1>
<p>
    F-engine comes with an "Auto-load" feature that permits libraries, helpers, and plugins to be initialized
    automatically every time the system runs. If you need certain resources globally throughout your application you should
    consider auto-loading them for convenience.
</p>
<p>
    The following items can be loaded automatically:
</p>
<ul>
    <li>
        Core classes found in the "libraries" folder
    </li>
    <li>
        Helper files found in the "helpers" folder
    </li>
    <li>
        Plugins found in the "plugins" folder
    </li>
    <li>
        Custom config files found in the "config" folder
    </li>
    <li>
        Language files found in the "system/language" folder 
    </li>
    <li>
        Models found in the &quot;models&quot; folder
    </li>
</ul>
<p>
    To autoload resources, open the 
    <var>
        application/config/autoload.php
    </var>
    file and add the item you want 
    loaded to the 
    <samp>
        autoload
    </samp>
    array. You'll find instructions in that file corresponding to each
    type of item.
</p>
<p class="important">
    <strong>Note:</strong>
    Do not include the file extension (.php) when adding items to the autoload array.
</p>
