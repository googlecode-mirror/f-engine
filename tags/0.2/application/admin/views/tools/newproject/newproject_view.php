<form action="<?php echo site_url();?>tools/newproject/save" method="post">
	<h2>
		New project
	</h2>
	<style>
		input, select {
			width:200px;
		}
	</style>
	<div style="width:45%;float:left;">
	<fieldset>
	    	<legend>Project name:</legend>
			<table>
				<tr>
					<td><input type="text" name="projectname" value="<?php echo isset($_POST['projectname']) ? $_POST['projectname']:"";?>" /></td>
				</tr>
			</table>
		</fieldset>

		<fieldset>
	    	<legend>Config.php:</legend>
			<table>
				<tr>
					<td>permitted uri chars</td>
					<td><input type="text" name="permitted_uri_chars" value="a-z 0-9~%.:_\-" /></td>
				</tr>
				<tr>
					<td>Global xss filtering</td>
					<td>
						<select name="global_xss_filtering">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Compress output</td>
					<td>
						<select name="compress_output">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Rewrite short tags</td>
					<td>
						<select name="rewrite_short_tags">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</td>
				</tr>
			</table>
	  	</fieldset>
	</div>
	<fieldset style="width:45%;float:right;">
    	<legend>Database.php:</legend>
		<table>
			<tr>
				<td>Enable active record</td>
				<td>
					<select name="active_record">
						<option value="no">No</option>
						<option value="yes">Yes</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Hostname</td>
				<td><input type="text" name="hostname" value="localhost" /></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="password" /></td>
			</tr>
			<tr>
				<td>Database</td>
				<td><input type="text" name="database" /></td>
			</tr>
			<tr>
				<td>DBdriver</td>
				<td>
					<select name="dbdriver">
						<option value="mysql">mysql</option>
						<option value="mysqli">mysqli</option>
						<option value="mssql">mssql</option>
						<option value="oci8">oci8</option>
						<option value="odbc">odbc</option>
						<option value="postgre">postgre</option>
						<option value="sqlite">sqlite</option>
					</select>
				</td>
			</tr>
		</table>
  	</fieldset>

	<div style="clear:both;margin:0 auto;text-align:center;" >
	  	<input style="margin-top:10px;" type="submit" />
  	</div>
</form>