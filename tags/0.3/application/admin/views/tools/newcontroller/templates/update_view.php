php
class update extends Controller {

	function update() {

		parent::Controller();
		$this->load->library('validation');
		$this->load->helper('url');
	}

	function index() {

		$validation = $this->validate();

		if ($validation['error_num'] == 0)
		{
			$this->load->database();

			<?php foreach($dbs as $db) {
				echo '$data = array('."\r\n";

				$i = 0;
				foreach($fields as $field) {
					echo "";
					if(strpos($data[$i], $db) !== false && in_array($field,$ignore) === false ) {
						echo "\t\t\t\t'".$field.'\' => $_POST["'.$field.'"]'.",\r\n";
					} //end if
					$i++;
				} //end foreach ?>
			);

			<?php echo '$where = array('."\r\n";
				if(isset($indexes))
				foreach($indexes as $field) {
						echo "\t\t\t\t'".$field."' => ".'$this->uri->param('.$uripos++.'),'."\r\n";
				} //endforeach
				?>
			);

			$this->db->f_update('<?php  echo $db;?>',$data,$where);
			<?php } //endforeach?>

			if(!IS_AJAX) {

				redirect("<?php echo $path?>","refresh");

			} else {
			
				//ajax response
				if(function_exists('json_decode')) {
	
					//PHP >= 5.2
					echo json_encode($validation);
	
				} else {
	
					$this->load->library('json');
					$this->phpJson = new Json();
					echo $this->phpJson->encode($validation);
				}	
			}

		} elseif(!IS_AJAX)  {

			$data = array("error" => $validation["error_msg"]);
			$this->load->masterview('<?php echo $view; ?>',$data,"default");
			
		} else {
		
			//ajax response
			if(function_exists('json_decode')) {

				//PHP >= 5.2
				echo json_encode($validation);

			} else {

				$this->load->library('json');
				$this->phpJson = new Json();
				echo $this->phpJson->encode($validation);
			}	
		}
	}

	function validate () {

<?php foreach ($rules as $key => $val) { ?>
		$rules['<?php echo $key?>'] = '<?php echo $val?>';<?php echo "\r\n";?>
<?php }//endforeach ?>

		$this->validation->set_rules($rules);

		if ($this->validation->run() == FALSE)
		{
			$validation = array(

				"error_num" => count($this->validation->_error_array),
				"error_msg"	=> $this->validation->_error_array
			);

		}	else	{

			$validation = array('error_num' => 0, 'redirect' => <?php echo 'site_url().\''.$path?>');
		}

		return $validation;
	}
}
