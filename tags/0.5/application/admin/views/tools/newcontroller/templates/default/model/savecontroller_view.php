php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->library("ajax");
		$this->load->model('<?php echo  $modelname; ?>');
	}

	<?php
		$params = array();
		foreach($indexes as $param) {
			
			$params[] = "$".str_replace(".","_",$param);
		}
		echo "\r\n";
	?>
	function index(<?php echo implode(",",$params); ?>) {

		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content' => $this-><?php echo  $modelname; ?>->get(<?php echo implode(",",$params); ?>)
		);

		$this->load->masterview('<?php echo $view?>',$data,"<?php echo $masterview;?>");
	}
}
