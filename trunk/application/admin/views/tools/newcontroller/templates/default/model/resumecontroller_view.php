php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->model('<?php echo  $modelname; ?>');
	}

	function index($current_page = 0) {

		$this->load->database();

		/*** get records ***/
		<?php if(isset($where)) { echo '$where = '.$where."\r\n"; } ?>
		$extra = "limit $current_page,20";
		$content = $this-><?php echo $modelname; ?>->get_where($where,$extra);

		/*** set pagination ***/
		$config['base_url'] = site_url("<?php echo $vpath;?>");
		$config['total_rows'] = $this-><?php echo $modelname; ?>->get_totalrows();
		$config['per_page'] = '20';
		$config['ajax'] = "#fe-datagrid";

		$this->pagination->initialize($config); 

		/*** load view ***/
		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content' => $content,
			'pagination' => $this->pagination->create_links() 
		); 
		
		if(IS_AJAX) {

			$this->load->view('<?php echo $vpath;?>/datagrid', $data);
		} else {

			$this->load->masterview('<?php echo $vpath;?>/datagrid', $data, "<?php echo $masterview;?>");
		}
	}
}