<a href="<?php echo '<? echo site_url("'.$path.'"); ?>'; ?>">Return</a><br /><br />

<style>
	form table textarea {
		width:100%;
	}
</style>

<form action="<?php echo '<? echo site_url("'.$path.'/'.$target.'"); ?>'?>" method="post">
	<table width="90%">
	    <tbody>
    	<?php
		  $i=0;
    	  foreach($field_names as $item){ if($item == '') continue;?>
	<tr>
		        <td width="10%">
		            <?php echo $item;?> 
		        </td>
		        <td>
		            <textarea name="<?php echo $item?>"><?php echo '<?php if(isset($this->validation)) { echo $this->validation->'.$item.'; } ?>'; ?></textarea>
					<? echo '<?php if(isset($this->validation)) { echo $this->validation->'.$item.'_error; } ?>'."\n";?>
		        </td>
			</tr>
		<?php }//endforeach ?>
</tbody>
	</table>
	<input type="submit" id="form-submit" value="save" />
</form>