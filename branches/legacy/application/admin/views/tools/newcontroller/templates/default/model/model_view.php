php
class <?php echo $modelname;?> extends Model {

	var $fe; // framework instance

	var $error_delimiter_start;
	var $error_delimiter_end;

	var $data;

	<?php if( (isset($update["styles"]) and in_array("file", $update["styles"])) 
		or isset($insert["styles"]) and in_array("file", $insert["styles"])) { 
		?>var $upload_path;
	var $allowed_filetypes;
	<?php $upload_file = true; }//endif  ?>

	function <?php echo $modelname;?>() {

        // Call the Model constructor
        parent::Model();

        $this->fe =& get_instance();
        $this->fe->load->database();

        $this->error_delimiter_start = '<div class="error">';
        $this->error_delimiter_end = '</div>';

        <?php if(isset($upload_file) and $upload_file == true) { 
        ?>/*** file upload options ***/ 
        $this->upload_path = PUBLIC_DATA; <?php echo "\r\n\t\t";?>$this->allowed_filetypes = '*'; <?php 
        	echo "\r\n"; 
        } else {
        	echo "\r\n";
        }//endif ?>
	}
	<?php 
if(isset($update["indexes"])) { ?>
<?php $params = array();
	foreach($update["indexes"] as $param) {

		$params[] = "$".str_replace(".","_",$param);
	}
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

		return $this->fe->db->f_select(array('<?php echo implode("','",$update["dbs"]);?>'),
		'<?php echo implode(",",$update["data"]);?>'
		,$where)->row();
	}
<?php }//endif ?>
<?php if(isset($datagrid["data"])) { ?>
	function get_where($where = array(), $extra = '') {

		return $this->fe->db->f_select(array('<?php echo implode("','",$datagrid["dbs"]);?>'),
		'<?php echo implode(", ",$datagrid["data"]);?>',
		<?php echo '$where'; ?>,$extra)->result();
	}

	function get_totalrows($where = array()) {

		return $this->fe->db->f_select(array('<?php echo implode("','",$datagrid["dbs"]);?>'),
		'count(*) as itemNum',<?php echo '$where'; ?>)->row()->itemNum;
	}
<?php }//endif ?>
<?php if(isset($insert["dbs"])) { ?>
	function insert($data) {

		$this->data = $data;
		$this->validate_insert();

		if (count($this->fe->validation->_error_array) == 0)
		{
			/** insert in database	**/
			<?php foreach($insert["dbs"] as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($insert["data"] as $field) {
					if(strpos($field, $db) !== false && in_array($insert["fields"][$i],$insert["ignore"]) === false ) {
						echo "\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $this->data["'.$insert["fields"][$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->fe->db->f_insert('<?php echo $db;?>',$data);
			<?php }//endforeach ?>return $this->fe->db->insert_id();

		} else {

			/*** validation error ***/
			return false;
		}
	}

	function validate_insert() {

		$this->fe->load->library('validation');
		$this->fe->validation->data_src = $this->data;

<?php foreach ($insert["rules"] as $key => $val) { ?>
		$rules['<?php  echo $key?>'] = '<?php  echo $val?>';<?php echo "\r\n";?>
<?php } //endforeach?>
		$this->fe->validation->set_rules($rules);

<?php foreach ($insert["rules"] as $key => $val) {?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php }// endforeach?>
		$this->fe->validation->set_fields($fields);

		<?php if(isset($insert["styles"]) and in_array("file", $insert["styles"])) { ?>$this->fe->load->library('upload', array(
			'upload_path' => $this->upload_path, 
			'allowed_types' => $this->allowed_filetypes)
		); <?php 

				$i=0;
				$upload_fields = array();
				foreach($insert["rules"] as $key => $val) {

					if("file" == $insert["styles"][$i++]) {
						$upload_fields[] = $key;
					}
				}
			}//endif

			if(isset($upload_fields)) {
				foreach($upload_fields as $item) {

					echo "\r\n\r\n\t\t".'if( stripos($rules["'.$item.'"],"required") !== false or (isset($_FILES["'.$item.'"]) and $_FILES["'.$item.'"]["error"] == 0)) {';
					echo "\r\n\r\n\t\t\t".'if(!$this->fe->upload->do_upload("'.$item.'")) { ';
					echo "\r\n\r\n\t\t\t\t".'$uerror["'.$item.'"] = $this->fe->upload->display_errors($this->error_delimiter_start, $this->error_delimiter_end);';
					echo "\r\n\t\t\t\t".'$this->data["'.$item.'"] = "";';
					echo "\r\n\r\n\t\t\t".'} else { '."\r\n";
					echo "\r\n\t\t\t\t".'$file_data = $this->fe->upload->data();';
					echo "\r\n\t\t\t\t".'$this->data["'.$item.'"] = $file_data["file_name"];';
					echo "\r\n\t\t\t".'} //endif '."\r\n\t\t} //endif";
				}

				echo "\r\n\r\n";
			}
		?>

		$this->fe->validation->run();
		$this->fe->validation->data_src = $_POST;

		//set upload errors
		if(isset($uerror)) {

			foreach($uerror as $key => $val) {

				$this->fe->validation->_error_array[$key] = $val;
				$key .= "_error";
				$this->fe->validation->$key = $val;
			}
		}
	}
<?php }//endif ?>
<?php if(isset($update["dbs"])) { ?>
	function update($data,$where = array()) {

		$this->data = $data;
		$this->validate_update();

		if (count($this->fe->validation->_error_array) == 0)
		{
			/** update database	**/
			<?php foreach($update["dbs"] as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($update["data"] as $field) {
					if(strpos($field, $db) !== false && in_array($update["fields"][$i],$update["ignore"]) === false ) {
						echo "\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $this->data["'.$update["fields"][$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->fe->db->f_update('<?php echo $db;?>',$data,$where);
			<?php }//endforeach ?>return true;

		} else {

			/*** validation error ***/
			return false;
		}
	}

	function validate_update() {

		$this->fe->load->library('validation');
		$this->fe->validation->data_src = $this->data;
<?php foreach ($update["rules"] as $key => $val) { ?>
		$rules['<?php echo $key?>'] = '<?php echo $val?>';<?php echo "\r\n";?>
<?php }//endforeach ?>
		$this->fe->validation->set_rules($rules);

<?php foreach ($update["rules"] as $key => $val) { ?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php }//endforeach ?>
		$this->fe->validation->set_fields($fields);

		<?php if(isset($update["styles"]) and in_array("file", $update["styles"])) { ?>$this->fe->load->library('upload', array(
			'upload_path' => $this->upload_path, 
			'allowed_types' => $this->allowed_filetypes)
		); <?php 

				$i=0;
				$upload_fields = array();
				foreach($update["rules"] as $key => $val) {

					if("file" == $update["styles"][$i++]) {
						$upload_fields[] = $key;
					}
				}
			}//endif

			if(isset($upload_fields)) {
				foreach($upload_fields as $item) {

					echo "\r\n\r\n\t\t".'if( stripos($rules["'.$item.'"],"required") !== false or (isset($_FILES["'.$item.'"]) and $_FILES["'.$item.'"]["error"] == 0)) {';
					echo "\r\n\r\n\t\t\t".'if(!$this->fe->upload->do_upload("'.$item.'")) { ';
					echo "\r\n\r\n\t\t\t\t".'$uerror["'.$item.'"] = $this->fe->upload->display_errors($this->error_delimiter_start, $this->error_delimiter_end);';
					echo "\r\n\r\n\t\t\t".'} else { '."\r\n";
					echo "\r\n\t\t\t\t".'$file_data = $this->fe->upload->data();';
					echo "\r\n\t\t\t".'} //endif '."\r\n\t\t} //endif";
				}

				echo "\r\n\r\n";
			}
		?>

		$this->fe->validation->run();
		$this->fe->validation->data_src = $_POST;

		//add upload errors
		if(isset($uerror)) {

			foreach($uerror as $key => $val) {

				$this->fe->validation->_error_array[$key] = $val;
				$key .= "_error";
				$this->fe->validation->$key = $val;
			}
		}
	}
<?php }//endif ?>
<?php if(isset($delete["field"])) { ?>
	function delete($id) {

		if($id == '') {

			return false;
		}

		$where = array(
			'<?php echo $delete["field"]; ?>' => $id
		);

		$this->fe->db->f_delete('<?php echo $delete["table"]; ?>',$where);
		return true;
	}
<?php }//endif ?>	
	function get_errors() {
	
		if(isset($this->fe->validation))
			return $this->fe->validation->_error_array;
		else
			return false;
	} 
}