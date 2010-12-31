php
class save extends Controller {

	function save() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->model('<?php echo  $modelname; ?>');
	}

	function index() {

		<?php foreach($dbs as $db) {
			echo '$data = array('."\r\n";
			$i = 0;
			foreach($data as $field) {
				if(strpos($field, $db) !== false && in_array($fields[$i],$ignore) === false ) {
						
					if("file" == $styles[$i])
						echo "\t\t\t'".substr($field,strpos($field,'.')+1).'\' => isset($_FILES["'.$fields[$i].'"]) ? $_FILES["'.$fields[$i].'"]["name"] : "",'."\r\n";
					else
						echo "\t\t\t'".substr($field,strpos($field,'.')+1).'\' => $_POST["'.$fields[$i].'"]'.",\r\n";
						
				} //endif
				$i++;
			} //endforeach?>
		);
		<?php } //endforeach ?>
		
		$this-><?php echo  $modelname; ?>->insert($data);
		
		if (count($this-><?php echo  $modelname; ?>->get_errors()) == 0)
		{
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
}
