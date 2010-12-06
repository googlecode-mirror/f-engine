php
class <?php echo $modelname;?> extends Model {

	var $fe; // framework instance

	function <?php echo $modelname;?>() {

        // Call the Model constructor
        parent::Model();

        $this->fe =& get_instance();
        $this->fe->load->database();
	}
	<?php 
	
	$params = array();
	foreach($update["indexes"] as $param) {
		
		$params[] = "$".str_replace(".","_",$param);
		
	}
	echo "\r\n";
	?>
	function get(<?php echo implode(", ",$params);?>) {

		<?php echo '$where = array('."\r\n";
			if(isset($update["indexes"])){
			$i=0;
			foreach($update["indexes"] as $field) {
					echo "\t\t\t\t'".$field."' => ".$params[$i++].','."\r\n";
			}
			} ?>
		);
		
		return $this->db->f_select(array('<?php echo implode("','",$update["dbs"]);?>'),
		'<?php echo implode(",",$update["data"]);?>'
		,$where)->row();
	}

	function get_where($where = array(), $extra = '') {

		return $this->fe->db->f_select(array('<?php echo implode("','",$datagrid["dbs"]);?>'),
		'<?php echo implode(", ",$datagrid["data"]);?>',
		<?php echo '$where'; ?>,$extra)->result();
	}
	
	function get_totalrows($where = array()) {

		return $this->db->f_select(array('<?php echo implode("','",$datagrid["dbs"]);?>'),
		'count(*) as itemNum',<?php echo '$where'; ?>)->row()->itemNum;
	}

	function insert($data) {

		$this->validate_insert($data);

		if (count($this->fe->validation->_error_array) == 0)
		{
			/** insert in database	**/
			<?php foreach($insert["dbs"] as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($insert["data"] as $field) {
					if(strpos($field, $db) !== false && in_array($insert["fields"][$i],$insert["ignore"]) === false ) {
						echo "\t\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $data["'.$insert["fields"][$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->fe->db->f_insert('<?php echo $db;?>',$data);
			<?php }//endforeach ?>

			return true;

		} else {

			/*** validation error ***/
			return false;
		}
	}

	function validate_insert($data) {

		$this->fe->load->library('validation');

<?php foreach ($insert["rules"] as $key => $val) { ?>
		$rules['<?php  echo $key?>'] = '<?php  echo $val?>';<?php echo "\r\n";?>
<?php } //endforeach?>
		$this->fe->validation->set_rules($rules);

<?php foreach ($insert["rules"] as $key => $val) {?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php }// endforeach?>
		$this->fe->validation->set_fields($fields);

		$this->fe->validation->set_error_delimiters('<div class="error">', '</div>');
		$this->fe->validation->run();
	}

	function update($data,$where = array()) {

		$this->validate_update($data);

		if (count($this->fe->validation->_error_array) == 0)
		{
			/** update database	**/
			<?php foreach($update["dbs"] as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($update["data"] as $field) {
					if(strpos($field, $db) !== false && in_array($insert["fields"][$i],$update["ignore"]) === false ) {
						echo "\t\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $data["'.$update["fields"][$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->db->f_update('<?php echo $db;?>',$data,$where);
			<?php }//endforeach ?>

			return true;

		} else {

			/*** validation error ***/
			return false;
		}
	}

	function validate_update($data) {

		$this->fe->load->library('validation');

<?php foreach ($update["rules"] as $key => $val) { ?>
		$rules['<?php echo $key?>'] = '<?php echo $val?>';<?php echo "\r\n";?>
<?php }//endforeach ?>
		$this->validation->set_rules($rules);
		
<?php foreach ($update["rules"] as $key => $val):?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php endforeach;?>
		$this->validation->set_fields($fields);

		$this->fe->validation->set_error_delimiters('<div class="error">', '</div>');
		$this->fe->validation->run();
	}

	function delete($id) {

		if($id == '') {

			return false;
		}

		$where = array(
			'<?php echo $delete["field"]; ?>' => $id
		);

		$this->db->f_delete('<?php echo $delete["table"]; ?>',$where);
		return true;
	}
	
	function get_errors() {
	
		return $this->fe->validation->_error_array;
	} 
}