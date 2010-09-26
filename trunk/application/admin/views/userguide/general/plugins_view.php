<h1>Plugins</h1>

<p>Plugins work almost identically to 
<a href="<? echo site_url();?>userguide/general/helpers">Helpers</a>.  The main difference is that a plugin usually
provides a single function, whereas a Helper is usually a collection of functions.  Helpers are also considered a part of
the core system; plugins are intended to be created and shared by our community.</p>

<p>Plugins should be saved to your <dfn>system/plugins</dfn> directory or you can create a folder called <kbd>plugins</kbd> inside
your <kbd>application</kbd> folder and store them there.  F-engine will look first in your <dfn>system/application/plugins</dfn>
directory.  If the directory does not exist or the specified plugin is not located there CI will instead look in your global
<dfn>system/plugins</dfn> folder.</p>


<h2>Loading a Plugin</h2>

<p>Loading a plugin file is quite simple using the following function:</p>

<code>$this->load->plugin('<var>name</var>');</code>

<p>Where <var>name</var> is the file name of the plugin, without the .php file extension or the "plugin" part.</p>

<p>For example, to load the <dfn>Captcha</dfn> plugin, which is named <var>captcha_pi.php</var>, you will do this:</p>

<code>$this->load->plugin('<var>captcha</var>');</code>



<p>A plugin can be loaded anywhere within your 
<a href="<? echo site_url();?>userguide/general/controllers">controller</a> functions (or even within your 
<a href="<? echo site_url();?>userguide/general/views">View files</a>, although that's not a good practice),
as long as you load it before you use it.  You can load your plugins in your controller constructor so that they become available
automatically in any function, or you can load a plugin in a specific function that needs it.</p>

<p class="important">Note: The Plugin loading function above does not return a value, so don't try to assign it to a variable.  Just use it as shown.</p>


<h2>Loading Multiple Plugins</h2>

<p>If you need to load more than one plugin you can specify them in an array, like this:</p>

<code>$this->load->plugin( <samp>array(</samp>'<var>plugin1</var>', '<var>plugin2</var>', '<var>plugin3</var>'<samp>)</samp> );</code>

<h2>Auto-loading Plugins</h2>

<p>If you find that you need a particular plugin globally throughout your application, you can tell F-engine to auto-load it
during system initialization. This is done by opening the <var>application/config/autoload.php</var> file and adding the plugin to the autoload array.</p>


<h2>Using a Plugin</h2>

<p>Once you've loaded the Plugin, you'll call it the way you would a standard PHP function.</p>