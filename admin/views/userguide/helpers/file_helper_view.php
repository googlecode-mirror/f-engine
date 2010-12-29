<h1>File Helper</h1>
<p>
    The File Helper file contains functions that assist in working with files.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('file');
</code>
<p>
    The following functions are available:
</p>
<h2>read_file('
    <var>
        path
    </var>')
</h2>
<p>
    Returns the data contained in the file specified in the path.  Example:
</p>
<code>
    $string = read_file('./path/to/file.php');
</code>
<p>
    The path can be a relative or full server path.  Returns FALSE (boolean) on failure.
</p>
<p class="important">
    <strong>Note:</strong>
    The path is relative to your main site index.php file, NOT your controller or view files.
    F-engine uses a front controller so paths are always relative to the main site index.
</p>
<p>
    If your server is running an open_basedir restriction this function
    might not work if you are trying to access a file above the calling script.
</p>
<h2>write_file('
    <var>
        path
    </var>', 
    <kbd>
        $data
    </kbd>)
</h2>
<p>
    Writes data to the file specified in the path.  If the file does not exist the function will create it. Example:
</p>
<code>
    $data = 'Some file data';
    <br/>
    <br/>
    if ( ! write_file('./path/to/file.php', $data))
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; echo 'Unable to write the file';
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp; echo 'File written!';
    <br/>
    }
</code>
<p>
    You can optionally set the write mode via the third parameter:
</p>
<code>
    write_file('./path/to/file.php', $data, 
    <var>
        'r+'
    </var>);
</code>
<p>
    The default mode is 
    <kbd>
        wb
    </kbd>.  Please see the <a href="http://php.net/fopen">PHP user guide</a>
    for mode options.
</p>
<p>
    Note: In order for this function to write data to a file its file permissions must be set such that it is writable (666, 777, etc.).
    If the file does not already exist, the directory containing it must be writable.
</p>
<p class="important">
    <strong>Note:</strong>
    The path is relative to your main site index.php file, NOT your controller or view files.
    F-engine uses a front controller so paths are always relative to the main site index.
</p>
<h2>delete_files('
    <var>
        path
    </var>')
</h2>
<p>
    Deletes ALL files contained in the supplied path.  Example:
</p>
<code>
    delete_files('./path/to/directory/');
</code>
<p>
    If the second parameter is set to 
    <kbd>
        true
    </kbd>, any directories contained within the supplied root path will be deleted as well. Example:
</p>
<code>
    delete_files('./path/to/directory/', TRUE);
</code>
<p class="important">
    <strong>Note:</strong>
    The files must be writable or owned by the system in order to be deleted.
</p>
<h2>get_filenames('
    <var>
        path/to/directory/
    </var>')
</h2>
<p>
    Takes a server path as input and returns an array containing the names of all files contained within it. The file path
    can optionally be added to the file names by setting the second parameter to TRUE.
</p>
<h2>get_dir_file_info('
    <var>
        path/to/directory/
    </var>')
</h2>
<p>
    Reads the specified directory and builds an array containing the filenames, filesize, dates, and permissions.  Any sub-folders contained within the specified path are read as well.
</p>
<h2>get_file_info('
    <var>
        path/to/file
    </var>', 
    <kbd>
        $file_information
    </kbd>)
</h2>
<p>
    Given a file and path, returns the name, path, size, date modified. Second parameter allows you to explicitly declare what information you want returned; options are: name, server_path, size, date, readable, writable, executable, fileperms.  Returns FALSE if the file cannot be found.
</p>
<p class="important">
    <strong>Note:</strong>
    The &quot;writable&quot; uses the PHP function is_writable() which is known to have issues on the IIS webserver. Consider using fileperms instead, which returns information from PHP's fileperms() function.
</p>
<h2>get_mime_by_extension('
    <var>
        file
    </var>')
</h2>
<p>
    Translates a file extension into a mime type based on config/mimes.php. Returns FALSE if it can't determine the type, or open the mime config file.
</p>
<p>
    <code>
        $file = &quot;somefile.png&quot;;
        <br/>
        echo $file . ' is has a mime type of ' . get_mime_by_extension($file);
    </code>
</p>
<p class="critical">
    <strong>Note:</strong>
    This is not an accurate way of determining file mime types, and is here strictly as a convenience. It should not be  used for security.
</p>
<h2>symbolic_permissions(
    <kbd>
        $perms
    </kbd>)
</h2>
<p>
    Takes numeric permissions (such as is returned by 
    <kbd>
        fileperms()
    </kbd>
    and returns standard symbolic notation of file permissions.
</p>
<code>
    echo symbolic_permissions(fileperms('./index.php'));
    <br/>
    <br/>
    // -rw-r--r--
</code>
<h2>octal_permissions(
    <kbd>
        $perms
    </kbd>)
</h2>
<p>
    Takes numeric permissions (such as is returned by 
    <kbd>
        fileperms()
    </kbd>
    and returns a three character octal notation of file permissions.
</p>
<code>
    echo octal_permissions(fileperms('./index.php'));
    <br/>
    <br/>
    // 644
</code>
</div>
