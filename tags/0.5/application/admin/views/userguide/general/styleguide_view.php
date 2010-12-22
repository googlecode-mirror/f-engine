<h1>General Style and Syntax</h1>
<p>
    The following page describes the coding rules use adhere to when developing CodeIgniter.
</p>
<h2>Table of Contents</h2>
<ul class="minitoc">
    <li>
        <a href="#php_closing_tag">PHP Closing Tag</a>
    </li>
    <li>
        <a href="#class_and_method_naming">Class and Method Naming</a>
    </li>
    <li>
        <a href="#variable_names">Variable Names</a>
    </li>
    <li>
        <a href="#commenting">Commenting</a>
    </li>
    <li>
        <a href="#constants">Constants</a>
    </li>
    <li>
        <a href="#true_false_and_null">TRUE, FALSE, and NULL</a>
    </li>
    <li>
        <a href="#logical_operators">Logical Operators</a>
    </li>
    <li>
        <a href="#comparing_return_values_and_typecasting">Comparing Return Values and Typecasting</a>
    </li>
    <li>
        <a href="#debugging_code">Debugging Code</a>
    </li>
    <li>
        <a href="#whitespace_in_files">Whitespace in Files</a>
    </li>
    <li>
        <a href="#compatibility">Compatibility</a>
    </li>
    <li>
        <a href="#class_and_file_names_using_common_words">Class and File Names using Common Words</a>
    </li>
    <li>
        <a href="#database_table_names">Database Table Names</a>
    </li>
    <li>
        <a href="#one_file_per_class">One File per Class</a>
    </li>
    <li>
        <a href="#whitespace">Whitespace</a>
    </li>
    <li>
        <a href="#line_breaks">Line Breaks</a>
    </li>
    <li>
        <a href="#code_indenting">Code Indenting</a>
    </li>
    <li>
        <a href="#bracket_spacing">
        Bracket and Parenthetic Spacing
    </li>
    <li>
        <a href="#localized_text_in_control_panel">Localized Text in Control Panel</a>
    </li>
    <li>
        <a href="#private_methods_and_variables">Private Methods and Variables</a>
    </li>
    <li>
        <a href="#php_errors">PHP Errors</a>
    </li>
    <li>
        <a href="#short_open_tags">Short Open Tags</a>
    </li>
    <li>
        <a href="#one_statement_per_line">One Statement Per Line</a>
    </li>
    <li>
        <a href="#strings">Strings</a>
    </li>
    <li>
        <a href="#sql_queries">SQL Queries</a>
    </li>
    <li>
        <a href="#default_function_arguments">Default Function Arguments</a>
    </li>
    <li>
        <a href="#overlapping_tag_parameters">Overlapping Tag Parameters</a>
    </li>
</ul>
<h2><a name="php_closing_tag"></a>PHP Closing Tag</h2>
<div class="guidelineDetails">
    <p>
        The PHP closing tag on a PHP document <strong>?&gt;</strong>
        is optional to the PHP parser.  However, if used, any whitespace following the closing tag, whether introduced 
        by the developer, user, or an FTP application, can cause unwanted output, PHP errors, or if the latter are suppressed, blank pages.  For this reason, all PHP files should<strong>OMIT</strong>
        the closing PHP tag, and instead use a comment block to mark the end of file and it's location relative to the application root.
        This allows you to still identify a file as being complete and not truncated.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        &lt;?php
        echo "Here's my code!";
        ?&gt;
		<br /><strong>CORRECT</strong>:
        &lt;?php
        echo "Here's my code!";
        /* End of file myfile.php */
        /* Location: ./system/modules/mymodule/myfile.php */
    </code>
</div>
<h2><a name="class_and_method_naming"></a>Class and Method Naming</h2>
<div class="guidelineDetails">
    <p>
        Class names should always have their first letter uppercase, and the constructor method should match identically.  Multiple words should be separated with an underscore, and not CamelCased.  All other class methods should be entirely lowercased and named to clearly indicate their function, preferably including a verb.  Try to avoid overly long and verbose names.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        class superclass
        class SuperClass
		<br /><strong>CORRECT</strong>:
        class Super_class
    </code>
    <p>
        Notice that the Class and constructor methods are identically named and cased:
    </p>
    <code>
        class Super_class {
        function Super_class()
        {
        }
        }
    </code>
    <p>
        Examples of improper and proper method naming:
    </p>
    <code>
        <strong>INCORRECT</strong>:
        function fileproperties()		// not descriptive and needs underscore separator
        function fileProperties()		// not descriptive and uses CamelCase
        function getfileproperties()		// Better!  But still missing underscore separator
        function getFileProperties()		// uses CamelCase
        function get_the_file_properties_from_the_file()	// wordy
		<br /><strong>CORRECT</strong>:
        function get_file_properties()	// descriptive, underscore separator, and all lowercase letters
    </code>
