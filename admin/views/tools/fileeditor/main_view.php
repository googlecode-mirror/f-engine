<h2><a href="<?php echo site_url();?>tools/fileeditor">File editor</a></h2>
<form action="<?php  echo site_url();?>tools/fileeditor/save" method="post">
    <div id="tree">
        <div id="javascript" class="rblock floatl">
            <div id="js_list" class="dir">
            </div>
        </div>
        <textarea id="editor" name="edit_1"></textarea>
    </div>
</form>

<ul id="fileMenu" class="contextMenu" style="width:auto;">
    <li class="edit">
        <a href="#rename">Rename</a>
    </li>
    <li class="cut">
        <a href="#cut">Cut</a>
    </li>
    <li class="copy">
        <a href="#copy">Copy</a>
    </li>
    <li class="paste oculto">
        <a href="#paste">Paste</a>
    </li>
    <li class="delete">
        <a href="#delete">Delete</a>
    </li>
    <li class="quit separator">
        <a href="#quit">Quit</a>
    </li>
</ul>

<ul id="dirMenu" class="contextMenu" style="width:auto;">
    <li class="refresh">
        <a href="#refresh">Refresh</a>
    </li>
    <li class="edit">
        <a href="#rename">Rename</a>
    </li>
    <li class="file">
        <a href="#file">New file</a>
    </li>
    <li class="folder">
        <a href="#folder">New folder</a>
    </li>
    <li class="paste oculto">
        <a href="#paste">Paste</a>
    </li>
    <li class="quit separator">
        <a href="#quit">Quit</a>
    </li>
</ul>
