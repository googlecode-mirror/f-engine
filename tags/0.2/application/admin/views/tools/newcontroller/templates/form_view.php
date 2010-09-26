<a href="<?php echo '<? echo site_url("'.$path.'"); ?>'; ?>">Return</a><br /><br />

<style>
	form table textarea {
		width:100%;
	}
</style>

<form action="<?php echo '<? echo site_url("'.$path.'/'.$target.'"); ?>'; ?>" method="post">
	<table width="90%">
	    <tbody>
	    	<?php
	    	  foreach($field_names as $key => $item): if($item == '') continue;?>
				<tr>
			        <td width="10%">
			            <?php echo $item;?> 
			        </td>
			        <td>
			            <textarea name="<?php echo array_pop(explode(".",$form_names[$key]));?>"><?php echo '<?php if(isset($content->'.array_pop(explode(".",$form_names[$key])).')) echo $content->'.array_pop(explode(".",$form_names[$key])).'; elseif(isset($_POST[\''.$item.'\'])) echo $_POST[\''.$item.'\'];?>'?></textarea>
						<div class="error" id="<?php echo $item?>_errormsg"><?php echo '<?php echo isset($error["'.$item.'"]) ? $error["'.$item.'"] : "";?>'?></div>
			        </td>
			    </tr>

			<?php endforeach;?>
</tbody>
	</table>
	<input type="submit" id="form-submit" value="save" />
</form>