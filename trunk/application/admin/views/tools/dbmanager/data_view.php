<div>
<ul class="btnTabs idTabs" style="float:left;padding-bottom:0;width:500px;">
    <?php if(isset($structure)) { ?>	
    <li>
        <a href="#exam">exam</a>
    </li>
    <li>
        <a href="#structure">structure</a>
    </li>
    <li>
		<a href="#sql">sql</a>
	</li>
    <?php } else { ?>
    <li class="oculto">
        <a href="#exam">exam</a>
    </li>
    <li>
		<a href="#sql" class="selected">Sql</a>
	</li>
    <?php } //endif ?>

	<?php if(isset($structure)) { ?>	
    <li>
        <a href="#insert">Insert</a>
    </li>
    <?php } //endif ?>
    <li>
       <a href="#backup">Backup</a>
    </li>
    <?php if(isset($structure)) { ?>
	<li>
		<a href="#other">Other</a>
	</li>
	<?php }//end if ?>
</ul>
 <?php if(isset($structure)) { ?>
<a id="maximize">maximize</a>
<a id="minimize" style="display:none;">minimize</a>
<?php }//end if ?>
</div>
<?php if(isset($structure)) { ?>
	<div id="exam" style="clear:both;">
<?php } else { ?>
	<div id="exam" style="clear:both;display:none;">
<?php } //endif  ?>
	<?php if(isset($exam)) {  ?>
        <div> 
            <div id="exam-results">
                <?php $this->load->view('tools/dbmanager/exam');?>
            </div>
        </div>
        <div class="edit" style="display: none;">
        </div>
	<?php } else{ ?>
		<div id="exam-results">
			<!-- The code above is just for js compatibility reasons -->
			<div class="pagination" style="display:none;" >
        	<a href="<?php echo site_url("tools/dbmanager/ajax/view/0");?>" class="refresh">
        		<img src="<?php echo public_data("img/tools/arrow_refresh.png");?>" title="edit this record" style="cursor: pointer; vertical-align: middle;"> 
        		Refresh
        	</a>
        	</div>
			<div id="current_query" style="border:1px solid #f26d6d;background-color:#faf799;padding:2px;">
				<img class="oculto" src="<?php echo public_data();?>img/tools/preloader.gif" alt="loading" title="loading" style="vertical-align:sub;" />
				<span></span>
			</div>
			<div id="content"></div>
			<!-- end  -->
			
		</div>
	<?php }//endif ?>
</div>

<div id="sql" style="clear:both;">
	<div style="clear: both; padding-top: 15px;">
		<div id="query">
			<form method="post" action="<?php echo site_url()?>tools/dbmanager/ajax/query">
				<div class="query">
				<?php if (isset($_POST['table'])) { ?>
					<textarea  style="min-height:50px; padding:3px; max-height: 300px; width:450px;" class="expanding" id="sqlquery" name="sql">SELECT * FROM (`<?php  echo $_POST['table']?>`)</textarea>
				<?php } else { ?>
					<textarea  style="min-height:50px; padding:3px; max-height: 300px; width:450px;" class="expanding" id="sqlquery" name="sql"></textarea>
				<?php }//endif ?>
				</div>
                <input type="submit" value="Run query" style="margin-left:375px;" />

                <div id="sqlResult" style="display:none;width:460px;">
					<code></code>
				</div>
                
			</form>
		</div>
	</div>
</div>

