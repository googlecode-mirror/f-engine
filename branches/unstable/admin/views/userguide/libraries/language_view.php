<h1>Language Class</h1>
<p>
    The Language Class provides functions to retrieve language files and lines of text for purposes of internationalization.
</p>
<p>
    In your F-engine system folder you'll find one called 
    <dfn>
        language
    </dfn>
    containing sets of language files.  You can create
    your own language files as needed in order to display error and other messages in other languages.
</p>
<p>
    Language files are typically stored in your 
    <dfn>
        system/language
    </dfn>
    directory.  Alternately you can create a folder called 
    <kbd>
        language
    </kbd>
    inside 
    your 
    <kbd>
        application
    </kbd>
    folder and store them there.  F-engine will look first in your 
    <dfn>
        system/application/language
    </dfn>
    directory.  If the directory does not exist or the specified language is not located there CI will instead look in your global
    <dfn>
        system/language
    </dfn>
    folder.
</p>
<p class="important">
    <strong>Note:</strong>&nbsp; Each language should be stored in its own folder.  For example, the English files are located at:
    <dfn>
        system/language/english
    </dfn>
</p>
<h2>Creating Language Files</h2>
<p>
    Language files must be named with 
    <kbd>
        _lang.php
    </kbd>
    as the file extension.  For example, let's say you want to create a file 
    containing error messages.  You might name it: 
    <kbd>
        error_lang.php
    </kbd>
</p>
<p>
    Within the file you will assign each line of text to an array called 
    <var>
        $lang
    </var>
    with this prototype:
</p>
<code>
    $lang['language_key'] = "The actual message to be shown";
</code>
<p>
    <strong>Note:</strong>
    It's a good practice to use a common prefix for all messages in a given file to avoid collisions with 
    similarly named items in other files.  For example, if you are creating error messages you might prefix them with 
    <var>
        error_
    </var>
</p>
<code>
    $lang['
    <var>
        error
    </var>_email_missing'] = "You must submit an email address";
    <br/>
    $lang['
    <var>
        error
    </var>_url_missing'] = "You must submit a URL";
    <br/>
    $lang['
    <var>
        error
    </var>_username_missing'] = "You must submit a username";
</code>
<h2>Loading A Language File</h2>
<p>
    In order to fetch a line from a particular file you must load the file first.  Loading a language file is done with the following code:
</p>
<code>
    $this->lang->load('
    <samp>
        filename
    </samp>', '
    <dfn>
        language
    </dfn>');
</code>
<p>
    Where 
    <samp>
        filename
    </samp>
    is the name of the file you wish to load (without the file extension), and 
    <dfn>
        language
    </dfn>
    is the language set containing it (ie, english).  If the second parameter is missing, the default language set in your
    <kbd>
        application/config/config.php
    </kbd>
    file will be used.
</p>
<h2>Fetching a Line of Text</h2>
<p>
    Once your desired language file is loaded you can access any line of text using this function:
</p>
<code>
    $this->lang->line('
    <samp>
        language_key
    </samp>');
</code>
<p>
    Where 
    <samp>
        language_key
    </samp>
    is the array key corresponding to the line you wish to show.
</p>
<p>
    Note: This function simply returns the line.  It does not echo it for you.
</p>
<h3>Using language lines as form labels</h3>
<p class="important">
    This feature has been deprecated from the language library and moved to the 
    <kbd>
        lang()
    </kbd>
    function of the <a href="<?php echo site_url();?>userguide/helpers/language_helper">Language helper</a>.
</p>
<h2>Auto-loading Languages</h2>
<p>
    If you find that you need a particular language globally throughout your application, you can tell F-engine to <a href="../general/autoloader.html">auto-load</a>
    it during system initialization. This is done by opening the application/config/autoload.php file and adding the language(s) to the autoload array.
</p>
<p>
    &nbsp;
</p>
