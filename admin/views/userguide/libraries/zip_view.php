<h1>Zip Encoding Class</h1>
<p>
    F-engine's Zip Encoding Class classes permit you to create Zip archives. Archives can be downloaded to your
    desktop or saved to a directory.
</p>
<h2>Initializing the Class</h2>
<p>
    Like most other classes in F-engine, the Zip class is initialized in your controller using the 
    <dfn>
        $this->load->library
    </dfn>
    function:
</p>
<code>
    $this->load->library('zip');
</code>
<p>
    Once loaded, the Zip library object will be available using: 
    <dfn>
        $this->zip
    </dfn>
</p>
<h2>Usage Example</h2>
<p>
    This example demonstrates how to compress a file, save it to a folder on your server, and download it to your desktop.
</p>
<code>
    $name = 'mydata1.txt';
    <br/>
    $data = 'A Data String!';
    <br/>
    <br/>
    $this->zip->add_data($name, $data);
    <br/>
    <br/>
    // Write the zip file to a folder on your server. Name it "my_backup.zip"
    <br/>
    $this->zip->archive('/path/to/directory/my_backup.zip');
    <br/>
    <br/>
    // Download the file to your desktop.  Name it "my_backup.zip"
    <br/>
    $this->zip->download('my_backup.zip');
</code>
<h1>Function Reference</h1>
<h2>$this->zip->add_data()</h2>
<p>
    Permits you to add data to the Zip archive. The first parameter must contain the name you would like
    given to the file, the second parameter must contain the file data as a string:
</p>
<code>
    $name = 'my_bio.txt';
    <br/>
    $data = 'I was born in an elevator...';
    <br/>
    <br/>
    $this->zip->add_data($name, $data);
</code>
<p>
    You are allowed multiple calls to this function in order to
    add several files to your archive.  Example:
</p>
<code>
    $name = 'mydata1.txt';
    <br/>
    $data = 'A Data String!';
    <br/>
    $this->zip->add_data($name, $data);
    <br/>
    <br/>
    $name = 'mydata2.txt';
    <br/>
    $data = 'Another Data String!';
    <br/>
    $this->zip->add_data($name, $data);
    <br/>
</code>
<p>
    Or you can pass multiple files using an array:
</p>
<code>
    $data = array(
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'mydata1.txt' => 'A Data String!',
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'mydata2.txt' => 'Another Data String!'
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
    <br/>
    <br/>
    $this->zip->add_data($data);
    <br/>
    <br/>
    $this->zip->download('my_backup.zip');
</code>
<p>
    If you would like your compressed data organized into sub-folders, include the path as part of the filename:
</p>
<code>
    $name = '
    <kbd>
        personal/
    </kbd>my_bio.txt';
    <br/>
    $data = 'I was born in an elevator...';
    <br/>
    <br/>
    $this->zip->add_data($name, $data);
</code>
<p>
    The above example will place 
    <dfn>
        my_bio.txt
    </dfn>
    inside a folder called 
    <kbd>
        personal
    </kbd>.
</p>
<h2>$this->zip->add_dir()</h2>
<p>
    Permits you to add a directory.  Usually this function is unnecessary since you can place your data into folders when 
    using 
    <dfn>
        $this->zip->add_data()
    </dfn>, but if you would like to create an empty folder you can do so.  Example:
</p>
<code>
    $this->zip->add_dir('myfolder'); // Creates a folder called "myfolder"
</code>
<h2>$this->zip->read_file()</h2>
<p>
    Permits you to compress a file that already exists somewhere on your server.  Supply a file path and the zip class will
    read it and add it to the archive:
</p>
<code>
    $path = '/path/to/photo.jpg';
    <br/>
    <br/>
    $this->zip->read_file($path);
    <br/>
    <br/>
    // Download the file to your desktop.  Name it "my_backup.zip"
    <br/>
    $this->zip->download('my_backup.zip');
</code>
<p>
    If you would like the Zip archive to maintain the directory structure of the file in it, pass 
    <kbd>
        TRUE
    </kbd>
    (boolean) in the
    second parameter.  Example:
</p>
<code>
    $path = '/path/to/photo.jpg';
    <br/>
    <br/>
    $this->zip->read_file($path, 
    <kbd>
        TRUE
    </kbd>);
    <br/>
    <br/>
    // Download the file to your desktop.  Name it "my_backup.zip"
    <br/>
    $this->zip->download('my_backup.zip');
</code>
<p>
    In the above example, 
    <dfn>
        photo.jpg
    </dfn>
    will be placed inside two folders: 
    <kbd>
        path/to/
    </kbd>
</p>
<h2>$this->zip->read_dir()</h2>
<p>
    Permits you to compress a folder (and its contents) that already exists somewhere on your server.  Supply a file path to the 
    directory and the zip class will recursively read it and recreate it as a Zip archive.  All files contained within the
    supplied path will be encoded, as will any sub-folders contained within it.  Example:
</p>
<code>
    $path = '/path/to/your/directory/';
    <br/>
    <br/>
    $this->zip->read_dir($path);
    <br/>
    <br/>
    // Download the file to your desktop.  Name it "my_backup.zip"
    <br/>
    $this->zip->download('my_backup.zip');
</code>
<h2>$this->zip->archive()</h2>
<p>
    Writes the Zip-encoded file to a directory on your server.  Submit a valid server path ending in the file name.  Make sure the
    directory is writable (666 or 777 is usually OK). Example:
</p>
<code>
    $this->zip->archive('/path/to/folder/myarchive.zip'); // Creates a file named myarchive.zip
</code>
<h2>$this->zip->download()</h2>
<p>
    Causes the Zip file to be downloaded from your server. The function must be passed the name you would like the zip file called.
    Example:
</p>
<code>
    $this->zip->download('latest_stuff.zip'); // File will be named "latest_stuff.zip"
</code>
<p class="important">
    <strong>Note:</strong>&nbsp; Do not display any data in the controller in which you call this function since it sends various server headers
    that cause the download to happen and the file to be treated as binary.
</p>
<h2>$this->zip->get_zip()</h2>
<p>
    Returns the Zip-compressed file data.  Generally you will not need this function unless you want to do something unique with the data.
    Example:
</p>
<code>
    $name = 'my_bio.txt';
    <br/>
    $data = 'I was born in an elevator...';
    <br/>
    <br/>
    $this->zip->add_data($name, $data);
    <br/>
    <br/>
    $zip_file = $this->zip->get_zip();
</code>
<h2>$this->zip->clear_data()</h2>
<p>
    The Zip class caches your zip data so that it doesn't need to recompile the Zip archive for each function you use above.
    If, however, you need to create multiple Zips, each with different data, you can clear the cache between calls. Example:
</p>
<code>
    $name = 'my_bio.txt';
    <br/>
    $data = 'I was born in an elevator...';
    <br/>
    <br/>
    $this->zip->add_data($name, $data);
    <br/>
    $zip_file = $this->zip->get_zip();
    <br/>
    <br/>
    <kbd>
        $this->zip->clear_data();
    </kbd>
    <br/>
    <br/>
    $name = 'photo.jpg';
    <br/>
    $this->zip->read_file("/path/to/photo.jpg"); // Read the file's contents
    <br/>
    <br/>
    <br/>
    $this->zip->download('myphotos.zip');
</code>
