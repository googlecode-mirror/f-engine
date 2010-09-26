<div id="forms">
	<h2><a href="<?php  echo site_url();?>tools/dbmanager">Data base administrator</a></h2>
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
					<ul style="" class="jqueryFileTree">
					<?php foreach($fields as $item):?>
						<li class="file ext_bat">
							<a title="<?php  echo $item?>"><?php  echo $item?></a>
						</li>
					<?php endforeach;?>	
					</ul>
				</div>
			</form>
			<div id="db_fields" class="expand floatl"></div>
		</div>
	</div>
	<div id="tableContent">
		<?php echo $this->load->view("tools/dbmanager/data"); ?>
	</div>
</div>
