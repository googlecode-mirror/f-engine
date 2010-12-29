    <form method="post" action="<?php  echo site_url();?>tools/dbmanager/ajax/altertable/updatefield" >
    <input type="hidden" name="tablename" value="<?php  echo $_POST['tablename']?>" />
    <input type="hidden" name="tablefield" value="<?php  echo $_POST['field']?>" />
    <table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
        <tbody>
            <tr>
                <th>
                    Field name
                </th>
                <td>
                    <input name="fname" type="text" value="<?php echo $fieldname?>" />
                </td>
            </tr>
            <tr>
                <th>
                    Type
                </th>
                <td>
                    <select name="ftype" style="width:185px">
                        <optgroup title="Numeric" label="Numeric">
                            <option value="TINYINT" rel="Numeric" <?php if ($type == "tinyint") { ?> selected="selected" <?php } //endif ?>>TINYINT</option>
                            <option value="SMALLINT" rel="Numeric"<?php if($type == "smallint") { ?> selected="selected" <?php } //endif ?>>SMALLINT</option>
                            <option value="MEDIUMINT" rel="Numeric"<?php if($type == "mediumint") { ?> selected="selected" <?php } //endif ?>>MEDIUMINT</option>
                            <option value="INT" rel="Numeric"<?php if($type == "int") { ?> selected="selected" <?php } //endif ?>>INT</option>
                            <option value="BIGINT" rel="Numeric"<?php if($type == "bigint") { ?> selected="selected" <?php } //endif ?>>BIGINT</option>
                            <option value="DECIMAL" rel="Numeric"<?php if($type == "decimal") { ?> selected="selected" <?php } //endif ?>>DECIMAL</option>
                            <option value="FLOAT" rel="Numeric"<?php if($type == "float") { ?> selected="selected" <?php } //endif ?>>FLOAT</option>
                            <option value="DOUBLE" rel="Numeric"<?php if($type == "double") { ?> selected="selected" <?php } //endif ?>>DOUBLE</option>
                        </optgroup>
                        <optgroup title="String" label="String">
                            <option value="VARCHAR" rel="String"<?php if($type == "varchar") { ?> selected="selected" <?php } //endif ?>>VARCHAR</option>
                            <option value="TEXT" rel="String"<?php if($type == "text") { ?> selected="selected" <?php } //endif ?>>TEXT</option>
                            <option value="ENUM" rel="String"<?php if($type == "enum") { ?> selected="selected" <?php } //endif ?>>ENUM</option>
                        </optgroup>
                        <optgroup title="Time" label="Time">
                            <option value="TIME" rel="Time"<?php if($type == "time") { ?> selected="selected" <?php } //endif ?>>TIME</option>
                            <option value="TIMESTAMP" rel="Time"<?php if($type == "timestamp") { ?> selected="selected" <?php } //endif ?>>TIMESTAMP</option>
                        </optgroup>
                        <optgroup title="Date" label="Date">
                            <option value="DATE" rel="Date"<?php if($type == "date") { ?> selected="selected" <?php } //endif ?>>DATE</option>
                            <option value="DATETIME" rel="Date"<?php if($type == "datetime") { ?> selected="selected" <?php } //endif ?>>DATETIME</option>
                            <option value="YEAR" rel="Date"<?php if ($type == "year") { ?> selected="selected" <?php } //endif ?>>YEAR</option>
                        </optgroup>
                        <optgroup title="Other" label="Other">
                            <option value="BLOB" rel="Other"<?php if($type == "blob") { ?> selected="selected" <?php } //endif ?>>BLOB</option>
                            <option value="BIT" rel="Other"<?php if($type == "bit") { ?> selected="selected" <?php } //endif ?>>BIT</option>
                            <option value="BOOL" rel="Other"<?php if($type == "bool") { ?> selected="selected" <?php } //endif ?>>BOOL</option>
                            <option value="BINARY" rel="Other"<?php if($type == "bynary") { ?> selected="selected" <?php } //endif ?>>BINARY</option>
                            <option value="VARBINARY" rel="Other"<?php if($type == "varbinary") { ?> selected="selected" <?php } //endif ?>>VARBINARY</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    Long
                </th>
                <td>
                    <input name="flong" type="text" value="<?php  echo $length?>" />
                </td>
            </tr>
            <tr>
                <th>
                    Default
                </th>
                <td>
                    <?php if ($default == "current_timestamp") { ?>

                        <input name="fdefault" type="text" style="display: none;" value="<?php  echo $default;?>" />
                        <span>
                            <input type="checkbox" class="checkbox" name="fdefault" value="current_timestamp" checked="checked" /> Current timestamp
                        </span>

                    <?php } else {?>

                        <input name="fdefault" type="text" value="<?php  echo $default;?>" />
                        <span style="display:none;">
                            <input type="checkbox" class="checkbox" name="fdefault" value="current_timestamp" checked="checked" disabled="disabled" /> Current timestamp
                        </span>

                    <?php } //endif ?>
                </td>
            </tr>
            <tr>
                <th>
                    Attributes
                </th>
                <td>
                    <input type="radio" name="fattr" value="" />None
                    <input type="radio" name="fattr" value="unsigned" <?php if($unsigned == true) { ?> checked="checked" <?php } //endif ?> />Unsigned
                    <input type="radio" name="fattr" value="unsigned zerofill" <?php if($unsigned_zero == true) { ?> checked="checked" <?php } //endif ?> />Unsigned zerofill
                    <input type="radio" name="fattr" value="on update current_timestamp"
                    <?php if($current_timestamp == true) { ?> checked="checked" <?php } //endif ?> />On update current time stamp
                </td>
            </tr>
            <tr>
                <th>
                    Null
                </th>
                <td>
                    <input type="radio" name="fnull" value="null" <?php if($null == true) { ?> checked="checked" <?php } //endif ?> />null
                    <input type="radio" name="fnull" value="not null" <?php if($null == false) { ?> checked="checked" <?php } //endif ?> />not null
                </td>
            </tr>
            <tr>
                <th>
                    Index
                </th>
                <td>
                    <input type="radio" name="findex" value="" />None
                    <input type="radio" name="findex" value="primary key" <?php if($primary == true) { ?> checked="checked" <?php } //endif ?> />Primary key
                    <input type="radio" name="findex" value="index" <?php if($key == true) { ?> checked="checked" <?php } //endif ?> />Index
                    <input type="radio" name="findex" value="unique" <?php if($unique == true) { ?> checked="checked" <?php } //endif ?> />Unique
                </td>
            </tr>
            <tr>
                <th>
                    Extra
                </th>
                <td>
                    <input type="checkbox" class="checkbox" value = "auto_increment" name="auto_increment" <?php if($primary == true) { ?> checked="checked" <?php } //endif ?>/>auto increment
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <input type="button" class="cancel" value="cancel" />
                        <input type="button" id="sendEditField" value="send" />
                    </center>
                    <div class="error" >
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </form>