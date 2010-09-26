<form action="<?php  echo $action?>" method="post">
	<input type="hidden" name="table" value="<?php  echo $table?>" />

    <?php if(isset($_POST['primary'])) { ?>
        <input type="hidden" name="primary" value="<?php  echo $_POST["primary"];?>" />
        <input type="hidden" name="primary_value" value="<?php  echo $_POST["primary_value"];?>" />
    <?php } elseif(isset($_POST['unique'])) { ?>
        <input type="hidden" name="unique" value="<?php  echo $_POST["unique"];?>" />
        <input type="hidden" name="unique_value" value="<?php  echo $_POST["unique_value"];?>" />
    <?php } else {  ?>
    	<?php foreach($data as $key => $val) { ?>
    			<textarea name="old_<?php echo $key; ?>" style="display:none;"><?php echo $val; ?></textarea>
    	<?php }//end foreach ?>
    <?php  } //endif ?>

    <table border="0" cellpadding="3" cellspacing="1">
        <tr>
           <th colspan="2">Edit record</th>
        </tr>
        <?php foreach($fields as $field): ?>
        <tr>
            <td>
                <?php echo  $field->name; ?>
            </td>
            <td>
                <textarea class="expanding" name="<?php echo $field->name;?>"
				style="margin: 0pt; padding: 3px; overflow: hidden; min-height: 15px; height: 15px; 
				max-height: 120px; width: 550px; display: block;"><?php $f = $field->name; echo form_prep($query->$f); ?></textarea>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
	<input type="button" value="cancel" class="cancel">
	<input type="submit" value="send">
</form>