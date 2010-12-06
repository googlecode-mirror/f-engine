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
						echo "\t\t\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $_POST["'.$fields[$i].'"]'.",\r\n";
					} //endif
					$i++;
				} //endforeach ?>
			);

			$this->db->f_insert('<?php echo $db;?>',$data);
			<?php }//endforeach ?>
			
			if(!IS_AJAX) {

				redirect("<? echo $path?>","refresh");
			}
		
		/*** validation error ***/
		} else {

			$this->load->library("ajax");

			if(IS_AJAX)
				$this->load->view('<?php echo $view; ?>');
			else
				$this->load->masterview('<?php echo $view; ?>');
		}
	}

	function _validate() {

<?php foreach ($rules as $key => $val) { ?>
		$rules['<?php  echo $key?>'] = '<?php  echo $val?>';<?php echo "\r\n";?>
<?php } //endforeach?>
		$this->validation->set_rules($rules);
		
<?php foreach ($rules as $key => $val) {?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php }// endforeach?>
		$this->validation->set_fields($fields);

		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->validation->run();
	}
}
