php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->database();
	}

	function index() {

		<?php echo '$where = array('."\r\n";
			if(isset($indexes))
			foreach($indexes as $field) {
					echo "\t\t\t\t'".$field."' => ".'$this->uri->param('.$uripos++.'),'."\r\n";
			} ?>
		);
		$content = $this->db->f_select(array('<?php echo implode("','",$dbs);?>'),'<?php echo implode(",",$field_names);?>',$where)->row();

		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content'=>$content
		);

		$this->load->masterview('<?php echo $view?>',$data,"default");
	}
}
