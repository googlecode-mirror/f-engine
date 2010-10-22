<h1>Download Helper</h1>
<p>
    The Download Helper lets you download data to your desktop.
</p>
<h2>Loading this Helper</h2>
<p>
    This helper is loaded using the following code:
</p>
<code>
    $this->load->helper('download');
</code>
<p>
    The following functions are available:
</p>
<h2>force_download('
    <var>
        filename
    </var>', '
    <var>
        data
    </var>')
</h2>
<p>
    Generates server headers which force data to be downloaded to your desktop. Useful with file downloads. 
    The first parameter is the <strong>name you want the downloaded file to be named</strong>, the second parameter is the file data.
    Example:
</p>
<code>
    $data = 'Here is some text!';
    <br/>
    $name = 'mytext.txt';
    <br/>
    <br/>
    force_download($name, $data);
</code>
<p>
    If you want to download an existing file from your server you'll need to read the file into a string:
</p>
<code>
    $data = file_get_contents("/path/to/photo.jpg"); // Read the file's contents
    <br/>
    $name = 'myphoto.jpg';
    <br/>
    <br/>
    force_download($name, $data);
</code>
