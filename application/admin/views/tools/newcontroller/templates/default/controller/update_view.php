php
class update extends Controller {

	function update() {

		parent::Controller();
		$this->load->library('validation');
		$this->load->helper('url');
		$this->load->library("ajax");
	}

	function index() {

		$this->_validate();

		if (count($this->validation->_error_array) == 0)
		{
			/** update database	**/
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
			}

		/*** validation error ***/
		} else {

			$this->load->library("ajax");

			if(IS_AJAX)
				$this->load->masterview('<?php echo $view; ?>');
			else
				$this->load->view('<?php echo $view; ?>');
		}
	}

	function _validate () {

<?php foreach ($rules as $key => $val) { ?>
		$rules['<?php echo $key?>'] = '<?php echo $val?>';<?php echo "\r\n";?>
<?php }//endforeach ?>
		$this->validation->set_rules($rules);
		
<?php foreach ($rules as $key => $val):?>
		$fields['<?php  echo $key?>'] = '<?php  echo $key?>';
<?php endforeach;?>
		$this->validation->set_fields($fields);

		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		$this->validation->run();
	}
}
