<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php if(isset($lang)) { ?> <meta http-equiv="Content-Language" content="<?php echo $lang;?>" /> <?php } //endif ?>	

	<title><?php echo isset($title) ? $title : 'site powered by f-engine'; ?></title>

	<?php
		if(isset($description)) { 
	?>
		<meta name="description" content="<?php echo $description;?>" />
	<?php
		}
		if(isset($keywords)) {
	?>    
		<meta name="keywords" content="<?php echo $keywords?>" />
	<?php
		}
	?>

	<meta name="application-name" content="F-engine"/>
	<meta name="application-url" content="<?php echo site_url();?>"/>

	<!-- css -->
	<?php
		 if(isset($css)) {

			if(!is_array($css))	$css = array($css);

		    foreach($css as $link_css) { ?>
				<link href="<?php echo base_url();?>public_data/css/<?php echo $link_css?>" rel="stylesheet" type="text/css" media="screen, projection" />
			<?php  
		    } //endforeach; 
		    
	    }//endif			
	    ?>
	<!--/css -->

	<script type="text/javascript">
		ROOT = '<?php echo site_url();?>';
		<?php if(base_url() != site_url()) { ?>

		BASE = '<?php echo base_url();?>';
		<?php } //endif?>

		CURRENT = '<?php echo current_url();?>';

		JS2EXEC = Array();
	</script>
</head>
<body>
	<div id="content-wrapper">
		<!-- page content -->
			
			<?php
				if(isset($header))	{  
					if(is_array($header)) {
						foreach($header as $item)	$this->load->view($item);
					} else {
						$this->load->view($header);	
					}
				}
			?>

			<div id="contenidos">
				<?php if(isset($view)) 	{  $this->load->view($view);	} ?>
			</div>
			
			<?php
				if(isset($footer))	{  
					if(is_array($footer)) {
						foreach($footer as $item)	$this->load->view($item);
					} else {
						$this->load->view($footer);	
					}
				}
			?>	
		<!-- /page content -->
	
		<!-- javascript -->
		<?php  if(isset($js)) {

			if(!is_array($js))	$js = array($js);
			
			foreach($js as $lk_js){ ?>
				<script src="<?php echo base_url();?>public_data/js/<?php echo $lk_js;?>"	type="text/javascript"></script>
			<?php 
			}
	    }			
	    ?>
	    <script type="text/javascript">
			window.onload = function(){
				for (i = 0; i < JS2EXEC.length; i++) JS2EXEC[i]();
			}
		</script>
		<!-- /javascript -->
	</div>
</body>
</html>