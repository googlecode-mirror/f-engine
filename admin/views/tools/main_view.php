<h2>Tools</h2>
<ul class="list">

	<li rel="newController">
		<a href="<?php echo site_url();?>tools/newcontroller" style="color:black;">
			<img src="<?php echo base_url();?>public_data/img/tools/wizard.png">New form wizard
		</a>
	</li>
	<li rel="sqlManager">
		<a href="<?php echo site_url();?>tools/dbmanager">
			<img src="<?php echo base_url();?>public_data/img/tools/dbadmin.png">Mysql dbmanager
		</a>	
	</li>
	<li rel="js">
		<a href="<?php echo site_url()?>tools/jspacker">
			<img src="<?php echo base_url();?>public_data/img/fileTree/script.png">Javascript file packer
		</a>
	</li>
	<li rel="css">
		<a href="<?php echo site_url();?>tools/csspacker">
			<img src="<?php echo base_url();?>/public_data/img/fileTree/css.png">Css file minifier
		</a>
	</li>
	<li rel="fileEditor">
		<a href="<?php echo site_url();?>tools/fileeditor">
			<img src="<?php echo base_url();?>/public_data/img/fileTree/php.png">File editor
		</a>
	</li>

</ul>

<div class="preview">
	<div class="newController" style="height:450px;">
		<h1>New form wizard</h1>
		<p style="color:#333333;">
		    Create database structure based web forms. <br />
			Select fields, validation rules, assets (css and js files), etc.
			in a few clicks
		</p>
		
		<a href="<?php echo site_url()?>tools/newcontroller">
			<img src="<?php echo base_url();?>public_data/img/tools/appz/controller.jpg">
		</a>
	</div>
	
	<div class="sqlManager" style="height:340px;display:none;">
		<h1>Mysql database manager</h1>
		<p style="color:#333333;">
		    Web based mysql administration tool. <br />
			Create, delete and edit your database structure and content
		</p>

		<a href="<?php echo site_url();?>tools/dbmanager">
			<img src="<?php echo base_url();?>public_data/img/tools/appz/dbm.jpg">
		</a>
	</div>
	
	<div class="js" style="height:450px;display:none;">
		<h1>Javascript file packer</h1>
		<p style="color:#333333;">
		   Minimize your javascript files easily. <br />
		</p>

		<a href="<?php echo site_url();?>tools/jspacker">
			<img src="<?php echo base_url();?>public_data/img/tools/appz/js.jpg">
		</a>
	</div>
	
	<div class="css" style="height:440px;display:none;">
		<h1>Css file minifier</h1>
		<p style="color:#333333;">
		   Minimize your css files easily.<br />
		</p>

		<a href="<?php echo site_url();?>tools/csspacker">
			<img src="<?php echo base_url();?>public_data/img/tools/appz/css.jpg">
		</a>
	</div>
	
	<div class="fileEditor" style="height:370px;display:none;">
		<h1>File editor</h1>
		<p style="color:#333333;">
		   Web based project file editor. <br />
		</p>

		<a href="<?php echo site_url();?>tools/fileeditor">
			<img src="<?php echo base_url();?>public_data/img/tools/appz/feditor.jpg">
		</a>
	</div>
</div>
