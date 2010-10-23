<ul class="jqueryFileTree" style="display: none;">

	<!--directories-->
	<?php if($directories):?>
		<?php foreach($directories as $dir):?>
			<ul class="jqueryFileTree" style="display: none;">
				<li class="directory collapsed">
					<a rel="<?php  echo $basedir . $dir?>/">
						<?php  echo htmlentities($dir)?>
					</a>
				</li>
			</ul>
		<?php endforeach;?>	
	<?php endif;?>
		
	<!-- files -->
	<?php if($files):?>
		<?php foreach($files as $item):?>
		
			<?php  $ext = preg_replace('/^.*\./', '', $item); ?>
			<li class="file ext_<?php  echo $ext?>">
				<a rel="<?php  echo $basedir . $item?>">
					<?php  echo htmlentities($item)?>
				</a>
			</li>
		<?php endforeach;?>	
	<?php endif;?>
</ul>	