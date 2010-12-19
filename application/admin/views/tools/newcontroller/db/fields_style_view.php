<fieldset>
    <legend>
		<span>
	        <a class='vrules'>
	        	<img src='<?php echo base_url();?>public_data/img/tools/application.png' style="vertical-align:bottom;" />
				<span style="color:black;">Form field style</span>
			</a>
		</span>
    </legend>
    <div>
		<table width="80%" border="0">
			<thead>
				<th style="background-color:#EEEEEE;">Fields</th>
				<th style="background-color:#EEEEEE;">Style</th>
			</thead>
			<tbody>
			<?php foreach($fields as $field) { 
			
				$fieldname = array_shift(explode("#",$field));	
				$length = array_pop(explode("#",$field));
			?>
			<tr height="23px;">
				<td><?php echo $fieldname; ?></td>
				<td>
					<select name="<?php echo $view?>form_style[]">
						<option <?php echo $length < 120 ? 'selected="selected"' : ''; ?> value="input">text input</option>
						<option <?php echo $length >= 120 ? 'selected="selected"' : ''; ?>  value="textarea">Textarea</option>
						<option value="file">File</option>
					</select>
				</td>
			</tr>
			<?php }//endforeach ?>
			</tbody>
		</table>	
	</div>
</fieldset>