<fieldset>
    <legend>
		<span>
	        <a href='#' class='vrules'>
	        	<img src='<? echo base_url();?>public_data/img/tools/validation.png' style="vertical-align:bottom;" />
				<img style="display:none" src='<? echo base_url();?>public_data/img/tools/application.png' style="vertical-align:bottom;" />
			
				<span style="color:black;">Validation rules</span>
				<span style="color:black;display:none;">Fields</span>
			</a>
		</span>
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
		<?foreach ($databases as $name=>$table) { ?>
			<?foreach ($table as $field) { ?>
		        <li>
		            <div class="row">
		                <div class='enlarge'>
		                	<img style="cursor:pointer;vertical-align:middle;float:left;" class="del_row" src="<?php echo base_url();?>public_data/img/contextmenu/delete.png" />
							<span style="float: left; overflow: hidden; width: 90px; margin-left: 3px;" title="<? echo $field->Field?>"><? echo $field->Field; ?></span><input type='hidden' name='<? echo $view?>_field_names[]' value='<? echo $field->Field?>' />
		                </div>
		                <div class='enlarge'>
		                    <? echo $field->Type?>&nbsp;
		                </div>
		                <div>
		                    <? echo $field->Null?>&nbsp;
		                </div>
		                <div style="width:70px;">
		                    <span title="<? echo $field->Extra?>"><? echo substr($field->Extra,0,8)?></span>&nbsp;
		                </div>
		                <div class='enlarge'>
		                    <span title="<? echo $name?>"><? echo substr($name,0,16)?></span>
		                    <input type='hidden' name='<? echo $view?>_form_fields[]' value='<? echo $name.".".$field->Field?>' />
		                </div>
		            </div>
		            <div class='oculto fldv'>
		                <div class='enlarge'>
		                    <span title="<? echo $name.'.'.$field->Field;?>"><? echo $field->Field?></span>
		                </div>
		                <input type='text' name='<? echo $view?>_validation_rules[]' value='<? echo $field->validation?>'>
		                <a class='add_rule'><img src='<? echo base_url()?>public_data/img/tools/add.png' /></a>
		            </div>
		        </li>
			<? } //endforeach ?>
			<li style="height:5px;">&nbsp;</li>
		<? } //endforeach ?>
    </ul>
	<div>
	<br />
	<hr />
	<? if (count($databases) > 1) { ?>
	
		<span class="rel_title">Define database relationships:</span>

		<div style="padding: 10px 0;display:none;">
			<div id="edit_relationships">
				<span style="display:block;">
					<select name="edit_rel_field1[]">
						<?foreach ($databases as $name=>$table):?>
							<optgroup label="<? echo $name?>">
							<?foreach ($table as $field): ?>
								<option name="<? echo $name.'.'.$field->Field;?>"><? echo $field->Field;?></option>
							<?endforeach;?>
							</optgroup>
						<?endforeach;?>
					</select>
					--> 
					<select name="edit_rel_field2[]">
						<?foreach ($databases as $name=>$table):?>
							<optgroup label="<? echo $name?>">
							<?foreach ($table as $field): ?>
								<option name="<? echo $name.'.'.$field->Field;?>"><? echo $field->Field;?></option>
							<?endforeach;?>
							</optgroup>
						<?endforeach;?>
					</select>
				</span>
			</div>
			<div style="float:right;cursor:pointer;">
				<span style="display:block;"><img src="<? echo base_url();?>public_data/img/tools/add.png" /> Add new relationship</span>
				<span style="display:block;"><img src="<? echo base_url();?>public_data/img/contextmenu/delete.png" /> Remove relationship</span>
			</div>
			<br style="clear:both;"/>
		</div>
		<hr />
	
	<? } //endif ?>
	</div>
	<div class="editRecLnk">
		<p>Select the fields that will identify the record to be edited</p>
		<ul style="display: inline;list-style:none;">
			<?foreach ($databases as $name=>$table) { ?>
				<?if(count($databases) > 1) { ?>
					<li style="clear:both;margin:0px;padding:0px 0px 5px;font-weight:bold;">
						<? echo $name;?>
					</li>
				<? } //endif?>
				<?foreach ($table as $field) { ?>
			        <li style="float:left;width:30%;">
			        	<input style="margin-left:10px;" type="checkbox" class="checkbox" <?if($field->Key == 'PRI'):?>checked="checked"<?endif;?> name="edit_id_fields[]" value="<? echo $name.'.'.$field->Field?>" />
						<span title="<? echo $name.'.'.$field->Field?>"><? echo substr($field->Field,0,14)?></span>
						 
			        </li>
				<? } //endforeach ?>
			<? } //endforeach ?>
		</ul>
	</div>
	
	
</fieldset>