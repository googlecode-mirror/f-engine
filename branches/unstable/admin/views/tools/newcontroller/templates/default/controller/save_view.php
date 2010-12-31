php
class save extends Controller {

	function save() {

		parent::Controller();
		$this->load->library('validation');
		$this->load->helper('url');
	}

	function index() {

		$this->_validate();

		if (count($this->validation->_error_array) == 0)
		{
			/** insert in database	**/
			$this->load->database();

			<?php foreach($dbs as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($data as $field) {
					if(strpos($field, $db) !== false && in_array($fields[$i],$ignore) === false ) {
							
						if("file" != $styles[$i])
							echo "\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $_POST["'.$fields[$i].'"]'.",\r\n";
							
					} //endif
					$i++;
				} //endforeach?>
			);
			<?php
				echo "\r\n";
				$i = 0;
				foreach($data as $field) {
					if(strpos($field, $db) !== false && in_array($fields[$i],$ignore) === false ) {
						
						$item = substr($field,strpos($field,'.')+1);
						if("file" == $styles[$i])
							echo "\t\t\t".'if($_FILES["'.$item.'"]["error"] == 0) {
				$data["'.$item.'"] = $_FILES["'.$item.'"]["name"];	
			}';
							
					} //endif
					$i++;
				} //endforeach?>

			$this->db->f_insert('<?php echo $db;?>',$data);
			<?php } //endforeach ?>
			
			if(!$this->input->is_ajax_request()) {

				redirect("<?php echo $path?>","refresh");
			}
		
		/*** validation error ***/
		} else {

			$this->load->library("ajax");

			if($this->input->is_ajax_request())
				$this->load->view('<?php echo $view; ?>');
			else
				$this->load->masterview('<?php echo $view; ?>');
		}
	}

	function _validate() {

<?php foreach ($rules as $key => $val) { ?>
		$rules['<?php echo $key?>'] = '<?php echo $val?>';<?php echo "\r\n";?>
<?php }//endforeach ?>
		$this->validation->set_rules($rules);

<?php foreach ($rules as $key => $val) { ?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php } //endforeach ?>
		$this->validation->set_fields($fields);

		<?php if(isset($styles) and in_array("file", $styles)) { ?>$this->load->library('upload', array('upload_path' => PUBLIC_DATA, 'allowed_types' => '*')); <?php 

				$i=0;
				$upload_fields = array();
				foreach($rules as $key => $val) {

					if("file" == $styles[$i++]) {
						$upload_fields[] = $key;
					}
				}
			}//endif

			foreach($upload_fields as $item) {

				echo "\r\n\t\t".'if( stripos($rules["'.$item.'"],"required") !== false or $_FILES["'.$item.'"]["error"] == 0) {';
				echo "\r\n\r\n\t\t\t".'if(!$this->upload->do_upload("'.$item.'")) { ';
				echo "\r\n\r\n\t\t\t\t".'$uerror["'.$item.'"] = $this->upload->display_errors(\'<div class="error">\', \'</div>\');';
				echo "\r\n\r\n\t\t\t".'} else { '."\r\n";
				echo "\r\n\t\t\t\t".'$file_data = $this->upload->data();';
				echo "\r\n\t\t\t".'} //endif '."\r\n\t\t} //endif";
			}

			echo "\r\n\r\n";
		?>

		$this->validation->run();

		//add upload errors
		if(isset($uerror)) {

			foreach($uerror as $key => $val) {

				$this->validation->_error_array[$key] = $val;
				$key .= "_error";
				$this->validation->$key = $val;
			}
		}
	}
}
