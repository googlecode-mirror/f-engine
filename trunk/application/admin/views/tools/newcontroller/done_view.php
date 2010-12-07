<?php if( isset($link) ) { ?>	
	
	<? echo $link?>
	
<?php 
	} 
	if (isset($controllers)) { ?>
	
	<h1>Controllers</h1>
	<br />
	<?php foreach($controllers as $file => $content) { ?>
		<h2><?php echo $file; ?></h2>
		<textarea style="width: 100%; height: 200px;"><?php echo '<?'.htmlentities($content); ?></textarea>
	<?php } ?>
<?php 
	} 
	if (isset($views)) { ?>
	<br />
	<h1>Views</h1>
	<br />
	<?php foreach($views as $file => $content) { ?>
		<h2><?php echo $file; ?></h2>
		<textarea style="width: 100%; height: 200px;"><?php echo htmlentities($content); ?></textarea>
	<?php } ?>
<?php 
	} 
	
	if (isset($models)) { ?>
	<br />
	<h1>Models</h1>
	<br />
	<?php foreach($models as $file => $content) { ?>
		<h2><?php echo $file; ?></h2>
		<textarea style="width: 100%; height: 200px;"><?php echo '<?'.htmlentities($content); ?></textarea>
	<?php } ?>
<?php 
	} 
?>