</div>
<h2><a name="variable_names"></a>Variable Names</h2>
<div class="guidelineDetails">
    <p>
        The guidelines for variable naming is very similar to that used for class methods.  Namely, variables should contain only lowercase letters, use underscore separators, and be reasonably named to indicate their purpose and contents. Very short, non-word variables should only be used as iterators in for() loops.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        $j = &apos;foo&apos;;		// single letter variables should only be used in for() loops
        $Str			// contains uppercase letters
        $bufferedText		// uses CamelCasing, and could be shortened without losing semantic meaning
        $groupid		// multiple words, needs underscore separator
        $name_of_last_city_used	// too long
		<br /><strong>CORRECT</strong>:
        for ($j = 0; $j &lt; 10; $j++)
        $str
        $buffer
        $group_id
        $last_city
    </code>
</div>
<h2><a name="commenting"></a>Commenting</h2>
<div class="guidelineDetails">
    <p>
        In general, code should be commented prolifically.  It not only helps describe the flow and intent of the code for less experienced programmers, but can prove invaluable when returning to your own code months down the line.  There is not a required format for comments, but the following are recommended.
    </p>
    <p>
        <a href="http://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_phpDocumentor.howto.pkg.html#basics.docblock">DocBlock</a>
        style comments preceding class and method declarations so they can be picked up by IDEs:
    </p>
    <code>
        /**
        * Super Class
        *
        * @package	Package Name
        * @subpackage	Subpackage
        * @category	Category
        * @author	Author Name
        * @link	http://example.com
        */
        class Super_class {
    </code>
    <code>
        /**
        * Encodes string for use in XML
        *
        * @access	public
        * @param	string
        * @return	string
        */
        function xml_encode($str)
    </code>
    <p>
        Use single line comments within code, leaving a blank line between large comment blocks and code.
    </p>
    <code>
        // break up the string by newlines
        $parts = explode("\n", $str);
        // A longer comment that needs to give greater detail on what is
        // occurring and why can use multiple single-line comments.  Try to
        // keep the width reasonable, around 70 characters is the easiest to
        // read.  Don't hesitate to link to permanent external resources
        // that may provide greater detail:
        //
        // http://example.com/information_about_something/in_particular/
        $parts = $this->foo($parts);
    </code>
</div>
<h2><a name="constants"></a>Constants</h2>
<div class="guidelineDetails">
    <p>
        Constants follow the same guidelines as do variables, except constants should always be fully uppercase. <em>Always use ExpressionEngine constants when appropriate, i.e. SLASH, LD, RD, PATH_CACHE, etc.</em>
    </p>
    <code>
        <strong>INCORRECT</strong>:
        myConstant	// missing underscore separator and not fully uppercase
        N		// no single-letter constants
        S_C_VER		// not descriptive
        $str = str_replace('{foo}', 'bar', $str);	// should use LD and RD constants
		<br /><strong>CORRECT</strong>:
        MY_CONSTANT
        NEWLINE
        SUPER_CLASS_VERSION
        $str = str_replace(LD.'foo'.RD, 'bar', $str);
    </code>
</div>
<h2><a name="true_false_and_null"></a>TRUE, FALSE, and NULL</h2>
<div class="guidelineDetails">
    <p>
        <strong>TRUE</strong>, <strong>FALSE</strong>, and <strong>NULL</strong>
        keywords should always be fully uppercase.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        if ($foo == true)
        $bar = false;
        function foo($bar = null)
		<br /><strong>CORRECT</strong>:
        if ($foo == TRUE)
        $bar = FALSE;
        function foo($bar = NULL)
    </code>
</div>
<h2><a name="logical_operators"></a>Logical Operators</h2>
<div class="guidelineDetails">
    <p>
        Use of <strong>||</strong>
        is discouraged as its clarity on some output devices is low (looking like the number 11 for instance).<strong>&amp;&amp;</strong>
        is preferred over <strong>AND</strong>
        but either are acceptable, and a space should always precede and follow <strong>!</strong>.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        if ($foo || $bar)
        if ($foo AND $bar)  // okay but not recommended for common syntax highlighting applications
        if (!$foo)
        if (! is_array($foo))
		<br /><strong>CORRECT</strong>:
        if ($foo OR $bar)
        if ($foo && $bar) // recommended
        if ( ! $foo)
        if ( ! is_array($foo))
    </code>
</div>
<h2><a name="comparing_return_values_and_typecasting"></a>Comparing Return Values and Typecasting</h2>
<div class="guidelineDetails">
    <p>
        Some PHP functions return FALSE on failure, but may also have a valid return value of "" or 0, which would evaluate to FALSE in loose comparisons.  Be explicit by comparing the variable type when using these return values in conditionals to ensure the return value is indeed what you expect, and not a value that has an equivalent loose-type evaluation.
    </p>
    <p>
    Use the same stringency in returning and checking your own variables.  Use <strong>===</strong>
    and <strong>!==</strong>
    as necessary.
    <code>
        <strong>INCORRECT</strong>:
        // If 'foo' is at the beginning of the string, strpos will return a 0,
        // resulting in this conditional evaluating as TRUE
        if (strpos($str, 'foo') == FALSE)
		<br /><strong>CORRECT</strong>:
        if (strpos($str, 'foo') === FALSE)
    </code>
    <code>
        <strong>INCORRECT</strong>:
        function build_string($str = "")
        {
        if ($str == "")	// uh-oh!  What if FALSE or the integer 0 is passed as an argument?
        {
        }
        }<br /><strong>CORRECT</strong>:
        function build_string($str = "")
        {
        if ($str === "")
        {
        }
        }
    </code>
    <p>
        See also information regarding <a href="http://us3.php.net/manual/en/language.types.type-juggling.php#language.types.typecasting">typecasting</a>, which can be quite useful.  Typecasting has a slightly different effect which may be desirable.  When casting a variable as a string, for instance, NULL and boolean FALSE variables become empty strings, 0 (and other numbers) become strings of digits, and boolean TRUE becomes "1":
    </p>
    <code>
        $str = (string) $str;	// cast $str as a string
    </code>
</div>
<h2><a name="debugging_code"></a>Debugging Code</h2>
<div class="guidelineDetails">
    <p>
        No debugging code can be left in place for submitted add-ons unless it is commented out, i.e. no var_dump(), print_r(), die(), and exit() calls that were used while creating the add-on, unless they are commented out.
    </p>
    <code>
        // print_r($foo);
    </code>
</div>
<h2><a name="whitespace_in_files"></a>Whitespace in Files</h2>
<div class="guidelineDetails">
    <p>
        No whitespace can precede the opening PHP tag or follow the closing PHP tag.  ExpressionEngine output is buffered, so whitespace in your files can cause output to begin before ExpressionEngine outputs its content, leading to errors and an inability for ExpressionEngine to send proper headers.  In the examples below, select the text with your mouse to reveal the incorrect whitespace.
    </p>
    <p>
        <strong>INCORRECT</strong>:
    </p>
    <code>
        &lt;?php
        // ...there is whitespace and a linebreak above the opening PHP tag
        // as well as whitespace after the closing PHP tag 
        ?&gt; 
    </code>
    <p>
        <strong>CORRECT</strong>:
    </p>
    <code>
        &lt;?php
        // this sample has no whitespace before or after the opening and closing PHP tags
        ?&gt;
    </code>
</div>
<h2><a name="compatibility"></a>Compatibility</h2>
<div class="guidelineDetails">
    <p>
        Unless specifically mentioned in your add-on's documentation, all code must be compatible with PHP version 4.3+.  Additionally, do not use PHP functions that require non-default libraries to be installed unless your code contains an alternative method when the function is not available, or you implicitly document that your add-on requires said PHP libraries.
    </p>
</div>
<h2><a name="class_and_file_names_using_common_words"></a>Class and File Names using Common Words</h2>
<div class="guidelineDetails">
    <p>
        When your class or filename is a common word, or might quite likely be identically named in another PHP script, provide a unique prefix to help prevent collision.  Always realize that your end users may be running other add-ons or third party PHP scripts.  Choose a prefix that is unique to your identity as a developer or company.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        class Email		pi.email.php
        class Xml		ext.xml.php
        class Import		mod.import.php
		<br /><strong>CORRECT</strong>:
        class Pre_email		pi.pre_email.php
        class Pre_xml		ext.pre_xml.php
        class Pre_import	mod.pre_import.php
    </code>
</div>
<h2><a name="database_table_names"></a>Database Table Names</h2>
<div class="guidelineDetails">
    <p>
        Any tables that your add-on might use must use the 'exp_' prefix, followed by a prefix uniquely identifying you as the developer or company, and then a short descriptive table name.  You do not need to be concerned about the database prefix being used on the user's installation, as ExpressionEngine's database class will automatically convert 'exp_' to what is actually being used.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        email_addresses		// missing both prefixes
        pre_email_addresses	// missing exp_ prefix
        exp_email_addresses	// missing unique prefix
		<br /><strong>CORRECT</strong>:
        exp_pre_email_addresses
    </code>
    <p class="important">
    <strong>NOTE:</strong>
    Be mindful that MySQL has a limit of 64 characters for table names.  This should not be an issue as table names that would exceed this would likely have unreasonable names.  For instance, the following table name exceeds this limitation by one character.  Silly, no? <strong>exp_pre_email_addresses_of_registered_users_in_seattle_washington</strong>
</div>
<h2><a name="one_file_per_class"></a>One File per Class</h2>
<div class="guidelineDetails">
    <p>
        Use separate files for each class your add-on uses, unless the classes are <em>closely related</em>.  An example of ExpressionEngine files that contains multiple classes is the Database class file, which contains both the DB class and the DB_Cache class, and the Magpie plugin, which contains both the Magpie and Snoopy classes.
    </p>
</div>
<h2><a name="whitespace"></a>Whitespace</h2>
<div class="guidelineDetails">
    <p>
        Use tabs for whitespace in your code, not spaces.  This may seem like a small thing, but using tabs instead of whitespace allows the developer looking at your code to have indentation at levels that they prefer and customize in whatever application they use.  And as a side benefit, it results in (slightly) more compact files, storing one tab character versus, say, four space characters.
    </p>
</div>
<h2><a name="line_breaks"></a>Line Breaks</h2>
<div class="guidelineDetails">
    <p>
        Files must be saved with Unix line breaks.  This is more of an issue for developers who work in Windows, but in any case ensure that your text editor is setup to save files with Unix line breaks.
    </p>
</div>
<h2><a name="code_indenting"></a>Code Indenting</h2>
<div class="guidelineDetails">
    <p>
        Use Allman style indenting.  With the exception of Class declarations, braces are always placed on a line by themselves, and indented at the same level as the control statement that "owns" them.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        function foo($bar) {
        // ...
        }
        foreach ($arr as $key => $val) {
        // ...
        }
        if ($foo == $bar) {
        // ...
        } else {
        // ...
        }
        for ($i = 0; $i &lt; 10; $i++)
        {
        for ($j = 0; $j &lt; 10; $j++)
        {
        // ...
        }
        }<br /><strong>CORRECT</strong>:
        function foo($bar)
        {
        // ...
        }
        foreach ($arr as $key => $val)
        {
        // ...
        }
        if ($foo == $bar)
        {
        // ...
        }
        else
        {
        // ...
        }
        for ($i = 0; $i &lt; 10; $i++)
        {
        for ($j = 0; $j &lt; 10; $j++)
        {
        // ...
        }
        }
    </code>
</div>
<h2><a name="bracket_spacing"></a>Bracket and Parenthetic Spacing</h2>
<div class="guidelineDetails">
    <p>
        In general, parenthesis and brackets should not use any additional spaces.  The exception is that a space should always follow PHP control structures that accept arguments with parenthesis (declare, do-while, elseif, for, foreach, if, switch, while), to help distinguish them from functions and increase readability.
    </p>
    <code>
        INCORRECT:
        $arr[ $foo ] = 'foo';
        <br />CORRECT:
        $arr[$foo] = 'foo'; // no spaces around array keys
        <br />INCORRECT:
        function foo ( $bar )
        {
        }
        <br />CORRECT:
        function foo($bar) // no spaces around parenthesis in function declarations
        {
        }
        <br />INCORRECT:
        foreach( $query->result() as $row )
        <br />CORRECT:
        foreach ($query->result() as $row) // single space following PHP control structures, but not in interior parenthesis
    </code>
</div>
<h2><a name="localized_text_in_control_panel"></a>Localized Text in Control Panel</h2>
<div class="guidelineDetails">
    <p>
        Any text that is output in the control panel should use language variables in your module's lang file to allow localization.
    </p>
    <code>
        INCORRECT:
        return "Invalid Selection";
        <br />CORRECT:
        return $LANG->line('invalid_selection');
    </code>
</div>
<h2><a name="private_methods_and_variables"></a>Private Methods and Variables</h2>
<div class="guidelineDetails">
    <p>
        Methods and variables that are only accessed internally by your class, such as utility and helper functions that your public methods use for code abstraction, should be prefixed with an underscore.
    </p>
    <code>
        convert_text()		// public method
        _convert_text()		// private method
    </code>
</div>
<h2><a name="php_errors"></a>PHP Errors</h2>
<div class="guidelineDetails">
    <p>
        Code must run error free and not rely on warnings and notices to be hidden to meet this requirement.  For instance, never access a variable that you did not set yourself (such as $_POST array keys) without first checking to see that it isset().
    </p>
    <p>
        Make sure that while developing your add-on, error reporting is enabled for ALL users, and that display_errors is enabled in the PHP environment.  You can check this setting with:
    </p>
    <code>
        if (ini_get('display_errors') == 1)
        {
        exit "Enabled";
        }
    </code>
    <p>
        On some servers where display_errors is disabled, and you do not have the ability to change this in the php.ini, you can often enable it with:
    </p>
    <code>
        ini_set('display_errors', 1);
    </code>
    <p class="important">
        <strong>NOTE:</strong>
        Setting the <a href="http://us.php.net/manual/en/ref.errorfunc.php#ini.display-errors">display_errors</a>
        setting with ini_set() at runtime is not identical to having it enabled in the PHP environment.  Namely, it will not have any effect if the script has fatal errors
    </p>
</div>
<h2><a name="short_open_tags"></a>Short Open Tags</h2>
<div class="guidelineDetails">
    <p>
        Always use full PHP opening tags, in case a server does not have short_open_tag enabled.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        &lt;? echo $foo; ?&gt;
        &lt;?=$foo?&gt;
		<br /><strong>CORRECT</strong>:
        &lt;?php echo $foo; ?&gt;
    </code>
</div>
<h2><a name="one_statement_per_line"></a>One Statement Per Line</h2>
<div class="guidelineDetails">
    <p>
        Never combine statements on one line.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        $foo = 'this'; $bar = 'that'; $bat = str_replace($foo, $bar, $bag);
		<br /><strong>CORRECT</strong>:
        $foo = 'this';
        $bar = 'that';
        $bat = str_replace($foo, $bar, $bag);
    </code>
</div>
<h2><a name="strings"></a>Strings</h2>
<div class="guidelineDetails">
    <p>
        Always use single quoted strings unless you need variables parsed, and in cases where you do need variables parsed, use braces to prevent greedy token parsing.  You may also use double-quoted strings if the string contains single quotes, so you do not have to use escape characters.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        "My String"					// no variable parsing, so no use for double quotes
        "My string $foo"				// needs braces
        'SELECT foo FROM bar WHERE baz = \'bag\''	// ugly
		<br /><strong>CORRECT</strong>:
        'My String'
        "My string {$foo}"
        "SELECT foo FROM bar WHERE baz = 'bag'"
    </code>
</div>
<h2><a name="sql_queries"></a>SQL Queries</h2>
<div class="guidelineDetails">
    <p>
        MySQL keywords are always capitalized: SELECT, INSERT, UPDATE, WHERE, AS, JOIN, ON, IN, etc.
    </p>
    <p>
        Break up long queries into multiple lines for legibility, preferably breaking for each clause.
    </p>
    <code>
        <strong>INCORRECT</strong>:
        // keywords are lowercase and query is too long for
        // a single line (... indicates continuation of line)
        $query = $this->db->query("select foo, bar, baz, foofoo, foobar as raboof, foobaz from exp_pre_email_addresses
        ...where foo != 'oof' and baz != 'zab' order by foobaz limit 5, 100");
		<br /><strong>CORRECT</strong>:
        $query = $this->db->query("SELECT foo, bar, baz, foofoo, foobar AS raboof, foobaz
        FROM exp_pre_email_addresses
        WHERE foo != 'oof'
        AND baz != 'zab'
        ORDER BY foobaz
        LIMIT 5, 100");
    </code>
</div>
<h2><a name="default_function_arguments"></a>Default Function Arguments</h2>
<div class="guidelineDetails">
    <p>
        Whenever appropriate, provide function argument defaults, which helps prevent PHP errors with mistaken calls and provides common fallback values which can save a few lines of code. Example:
    </p>
    <code>
        function foo($bar = '', $baz = FALSE)
    </code>
</div>
<h2><a name="overlapping_tag_parameters"></a>Overlapping Tag Parameters</h2>
<div class="guidelineDetails">
    <p>
        Avoid multiple tag parameters that have effect on the same thing.  For instance, instead of <strong>include=</strong>
        and <strong>exclude=</strong>, perhaps allow <strong>include=</strong>
        to handle the parameter alone, with the addition of "not", e.g. <strong>include="not bar"</strong>.  This will prevent problems of parameters overlapping or having to worry about which parameter has priority over another.
    </p>
</div>
</div>
