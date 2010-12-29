<table style="margin-top:10px;">
	<thead>
		<th>Id</th>
		<th>User</th>
		<th>Host</th>
		<th>db</th>
		<th>Command</th>
		<th>Time</th>
		<th>State</th>
		<th>Info</th>
	</thead>
	<tbody>
	<?php foreach($processes as $process) { 
		if($process->Command != "Sleep") {
	?>
	<tr style="vertical-align:top;">
		<td><?php echo $process->Id?></td>
		<td><?php echo $process->User?></td>
		<td><?php echo $process->Host?></td>
		<td><?php echo $process->db?></td>
		<td><?php echo $process->Command?></td>
		<td><?php echo $process->Time?></td>
		<td><?php echo $process->State?></td>
		<td><span title="<?php echo $process->Info?>">
			<?php echo substr($process->Info,0,100)?></span>
		</td>
	</tr>
	<?php 
		} //end if	
	}//endforeach ?>
	<?php foreach($processes as $process) { 
		if($process->Command == "Sleep") {
	?>
	<tr style="vertical-align:top;">
		<td><?php echo $process->Id?></td>
		<td><?php echo $process->User?></td>
		<td><?php echo $process->Host?></td>
		<td><?php echo $process->db?></td>
		<td><?php echo $process->Command?></td>
		<td><?php echo $process->Time?></td>
		<td><?php echo $process->State?></td>
		<td><?php echo $process->Info?></td>
	</tr>
	<?php 
		} //end if	
	}//endforeach ?>
	</tbody>
</table>