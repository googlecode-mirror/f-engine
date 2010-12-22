<div style="width:400px;margin:0 auto; text-align:center; border: 1px solid #3A4798;">
	<h2>Select target project</h2>
	<?php if(isset($db_error)) { ?>
		<div style="color:#aa0000;">Provided database configuration does not seems to be correct. <strong>Please check your <?php echo $_POST["project"];?>/config/database.php</strong></div>
		<hr />
	<?php } ?>
	<form method="post" action="<?php echo $action;?>">

		<ul style="list-style:none;text-align:left;margin-left:150px;" >
		<?php 
			foreach($projects as $project) {
		?>
			<li>
				<input type="radio" name="project" value="<?php echo $project;?>" />
				<?php echo $project;?>
			</li>
		<?php 
			} //end foreach
		?>
		</ul>
		<input type="submit" style="margin:5px auto;" />

	</form>
</div>