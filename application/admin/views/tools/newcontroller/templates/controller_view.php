php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper(array('url'));
	}
	
	function index() {
		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
		);
		$this->load->masterview("<?php echo $view; ?>",$data,"<?php echo $masterview;?>");
	}
}
