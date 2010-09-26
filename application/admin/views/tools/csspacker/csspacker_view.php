<h2>Css minifier</h2>
<form method="post" action="<?php  echo site_url();?>tools/csspacker/minify" id="form">
    <p>
        <label class="paste">
            Paste:
        </label>
        <br/>
        <textarea cols="80" rows="10" name="css" id="input" spellcheck="false"></textarea>
    </p>
    <p id="input-buttons" class="form-buttons">
        <input type="file" disabled="disabled" name="upload" id="upload-script"/>
        <button id="load-script" type="button">
            Load
        </button>
        <input id="clear-all" type="button" value="Clear" />
        <input id="pack-script" type="button" value="Pack" >
    </p>
    <p>
        <label class="copy">
            Copy:
        </label>
        <textarea readonly="readonly" cols="80" rows="10" name="output" id="output" spellcheck="false"></textarea>
    </p>
    <p class="" id="message">
        ready
    </p>
    <fieldset class="hidden" style="display:none;">
        <input type="hidden" value="" name="command"/><input type="hidden" value="" name="filename"/><input type="hidden" value="" name="filetype"/>
    </fieldset>
</form>