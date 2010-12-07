php
class update extends Controller {

	function update() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->library("ajax");
		$this->load->model('<?php echo  $modelname; ?>');
	}

	function index() {

		<?php foreach($dbs as $db) {
			echo '$data = array('."\r\n";

			$i = 0;
			foreach($fields as $field) {

				if(strpos($data[$i], $db) !== false && in_array($field,$ignore) === false ) {
					
					if("file" == $styles[$i])
						echo "\t\t\t\t\t'".$field.'\' => isset($_FILES["'.$field.'"]) ? $_FILES["'.$field.'"]["name"] : "",'."\r\n";
					else
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

		$this-><?php echo  $modelname; ?>->update($data,$where);
		<?php } //endforeach?>

		if (count($this-><?php echo  $modelname; ?>->get_errors()) == 0)
		{

			if(!IS_AJAX) {

				redirect("<?php echo $path?>","refresh");
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
}
