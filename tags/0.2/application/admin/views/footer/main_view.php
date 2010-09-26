	<div class="footer">
		<span>Elapsed time:</span> <strong><?php  echo $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');?></strong><br />
		<span>Memory usage:</span> <strong><?php  echo $this->benchmark->memory_usage();?></strong><br /><br />
	</div>