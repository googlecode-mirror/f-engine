<div id="cabecera">
	<h1><a href="<?php echo base_url();?>" style="color:white;">F-engine</a></h1>
	<ul id="menu">
		<li class="primero<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') { ?> selected<?php }//endif ?>">
			<a href="<?php echo site_url();?>dashboard">Dashboard</a>
		</li>
		<li class="<?php if($this->uri->segment(1) == 'tools') { ?> selected<?php }//endif ?>">
			<a href="<?php echo site_url();?>tools">Tools</a>
		</li>
		<li class="ultimo">
			<a href="<?php echo site_url();?>userguide">User guide</a>
		</li>
	</ul>
	<ul id="submenu" class="idTabs">
		<li>
			<a href="<?php echo site_url();?>tools/newcontroller#forms">Forms</a>
		</li>
		<li>
			<a href="<?php echo site_url();?>tools/newcontroller#assets">Assets</a>
		</li>
		<li class="ultimo">
			<a href="<?php echo site_url();?>tools/newcontroller#finish">Finish</a>
		</li>
		<li style="float:right;right:90px;position:relative;">
		<?php if(isset($_SESSION['project'])) { ?>
			<a href="<?php echo current_url();?>/select" style="width:180px;" title="Current project: <?php echo $_SESSION['project']; ?>">Switch project</a>
		<?php } else { ?>
			<a href="<?php echo current_url();?>/select" style="width:180px;">Switch project</a>
		<?php } ?>
		</li>
	</ul>	
</div>