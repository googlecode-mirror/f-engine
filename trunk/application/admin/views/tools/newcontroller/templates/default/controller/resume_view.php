<div id="fe-datagrid">
<?php if($new == true) { ?>
	<a href="<?php echo '<?php echo site_url("'.$uri.'/insert");?>'?>">Create new record</a><br /><br />
<?php }//endif ?>
<table style="text-align:center;">
	<thead><?php echo "\r\n";?>
	<?
		$fnum = round(90/count($fields),1);
	?>
	<?php if($edit == true) { ?><th>Edit</th><?php }//endif ?>
	<?php if($delete == true) { ?><th>Delete</th><?php }//endif ?>
	<?php foreach($fields as $field) { ?>
		<th width="<?php echo $fnum?>%"><?php echo $field?></th>
	<?php }//endforeach ?>
	<?php echo "\r\n";?>
	</thead>
	<tbody>
	<?php  echo '<?php foreach($content as $row) { ?>';?>
	<?php echo "\r\n";?>
		<tr>
			<?php if($edit == true || $delete == true) { ?>
				<?php 
					echo "\r\n";
					foreach($identifiers as $id)	isset($editpath) == false ? $editpath = '$row->'.array_pop(explode(".",$id)).'.\'/\'' : $editpath .= '.$row->'.array_pop(explode(".",$id)).'.\'/\'';
					
					foreach($delete_ids as $id)	isset($delpath) == false ? $delpath = '$row->'.array_pop(explode(".",$id)).'.\'/\'' : $delpath .= '.$row->'.array_pop(explode(".",$id)).'.\'/\'';
				?>
				<?php if($edit == true) { echo "\r\n\t\t"; ?>
					<td><a href="<?php echo '<?php echo site_url();?>'?><?php echo $uri?>/edit/<?php echo '<?php echo '.$editpath.';?>'?>">edit</a></td>
				<?php
				} //endif
				
				if($delete == true) { echo "\r\n\t\t"; ?>
					<td><a href="<?php echo '<?php echo site_url();?>'?><?php echo $uri?>/delete/<?php echo '<?php echo '.$delpath.';?>'?>">delete</a></td>
				<?php }//endif ?>
			<?php }//endif ?>
			<?php foreach($fields as $field) { ?>
				<?php if($field != "") { ?>
				<?php echo "\r\n";?>
				<td>
					<span title="<?php  echo '<?php echo htmlspecialchars($row->'.$field.');?>';?>"><?php  echo '<? echo substr(htmlspecialchars($row->'.$field.'),0,'.(int) ($fnum*3).');?>';?></span><?php echo "\r\n";?>
				</td>
				<?php } //endif ?>
			<?php } //endforeach ?>
			<?php echo "\r\n";?>
		</tr>
	<?php echo '<?php }//endforeach ?>'?>	
	</tbody>
</table>

<?php echo "<";?>?php 
if(isset($pagination)) {
	echo "<br />".$pagination;
}
?>
</div>