php
class delete extends Controller {

	function delete() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('<?php echo  $modelname; ?>');
	}

	function index($id = '') {

		if($id == '') {

			die('Error');
		}

		$this-><?php echo  $modelname; ?>->delete($id);
		redirect("<?php echo $path;?>","refresh");
	}
}
