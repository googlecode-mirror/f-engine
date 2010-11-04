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

	<?php if(substr($_SERVER["REQUEST_URI"],-1) != "/" or strpos($_SERVER["HTTP_HOST"], "www.") !== false)  { ?>
		<link rel=”canonical” href=”<?php echo str_replace("www.","", site_url(implode("/",$this->uri->segments)) ); ?>” />
	<?php }//endif ?>

	<meta name="application-name" content="F-engine"/>
	<meta name="application-url" content="<?php echo site_url();?>"/>

	<!-- css -->
	<?php
		 if(isset($css)) {

			if(!is_array($css))	$css = array($css);

			$fe_output_conf = $this->config->item('compact');
			if($fe_output_conf["css"] == true) {
				?>
					<link href="<?=public_data("compact.php");?>?css=<?=implode(",",$css)?>" rel="stylesheet" type="text/css" media="screen, projection" />
				<? 
			} else {
			    foreach($css as $link_css) { ?>
					<link href="<?php echo base_url();?>public_data/css/<?php echo $link_css?>" rel="stylesheet" type="text/css" media="screen, projection" />
				<?php  
			    } //endforeach; 
			}
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
	
			if ($fe_output_conf["js"] == true) {
				
				for($i=0; $i <= count($js); $i++) {
	
					if(isset($js["local"][$i])) {
					?>
						<script src="<?php echo public_data("compact.php");?>?js=<?php echo $js["local"][$i];?>" type="text/javascript"></script>
					<?php
					} elseif(isset($js["remote"][$i])) {
					?>
						<script src="<?php echo $js["remote"][$i];?>" type="text/javascript"></script>
					<?php
					} //endif
	
				} //end for
				
			} else {
				
				for($i=0; $i < count($js); $i++) {
	
					if(isset($js["local"][$i])) {
					?>
						<script src="<?php echo public_data("js/".$js["local"][$i]);?>" type="text/javascript"></script>
					<?php
					} elseif(isset($js["remote"][$i])) {
					?>
						<script src="<?php echo $js["remote"][$i];?>" type="text/javascript"></script>
					<?php
					} //endif
	
				} //end for*/
			}
			
			if(isset($this->ajax)) {
				?>
				<script type="text/javascript">
				/*<![CDATA[*/
				<?php 
				foreach($this->ajax->getAll() as $script) {	echo $script;	}		
				?>
				/*]]>*/
				</script>
				<?php 
			} //endif ajax
	
	    } //endif  
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