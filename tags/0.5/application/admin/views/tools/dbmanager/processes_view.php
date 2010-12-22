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
	<?php foreach($processes as $process) { ?>
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
	<?php }//endforeach ?>
	</tbody>
</table>