<?php if(isset($structure)) { ?>	
<div id="insert" style="clear:both;">

	<form action="<? echo site_url().'tools/dbmanager/ajax/insert';?>" method="post">
		<input type="hidden" name="table" value="<?php echo $_POST['table'];?>" />
	    <table border="0" cellpadding="3" cellspacing="1" width="100%">
	    	<tr>
	    		<th>Field</th>
				<th>Value</th>
			</tr>
            
	        <?php foreach($structure as $field):?>
		        <tr>
		            <td>
		                <span title="<?php  echo $field->Type;?>"><?php  echo $field->Field;?></span>
		            </td>
		            <td width="100%">
                        <?php if (!$field->Extra == "auto_increment"):?>
                            <textarea class="expanding" name="<?php  echo $field->Field;?>" style="margin:0; padding:3px; min-height:15px; height:15px; max-height: 120px; width:98%;"></textarea>
                        <?php else:?>
                            <textarea name="<?php  echo $field->Field;?>" style="margin:0; padding:3px; height:15px; width:98%;" disabled="disabled">Primary key - auto increment </textarea>
                        <?php endif;?>
		            </td>
		        </tr>
	        <?php endforeach;?>
            
	    </table>
		<input style="margin: 15px 0 0 300px;" type="submit" value="send">
	</form>

</div>

<div id="structure" style="clear:both;">
    <ul class="subTabs idTabs">
        <li>
            <a href="#tfields">Fields</a>
        </li>
        <li>
            <a href="#tsql">Sql</a>
        </li>
    </ul>
    <div id="tfields" style="clear: both; display: block; padding-top: 15px; padding-left: 10px;">
        <table>
            <tbody>
                <tr>
                    <th>
                        Field
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Null
                    </th>
                    <th>
                        Extra
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>

            <?php foreach ($structure as $field): ?>
                <tr>
                    <td>
                        <?php  echo $field->Field?>
                    </td>
                    <td>
                        <?php  echo $field->Type?>&nbsp;
                    </td>
                    <td>
                        <?php  echo $field->Null?>&nbsp;
                    </td>
                    <td>
                        <?php  echo $field->Extra?>&nbsp;
                    </td>
                    <td class="edit">
                        <center>
                            <form method="post" action="<?php  echo site_url();?>tools/dbmanager/ajax/altertable/editfield" style="float:left;">
                                <input type="hidden" name="tablename" value="<?php  echo $_POST['table']?>">
                                <input type="hidden" name="field" value="<?php  echo $field->Field;?>">
                                <a href="#" class="edit_field">
                                    <img style="cursor: pointer;" title="edit this field" src="<?php echo base_url();?>public_data/img/contextmenu/page_white_edit.png"/>
                                </a>
                            </form>

                            <form method="post" action="<?php  echo site_url();?>tools/dbmanager/ajax/altertable/dropfield" style="margin-left:5px;">
                                <input type="hidden" name="tablename" value="<?php  echo $_POST['table']?>">
                                <input type="hidden" name="field" value="<?php  echo $field->Field;?>">
                                <a href="#" class="delete_field">
                                    <img style="cursor: pointer;" title="delete this field" src="<?php  echo base_url();?>public_data/img/contextmenu/delete.png"/>
                                </a>
                            </form>
                        </center>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <a class="addfield" href="#" style="display: block; margin-top: 10px;">
        	<img src="<?php echo public_data();?>img/tools/add.png" alt="" />
        	Add new field(s)
        </a>
    </div>
    <div id="newField" style="display:none;">
        <form method="post" action="<?php  echo site_url();?>tools/dbmanager/ajax/altertable/addfield" >
        <input type="hidden" name="tablename" value="<?php  echo $_POST['table']?>" />
        <table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <th>
                        Field name
                    </th>
                    <td>
                        <input name="fname" type="text" />
                    </td>
                </tr>
                <tr>
                    <th>
                        Type
                    </th>
                    <td>
                        <select name="ftype" style="width:185px">
                            <optgroup title="Numeric" label="Numeric">
                                <option value="TINYINT" rel="Numeric">TINYINT</option>
                                <option value="SMALLINT" rel="Numeric">SMALLINT</option>
                                <option value="MEDIUMINT" rel="Numeric">MEDIUMINT</option>
                                <option value="INT" rel="Numeric">INT</option>
                                <option value="BIGINT" rel="Numeric">BIGINT</option>
                                <option value="DECIMAL" rel="Numeric">DECIMAL</option>
                                <option value="FLOAT" rel="Numeric">FLOAT</option>
                                <option value="DOUBLE" rel="Numeric">DOUBLE</option>
                            </optgroup>
                            <optgroup title="String" label="String">
                                <option value="VARCHAR" rel="String">VARCHAR</option>
                                <option value="TEXT" rel="String">TEXT</option>
                                <option value="ENUM" rel="String">ENUM</option>
                            </optgroup>
                            <optgroup title="Time" label="Time">
                                <option value="TIME" rel="Time">TIME</option>
                                <option value="TIMESTAMP" rel="Time">TIMESTAMP</option>
                            </optgroup>
                            <optgroup title="Date" label="Date">
                                <option value="DATE" rel="Date">DATE</option>
                                <option value="DATETIME" rel="Date">DATETIME</option>
                                <option value="YEAR" rel="Date">YEAR</option>
                            </optgroup>
                            <optgroup title="Other" label="Other">
                                <option value="BLOB" rel="Other">BLOB</option>
                                <option value="BIT" rel="Other">BIT</option>
                                <option value="BOOL" rel="Other">BOOL</option>
                                <option value="BINARY" rel="Other">BINARY</option>
                                <option value="VARBINARY" rel="Other">VARBINARY</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        Long
                    </th>
                    <td>
                        <input name="flong" type="text" />
                    </td>
                </tr>
                <tr>
                    <th>
                        Default
                    </th>
                    <td>
                        <input name="fdefault" type="text" />
                        <span style="display:none;">
                            <input type="checkbox" class="checkbox" name="fdefault" value="current_timestamp" checked="checked" disabled="disabled" /> Current timestamp
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        Attributes
                    </th>
                    <td>
                        <input type="radio" name="fattr" value="" />None
                        <input type="radio" name="fattr" value="unsigned" />Unsigned
                        <input type="radio" name="fattr" value="unsigned zerofill" />Unsigned zerofill
                        <input type="radio" name="fattr" value="on update current_timestamp" />On update current time stamp
                    </td>
                </tr>
                <tr>
                    <th>
                        Null
                    </th>
                    <td>
                        <input type="radio" name="fnull" value="null" />null
                        <input type="radio" name="fnull" value="not null" />not null
                    </td>
                </tr>
                <tr>
                    <th>
                        Index
                    </th>
                    <td>
                        <input type="radio" name="findex" value="" />None
                        <input type="radio" name="findex" value="primary key" />Primary key
                        <input type="radio" name="findex" value="index" />Index
                        <input type="radio" name="findex" value="unique" />Unique
                    </td>
                </tr>
                <tr>
                    <th>
                        Extra
                    </th>
                    <td>
                        <input type="checkbox" class="checkbox" value = "auto_increment" name="auto_increment" />auto increment
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <center>
                        	 
                            <input type="button" class="resetField" value="reset" />
                            <input type="button" class="add" value="add" />
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
        <code></code>
        <center>
        	<input type="button" class="cancel" value="cancel" />
            <input type="button" id="sendField" value="Send" />
        </center>
        </form>
        <div class="error"></div>
        <br />
    </div>
    <div id="editfield" style="clear: both; display: none; padding-top: 15px; padding-left: 10px;"></div>
    <div id="tsql" style="clear: both; display: block; padding-top: 15px; padding-left: 10px;">
        <pre><?php  echo $createtable?></pre>
    </div>
</div>
<?php } //endif  ?>

