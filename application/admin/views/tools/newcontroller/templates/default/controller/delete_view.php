php
class delete extends Controller {

	function delete() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->database();
	}

	function index() {

		$where = array(
			'<?php echo $field; ?>' => $this->uri->param(1)
		);

		$this->db->f_delete('<?php echo $table; ?>',$where);
		redirect("<?php echo $path;?>","refresh");
	}
}
