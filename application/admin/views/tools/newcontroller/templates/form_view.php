	<?php echo "<?php if(!IS_AJAX) {  ?>\n" ?>
	<a href="<?php echo '<? echo site_url("'.$path.'"); ?>'; ?>">Return</a><br /><br />
	<style>
		form table textarea {
			width:100%;
		}
	</style>
	<form action="<?php echo '<? echo site_url("'.$path.'/'.$target.'"); ?>'; ?>" method="post">
	<?php echo "<?php }//endif ?>\n" ?>
		<table width="90%">
		    <tbody>
	    	<?php
	    	  foreach($field_names as $key => $item) { if($item == '') continue;?>
		<tr>
			        <td width="10%">
			            <?php echo $item;?> 
			        </td>
			        <td>
			            <textarea name="<?php echo $name = array_pop(explode(".",$form_names[$key]));?>"><?php echo '<?php echo isset($this->validation) ? $this->validation->'.$name.' : $content->'.$name.'; ?>';?></textarea>
						<? echo '<?php if(isset($this->validation)) { echo $this->validation->'.$name.'_error; } ?>'."\n"; ?>
			        </td>
			    </tr>
			<?php }//endforeach;?>
	</tbody>
		</table>
	<?php echo "<?php if(!IS_AJAX) {  ?>\n" ?>
		<input type="submit" id="form-submit" value="save" />
	</form>
	<?php echo "<?php }//endif ?>" ?>