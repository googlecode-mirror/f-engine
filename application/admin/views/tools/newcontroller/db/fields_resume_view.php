<fieldset>
    <legend>
        <img src='<?php echo base_url();?>public_data/img/tools/application.png' style="vertical-align:bottom;" />
		<span>Fields</span>
    </legend>
    <ul class='dbheader legends'>
        <li>
            <div>
                <div class='enlarge'>
                    Field
                </div>
                <div class='enlarge'>
                    Type
                </div>
                <div>
                    Null
                </div>
                <div style="width:70px;">
                    Extra
                </div>
                <div class='enlarge'>
                    Table
                </div>
            </div>
        </li>
    </ul>
    <ul class='dbfldlst'>
		<?php foreach ($databases as $name=>$table) {?>
			<?php foreach ($table as $field) { ?>
		        <li>
		            <div class="row">
		                <div class='enlarge'>
		                	<img style="cursor:pointer;vertical-align:middle;float:left;" class="del_row" src="<?php echo base_url();?>public_data/img/contextmenu/delete.png" />
							<span style="float: left; overflow: hidden; width: 90px; margin-left: 3px;" title="<?php echo $field->Field?>"><?php echo $field->Field; ?></span>
							<input type='hidden' name='<?php echo $view?>_field_names[]' value='<?php echo $field->Field?>' />
		                </div>
		                <div class='enlarge'>
		                    <?php echo $field->Type?>&nbsp;
		                </div>
		                <div>
		                    <?php echo $field->Null?>&nbsp;
		                </div>
		                <div style="width:70px;">
		                	<span title="<?php echo $field->Extra?>"><?php echo substr($field->Extra,0,8)?></span>&nbsp;
		                </div>
		                <div class='enlarge'>
		                    <span title="<?php echo $name?>"><?php echo substr($name,0,16)?></span>
		                    <input type='hidden' name='<?php echo $view?>_form_fields[]' value='<?php echo $name.".".$field->Field?>' />
		                </div>
		            </div>
		        </li>
			<?php } //endforeach ?>
			<li style="height:5px;">&nbsp;</li>
		<?php } //endforeach ?>
    </ul>
	
	<br />
	
	<?php if (count($databases) > 1) { ?>
		<hr />
		<span class="rel_title">Define database relationships:</span>
		<?
			$select = 0;
		?>
		<div style="padding: 10px 0;">
			<div id="relationships">
				<span style="display:block;">
					<select name="resume_rel_field1[]">
						<?php foreach ($databases as $name=>$table) { ?>
							<optgroup label="<?php echo $name?>">
							<?php foreach ($table as $field) { ?>
								<option value="<?php echo $name.'.'.$field->Field;?>" <?php if($select == 0) { $select = 1;?>selected="selected" <?php } //endif ?>><?php echo $field->Field;?></option>
							<?php } //endforeach?>
							</optgroup>
						<?php } //endforeach ?>
					</select>
					--> 
					<select name="resume_rel_field2[]">
						<?php foreach ($databases as $name=>$table) { ?>
							<?php	$select++;	?>
							<optgroup label="<?php echo $name?>">
							<?php foreach ($table as $field) { ?>
								<option value="<?php echo $name.'.'.$field->Field;?>" <?php if($select == 3) { $select++;?>selected="selected" <?php } //endif ?>><? echo $field->Field;?></option>
							<?php } //endforeach ?>
							</optgroup>
						<?php } //endforeach ?>
					</select>
				</span>
			</div>
			<div style="float:right;cursor:pointer;">
				<span style="display:block;"><img src="<?php echo base_url();?>public_data/img/tools/add.png" /> Add new relationship</span>
				<span style="display:block;"><img src="<?php echo base_url();?>public_data/img/contextmenu/delete.png" /> Remove relationship</span>
			</div>
			<br style="clear:both;"/>
		</div>
	
	<?php } //endif ?>
	
	<?php if(count($databases) == 1) { ?>
		<input type="checkbox" class="checkbox" value="1" name="delete" /> Include delete feature

		<div class="delRecLnk" style="margin-left: 20px;padding-left:5px;display:none;">
			<div style="margin-top:5px;">Select the <?php if(count($databases) > 1) { ?>database and the <?php } //endif; ?>fields that will identify the record to be deleted</div>
			<ul style="display: inline;list-style:none;">
				<?php foreach ($databases as $name=>$table) { ?>
					<?php if(count($databases) > 1) { ?>
						<li style="clear:both;margin:0px;padding:10px 0px 5px;font-weight:bold;">
							<input type="radio"name="delete_db" class="delete_db" value="<?php echo $name;?>" />
							<?php echo $name;?>
						</li>
					<?php } else { ?>
						<li style="clear:both;margin:0px;padding:0px 0px 5px;font-weight:bold;">
							<?php echo $name;?>
						</li>
					<?php } //endif?>
					<?php foreach ($table as $field) { ?>
				        <li style="float:left;width:30%;">
				        	<input style="margin-left:10px;" type="checkbox" class="checkbox" rel="<?php echo $name;?>" <?php if($field->Key == 'PRI') { ?>checked="checked"<?php } //endif ?> name="remove_id_fields[]" value="<?php echo $name.'.'.$field->Field?>" />
							<span title="<?php echo $name.'.'.$field->Field?>"><?php echo substr($field->Field,0,14)?></span>
				        </li>
					<?php } //endforeach ?>
				<?php } //endforeach ?>
			</ul>
		</div>
	<?php }//endif ?>
</fieldset>