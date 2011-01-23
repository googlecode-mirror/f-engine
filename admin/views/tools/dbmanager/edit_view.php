<form action="<?php  echo $action?>" method="post">
	<input type="hidden" name="table" value="<?php  echo $table; ?>" />

    <?php if(isset($_POST['primary'])) { ?>
        <input type="hidden" name="primary" value="<?php  echo $_POST["primary"];?>" />
        <?php if(is_array($_POST["primary_value"])) { ?>
        	<?php foreach($_POST["primary_value"] as $val) { ?>
        		<input type="hidden" name="primary_value[]" value="<?php echo $val;?>" />
        	<?php }//end foreach ?>
        <?php } else { ?>
        	<input type="hidden" name="primary_value" value="<?php echo $_POST["primary_value"];?>" />
        <?php }//endif ?>
    <?php } elseif(isset($_POST['unique'])) { ?>
        <input type="hidden" name="unique" value="<?php  echo $_POST["unique"];?>" />
        <input type="hidden" name="unique_value" value="<?php echo $_POST["unique_value"];?>" />
    <?php } else {  ?>
    	<?php foreach($data as $key => $val) { ?>
    			<textarea name="old_<?php echo $key; ?>" style="display:none;"><?php echo $val; ?></textarea>
    	<?php }//end foreach ?>
    <?php  } //endif ?>

    <table border="0" cellpadding="3" cellspacing="1">
        <tr>
           <th colspan="2">Edit record</th>
        </tr>
        <?php foreach($structure as $field) { ?>
        <tr>
            <td>
                <?php echo  $field->Field; ?>
            </td>
            <td>
			<?php if(substr($field->Type,0,5) == "enum(") { 

            	$options = explode("','",substr($field->Type,6,-2));
            	$f = $field->Field; 
            	$currentValue = $query->$f;
            ?>
            	<select name="<?php  echo $field->Field;?>">
            	<?php foreach($options as $option) { ?>
            		<option value="<?php echo $option; ?>" <?php echo $currentValue == $option ? 'selected' : ''; ?>>
            			<?php echo $option; ?>
            		</option>
            	<?php }//endforeach ?>
            	</select>
			<?php } else { ?>
				<textarea class="expanding" name="<?php echo $field->Field;?>"
				style="margin: 0pt; padding: 3px; overflow: hidden; min-height: 15px; height: 15px; 
				max-height: 120px; width: 550px; display: block;"><?php $f = $field->Field; echo form_prep($query->$f); ?></textarea>
			<?php } //endif ?>
            </td>
        </tr>
        <?php } //endforeach ?>
    </table>
	<input type="button" value="cancel" class="cancel">
	<input type="submit" value="send">
</form>
<br style="clear:both;" />