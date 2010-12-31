	<?php echo "<?php if(!$this->input->is_ajax_request()) {  ?>\n" ?>
	<a href="<?php echo "<?php echo site_url('".$path."'); ?>"; ?>">Return</a><br /><br />
	<style>
		form table textarea {
			width:100%;
		}
	</style>
	<form action="<?php echo '<?php echo site_url("'.$path.'/'.$target.'"); ?>'?>" method="post"
	<?php if(in_array("file",$styles)) { ?> enctype="multipart/form-data" <?php } ?>>
	<?php echo "<?php }//endif ?>\n" ?>
		<table width="90%" id="insert-form">
		    <tbody>
	    	<?php
			  $i=0;
	    	  foreach($field_names as $item){ if($item == '') continue;?>
		<tr>
			        <td width="10%">
			            <?php echo ucfirst(trim($item));?> 
			        </td>
			        <td>
			            <?php 
			            switch($styles[$i++]) {
			            	
			            	case "input":
			            ?><input name="<?php echo $item?>" value="<?php echo '<?php if(isset($this->validation)) { echo $this->validation->'.$item.'; } ?>'; ?>" /><?php 	
			            	break;
			            	case "textarea":
			            		
			            ?><textarea name="<?php echo $item?>"><?php echo '<?php if(isset($this->validation)) { echo $this->validation->'.$item.'; } ?>'; ?></textarea><?php		
			            	break;
							case "file":
						?><input type="file" name="<?php echo $item?>" /><?php
							break;
			            }
			            echo "\r\n"; 
			            ?>
						<?php echo '<?php if(isset($this->validation)) { echo $this->validation->'.$item.'_error; } ?>'."\n";?>
			        </td>
				</tr>
			<?php }//endforeach ?>
	</tbody>
		</table>
	<?php echo "<?php if(!$this->input->is_ajax_request()) {  ?>\n" ?>
		<?php echo '<?php echo $this->ajax->submitButton("Save","#insert-form","'.$path.'");  ?>'."\n" ?>
	</form>
	<?php echo "<?php }//endif ?>" ?>