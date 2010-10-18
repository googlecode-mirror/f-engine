<h1>Managing your Applications</h1>

<p>By default it is assumed that you only intend to use F-engine to manage one application, which you will build in your
<dfn>system/application/</dfn> directory.  It is possible, however, to have multiple sets of applications that share a single
F-engine installation, or even to rename or relocate your <dfn>application</dfn> folder.</p>

<h2>Renaming the Application Folder</h2>

<p>If you would like to rename your <dfn>application</dfn> folder you may do so as long as you open your main <kbd>index.php</kbd>
file and set its name using the <samp>$application_folder</samp> variable:</p>

<code>$application_folder = "application";</code>

<h2>Relocating your Application Folder</h2>

<p>It is possible to move your <dfn>application</dfn> folder to a different location on your server than your <kbd>system</kbd> folder. 
To do so open your main <kbd>index.php</kbd> and set a <em>full server path</em> in the <samp>$application_folder</samp> variable.</p>


<code>$application_folder = "/Path/to/your/application";</code>


<h2>Running Multiple Applications with one F-engine Installation</h2>

<p>If you would like to share a common F-engine installation to manage several different applications simply 
put all of the directories located inside your <kbd>application</kbd> folder into their
own sub-folder.</p>

<p>For example, let's say you want to create two applications, "foo" and "bar".  You will structure your
application folder like this:</p>

<code>system/application/<var>foo</var>/<br />
system/application/<var>foo</var>/config/<br />
system/application/<var>foo</var>/controllers/<br />
system/application/<var>foo</var>/errors/<br />
system/application/<var>foo</var>/libraries/<br />
system/application/<var>foo</var>/models/<br />
system/application/<var>foo</var>/views/<br />
system/application/<samp>bar</samp>/<br />
system/application/<samp>bar</samp>/config/<br />
system/application/<samp>bar</samp>/controllers/<br />
system/application/<samp>bar</samp>/errors/<br />
system/application/<samp>bar</samp>/libraries/<br />
system/application/<samp>bar</samp>/models/<br />
system/application/<samp>bar</samp>/views/</code>


<p>To select a particular application for use requires that you open your main <kbd>index.php</kbd> file and set the <dfn>$application_folder</dfn>
variable.  For example, to select the "foo" application for use you would do this:</p>

<code>$application_folder = "application/foo";</code>

<p class="important"><strong>Note:</strong>&nbsp; Each of your applications will need its own <dfn>index.php</dfn> file which 
calls the desired application.  The index.php file can be named anything you want.</p>