<div id="backup" style="clear:both;display:none;">
	<ul class="subTabs idTabs">
		<li>
	        <a href="#tables">Tables</a>
	    </li>
        <li>
	        <a href="#format">Format</a>
	    </li>
		<li>
	        <a href="#result">Output</a>
	    </li>
	</ul>
	<div style="clear:both;padding-top:15px;">
		<form method="post" action="<?php  echo site_url().'tools/dbmanager/ajax/backup';?>">
			<input type="hidden" name="table" value="<?php echo isset($_POST['table']) ? $_POST['table'] : "";?>" />

			<div id="tables" style="clear:both;">
				<div style="width:320px;float:left;">
					<?php if(isset($_POST["table"])) { ?>
					<div>
						<input type="radio" name="witch" value="this" style="float:left;" />
						Backup this table 
					</div>
					<div style="margin-left:22px;display:none;">
						<strong>Based on results from the query below</strong>
						<div style="display:block;background-color:#eee;width:280px;padding:2px;">
							Select <br /><input type="text" name="backup_query[]" value="*" /><br />
							from <?php echo $_POST["table"]?><br />
							<input type="text" name="backup_query[]" value="" /><br />
						</div>
					</div>
					<?php }// endif ?>
					<input type="radio" name="witch" checked="checked" value="All" />Full database<br />
					<input type="radio" name="witch" value="custom" />Custom table selection<br />
				</div>
				<div style="float:left;">
					<select multiple="multiple" size="4" name="tables[]" style="display:none;">
                        <?php foreach($dbfields as $field):?>
                            <option value="<?php  echo $field?>"><?php  echo $field?></option>
                        <?php endforeach;?>
					</select>
				</div>
				<br style="clear:both;" /><br />
				<input type="submit" />
			</div>
			<div id="format">
				<input type="radio" name="format" value="browser" />Just show output in browser<br />
				<hr />
				<input type="radio" name="format" value="txt" checked="checked" />Txt file<br />
				<input type="radio" name="format" value="xml" />Xml file<br />
				<input type="radio" name="format" value="csv" />Csv file<br /><br />
				<select name="compression">
					<option value="txt" selected="selected">No</option>
					<option value="zip">zip</option>
					<option value="gzip">gzip</option>
				</select> compression
				<hr />
                <input type="submit" />
			</div>
			<div id="result">
				<code>
					&nbsp;
				</code>
			</div>
		</form>
	</div>

</div>
<?php if(isset($structure)) { ?>
<div id="other" style="clear:both;">
	
	<h2>Remove table</h2>
		<input type="button" name="remove_table" id="remove_table" value="remove" rel="<? echo site_url();?>tools/dbmanager/ajax/droptable" />

	<h2>Optimize</h2>
		<input type="button" name="optimize_table" id="optimize_table" value="optimize" rel="<? echo site_url();?>tools/dbmanager/ajax/optimizetable" />

	<h2>Repair table</h2>
		<input type="button" name="repair_table" id="repair_table" value="repair" rel="<? echo site_url();?>tools/dbmanager/ajax/repairtable" />

</div>
<?php 
}