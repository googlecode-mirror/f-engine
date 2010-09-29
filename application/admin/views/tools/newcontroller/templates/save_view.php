php
class save extends Controller {

	function save() {

		parent::Controller();
		$this->load->library('validation');
		$this->load->helper('url');
	}

	function index() {

		$validation = $this->validate();

		if ($validation['error_num'] == 0)
		{
			/** action	**/
			$this->load->database();

			<?php foreach($dbs as $db) {
				echo '$data = array('."\r\n";
				$i = 0;
				foreach($data as $field) {
					if(strpos($field, $db) !== false && in_array($fields[$i],$ignore) === false ) {
						echo "\t\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $_POST["'.$fields[$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->db->f_insert('<?php echo $db;?>',$data);
			<?php }//endforeach ?>
			
			if(!IS_AJAX) {
				
				redirect("<? echo $path?>","refresh");

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
			
		} elseif(!IS_AJAX) {

			$data = array( "error" => $validation["error_msg"] );
			$this->load->masterview('<?php echo $view; ?>', $data, "default");
			
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

<?php foreach ($rules as $key => $val):?>
		$rules['<?php  echo $key?>'] = '<?php  echo $val?>';<?php echo "\r\n";?>
<?php endforeach;?>

		$this->validation->set_rules($rules);

		if ($this->validation->run() == FALSE)
		{
			$validation = array(

				"error_num" => count($this->validation->_error_array),
				"error_msg"	=> $this->validation->_error_array
			);

		}	else	{

			$validation = array('error_num' => 0, 'redirect' => <? echo 'site_url(\''.$path.'\')'?>);
		}

		return $validation;
	}
}
