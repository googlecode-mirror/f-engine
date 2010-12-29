<h1>Alternate PHP Syntax for View Files</h1>

<p>If you do not utilize F-engine's <a href="<?php echo site_url();?>userguide/libraries/parser">template engine</a>, you'll be using pure PHP
in your View files.  To minimize the PHP code in these files, and to make it easier to identify the code blocks it is recommended that you use 
PHPs alternative syntax for control structures and short tag echo statements.  If you are not familiar with this syntax, it allows you to eliminate the braces from your code,
and eliminate "echo" statements.</p>

<h2>Automatic Short Tag Support</h2>

<p><strong>Note:</strong> If you find that the syntax described in this page does not work on your server it might
be that "short tags" are disabled in your PHP ini file. F-engine will optionally rewrite short tags on-the-fly, 
allowing you to use that syntax even if your server doesn't support it.  This feature can be enabled in your
<dfn>config/config.php</dfn> file.</p>

<p class="important">Please note that if you do use this feature, if PHP errors are encountered
in your <strong>view files</strong>, the error message and line number will not be accurately shown.  Instead, all errors
will be shown as <kbd>eval()</kbd> errors.</p>


<h2>Alternative Echos</h2>

<p>Normally to echo, or print out a variable you would do this:</p>

<code>&lt;?php echo $variable; ?></code>

<p>With the alternative syntax you can instead do it this way:</p>

<code>&lt;?=$variable?></code>



<h2>Alternative Control Structures</h2>

<p>Controls structures, like <var>if</var>, <var>for</var>, <var>foreach</var>, and <var>while</var> can be
written in a simplified format as well.  Here is an example using foreach:</p>

<code>
&lt;ul><br />
<br />
<var>&lt;?php foreach($todo as $item): ?></var><br />
<br />
&lt;li><var>&lt;?=$item?></var>&lt;/li><br />
<br />
<var>&lt;?php endforeach; ?></var><br />
<br />
&lt;/ul></code>

<p>Notice that there are no braces.  Instead, the end brace is replaced with <var>endforeach</var>.
Each of the control structures listed above has a similar closing syntax:
<var>endif</var>, <var>endfor</var>, <var>endforeach</var>, and <var>endwhile</var></p>

<p>Also notice that instead of using a semicolon after each structure (except the last one), there is a colon.  This is
important!</p>

<p>Here is another example, using if/elseif/else.  Notice the colons:</p>


<code><var>&lt;?php if ($username == 'sally'): ?></var><br />
<br />
&nbsp;&nbsp;&nbsp;&lt;h3>Hi Sally&lt;/h3><br />
<br />
<var>&lt;?php elseif ($username == 'joe'): ?></var><br />
<br />
&nbsp;&nbsp;&nbsp;&lt;h3>Hi Joe&lt;/h3><br />
<br />
<var>&lt;?php else: ?></var><br />
<br />
&nbsp;&nbsp;&nbsp;&lt;h3>Hi unknown user&lt;/h3><br />
<br />
<var>&lt;?php endif; ?></var></code>