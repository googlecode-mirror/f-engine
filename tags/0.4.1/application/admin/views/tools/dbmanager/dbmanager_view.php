<div id="forms">
	<h2><a href="<?php  echo current_url();?>">Data base administrator</a></h2>
	<div class="leftFrame">
		<div class="newTable">
			<a href="<?php  echo site_url();?>tools/dbmanager/ajax/newtable">Create a new table</a>
		</div>
		<div class="frame">
			<form action="<?php  echo site_url();?>tools/dbmanager/ajax/view" method="post">
				<div id="db_list" class="floatl">
					<input class="filter" type="text" style="width:105px;" /> 
					<img src="<?php echo base_url();?>public_data/img/tools/validation.png" style="vertical-align:middle;">
					<hr/>
					<ul class="jqueryFileTree">
					<?php if(isset($tables)) { ?>
						<?php foreach($tables as $item) { ?>
							<li class="file ext_bat">
								<a title="<?php  echo $item?>"><?php  echo $item?></a>
							</li>
						<?php } //endforeach?>	
					<?php } //endif ?>
					</ul>
				</div>
			</form>
			<div id="db_fields" class="expand floatl"></div>
		</div>
		<form action="<?php echo site_url("tools/dbmanager/");?>" method="post">
		<?php if(count($db_conf) > 1) { ?>
			<div style="padding:2px;text-align:center;">
			DB conf: 
				<select name="db_conf" style="width:95px;">
				<?php foreach($db_conf as $conf) { ?>
					<option value="<?php echo $conf; ?>" <?php echo $conf == $current_db ? "selected='selected'" : ""; ?>>
						<?php echo $conf; ?>
					</option>
				<?php } //end foreach?>
				</select>
			</div>
		<?php } else { ?>
			<select name="db_conf" style="display:none;">
			<?php foreach($db_conf as $conf) { ?>
				<option value="<?php echo $conf; ?>"><?php echo $conf; ?></option>
			<?php } //end foreach?>
			</select>
		<?php }//endif ?>
		</form>
	</div>
	<div id="tableContent">
		<?php echo $this->load->view("tools/dbmanager/data"); ?>
	</div>
</div>
