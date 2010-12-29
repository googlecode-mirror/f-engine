<h2>Javascript packer</h2>
<form method="post" action="" id="form" class="">
    <p>
        <label class="paste">
            Paste:
        </label>
        <br/>
        <textarea cols="80" rows="10" name="input" id="input" spellcheck="false"></textarea>
    </p>
    <p id="controls">
        <label for="base62">
            Base62 encode<input type="checkbox" class="checkbox" value="1" name="base62" id="base62"/>
        </label>
        <br/>
        <label for="shrink">
            Shrink variables<input type="checkbox" class="checkbox" value="1" name="shrink" id="shrink"/>
        </label>
    </p>
    <p id="input-buttons" class="form-buttons">
        <input type="file" disabled="disabled" name="upload" id="upload-script"/>
        <button id="load-script" type="button">
            Load
        </button>
        <button id="clear-all" type="button">
            Clear
        </button>
        <button id="pack-script" type="button">
            Pack
        </button>
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
    <p id="output-buttons" class="form-buttons">
        <button id="save-script" type="submit">
            Save
        </button>
        <button id="decode-script" type="button">
            Decode
        </button>
    </p>
    <fieldset class="hidden" style="display:none;">
        <input type="hidden" value="" name="command"/><input type="hidden" value="" name="filename"/><input type="hidden" value="" name="filetype"/>
    </fieldset>
</form>