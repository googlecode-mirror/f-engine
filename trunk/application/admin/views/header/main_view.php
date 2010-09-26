<div id="cabecera">
	<h1><a href="<?php echo base_url();?>" style="color:white;">F-engine</a></h1>
	<ul id="menu">
		<li class="primero<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == ''):?> selected<?php endif;?>">
			<a href="<?php  echo site_url();?>dashboard">Dashboard</a>
		</li>
		<li <?php if($this->uri->segment(1) == 'tools'):?> class="selected"<?php endif;?>>
			<a href="<?php  echo site_url();?>tools">Tools</a>
		</li>
		<li <?php if($this->uri->segment(1) == 'userguide'):?> class="selected"<?php endif;?>>
			<a href="<?php  echo site_url();?>userguide">User guide</a>
		</li>
	</ul>
</div>