<?php 
class newform extends Model {

	private $post;
	private $fe;

	private $apppath;
	private $public_data;
	private $foldername;
	private $filename;

	private $assets;
	private $masterview;

	public  $insert;
	private $insert_vars;

	public  $update;
	private $update_vars;

	public  $datagrid;
	private $datagrid_vars;

	public  $delete;
	private $delete_vars;
	
	public  $model;
	private $model_vars;

	private $template_folder;
	private $files;

    function newform() {

        parent::Model();
    }

    function init($data) {

    	$this->post = $data;

    	$this->assets = array();

    	$this->insert = array();
    	$this->insert_vars = array();
    	$this->update = array();
    	$this->update_vars = array();
    	$this->datagrid = array();
    	$this->datagrid_vars = array();
    	$this->delete = array();
    	$this->delete_vars = array();
 
    	$this->model = array();
    	$this->model_vars = array();

    	if(isset($this->post["model"]) and $this->post["model"] == 1) {
			
			$this->template_folder = $this->post["template"]."/model";
		} else {
			
			$this->template_folder = $this->post["template"]."/controller";   
		}

    	$this->files = array();

    	//f-engine instance
    	$this->fe =& get_instance();

    	/**
    	 * set apppath and public_data
    	 */
    	if( isset($_SESSION['project']) ) {

			$apppath = explode("/",str_replace("\\","/", APPPATH));
			$apppath[count($apppath)-2] = $_SESSION['project'];

			$this->apppath = implode("/",$apppath);
			$this->public_data = $this->apppath.'public_data/';

		} else {

			$this->apppath = APPPATH;
			$this->public_data = PUBLIC_DATA;
		}

		/**
    	 * set foldername and filename
    	 */
		$path = explode('/',$this->post['url']) ? explode('/',$this->post['url']) : array($this->post['url']);

		if( trim($path[count($path)-1]) == "")
			unset($path[count($path)-1]);

		$vpath = $path[0];
		$this->filename = $path[count($path)-1];
		$this->foldername = $this->post['url'];

		if($this->filename == '') 
			$this->filename = "unnamed";

		if($this->foldername == '') 
			$this->foldername = "unnamed";	

		/*
		 * parse input data and set al required var values
		 */
		$this->set_assets();
		$this->set_insert_vars();
    	$this->set_update_vars();
		$this->set_datagrid_vars();
		$this->set_delete_vars();

		if(isset($this->post["model"]) and $this->post["model"] == 1) {
			
			$this->set_model_vars();
		}

		/*
		 * Parse form templates
		 */
		$this->parse_templates();

		$this->debug(false,false,false);
    }

    function create_folders() {

    	if(!file_exists($this->apppath.'controllers/'.$this->foldername)) {
			mkdir($this->apppath.'controllers/'.$this->foldername, 0777, true);
			chmod($this->apppath.'controllers/'.$this->foldername, 0777);
		}

		if(!file_exists($this->apppath.'views/'.$this->foldername)) {
			mkdir($this->apppath.'views/'.$this->foldername, 0777, true);
			chmod($this->apppath.'views/'.$this->foldername, 0777);
		}
    }

    function set_files() {

    	$default_name = $this->filename;

    	if(isset($this->datagrid["form"])) {

    		$this->files["controllers"][$this->foldername.'/'.$default_name.EXT] = $this->datagrid["form"];
    		$this->files["views"][$this->foldername.'/datagrid_view'.EXT] = $this->datagrid["view"];

    		unset($default_name);
    	}

    	if( isset($this->insert_vars["form"]) ) {

    		if(isset($default_name)) {

	    		$filename = $default_name;
	    		unset($default_name);

    		} else {

    			$filename = 'insert';
    		}

    		$this->files["controllers"][$this->foldername.'/'.$filename.EXT] = $this->insert["form"];
    		$this->files["controllers"][$this->foldername.'/save'.EXT] = $this->insert["controller"];
    		$this->files["views"][$this->foldername.'/insert_view'.EXT] = $this->insert["view"];
    	}

    	if( isset($this->update_vars["form"]) ) {

    		if(isset($default_name)) {

	    		$filename = $default_name;
	    		unset($default_name);

    		} else {

    			$filename = 'edit';
    		}

    		$this->files["controllers"][$this->foldername.'/'.$filename.EXT] = $this->update["form"];
    		$this->files["controllers"][$this->foldername.'/update'.EXT] = $this->update["controller"];
    		$this->files["views"][$this->foldername.'/edit_view'.EXT] = $this->update["view"];
    	}

    	if( count($this->delete_vars) > 0 ) {

    		$this->files["controllers"][$this->foldername.'/delete'.EXT] = $this->delete;
    	}

    	if( count($this->model_vars) > 0 and $this->model_vars["modelname"] != "" ) {

    		$this->files["models"][$this->model_vars["modelname"].EXT] = $this->model;
    	}
    }

    function get_files () {

    	return $this->files;
    }

    function write_files() {

		$this->set_files();

    	foreach($this->files["controllers"] as $filename => $data) {

	    	if (!$handler = fopen($this->apppath.'controllers/'.$filename, 'w+')) {
		         show_error("No se pudo abrir el archivo ".$this->apppath.'controllers/'.$filename);
		    }

		    if (fwrite($handler, '<?'.$data.'?>') === FALSE) {
		        show_error("No se pudo escribir al archivo ".$this->apppath.'controllers/'.$filename);
		    }

		    fclose($handler);
			chmod($this->apppath.'controllers/'.$filename, 0777);
    	}

    	foreach($this->files["views"] as $filename => $data) {

	    	if (!$handler = fopen($this->apppath.'views/'.$filename, 'w+')) {
		         show_error("No se pudo abrir el archivo ".$this->apppath.'views/'.$filename);
		    }

		    if (fwrite($handler, $data) === FALSE) {
		        show_error("No se pudo escribir al archivo ".$this->apppath.'views/'.$filename);
		    }

		    fclose($handler);
			chmod($this->apppath.'views/'.$filename, 0777);
    	}

        foreach($this->files["models"] as $filename => $data) {

	    	if (!$handler = fopen($this->apppath.'models/'.$filename, 'w+')) {
		         show_error("No se pudo abrir el archivo ".$this->apppath.'models/'.$filename);
		    }

		    if (fwrite($handler, '<?'.$data) === FALSE) {
		        show_error("No se pudo escribir al archivo ".$this->apppath.'models/'.$filename);
		    }

		    fclose($handler);
			chmod($this->apppath.'models/'.$filename, 0777);
    	}
    }

    function parse_templates() {

    	/*
    	 * Filename / classname integrity check
    	 */ 
    	$default_classname = $this->filename;
    	if(isset($this->datagrid_vars["form"])) {

			$this->datagrid_vars["form"]["classname"] = $default_classname;
    		unset($default_classname);
    	}

    	if( isset($this->insert_vars["form"]) && isset($default_classname) ) {

    		$this->insert_vars["form"]["classname"] = $default_classname;
    		unset($default_classname);
    	}

    	if( isset($this->update_vars["form"]) && isset($default_classname) ) {

			$this->update_vars["form"]["classname"] = $default_classname;
    	}

    	//datagrid
    	if( isset($this->datagrid_vars["form"]) )
			$this->datagrid["form"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/resumecontroller',$this->datagrid_vars["form"],true); 

    	if( isset($this->datagrid_vars["view"]) )
    		$this->datagrid["view"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/resume',$this->datagrid_vars["view"],true);

    	//new record
      	if( isset($this->insert_vars["view"]) )
    		$this->insert["view"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/insert',$this->insert_vars["view"],true);

        if( isset($this->insert_vars["form"]) )
    		$this->insert["form"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/controller',$this->insert_vars["form"],true);

        if( isset($this->insert_vars["controller"]) )
    		$this->insert["controller"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/save',$this->insert_vars["controller"],true);

    	// edit and update
        if( isset($this->update_vars["view"]) )
    		$this->update["view"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/form',$this->update_vars["view"],true);

        if( isset($this->update_vars["form"]) )
    		$this->update["form"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/savecontroller',$this->update_vars["form"],true);

    	if( isset($this->update_vars["controller"]) )
    		$this->update["controller"] = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/update',$this->update_vars["controller"],true);

    	//delete
		if( count($this->delete_vars) > 0 )
    		$this->delete = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/delete',$this->delete_vars,true);

    	//model
    	if( count($this->model_vars) > 0 )
    		$this->model = $this->fe->load->view('tools/newcontroller/templates/'.$this->template_folder.'/model',$this->model_vars,true);

    }

    function set_assets() {

    	if( isset($this->post['js']) )
    		$this->assets['js'] = "'".implode("','",$this->post['js'])."'";
 
    	if( isset($this->post['css']) )
    		$this->assets['css'] = "'".implode("','",$this->post['css'])."'";

    	if( isset($this->post['header']) )
    		$this->assets['header'] = str_replace("_view.php","","'header/".implode("','",$this->post['header'])."'");

    	if( isset($this->post['footer']) )
    		$this->assets['footer'] = str_replace("_view.php","","'footer/".implode("','",$this->post['footer'])."'");
    		
    	if( isset($this->post['masterview']) )
    		$this->masterview = trim($this->post['masterview']);
    }

	function set_datagrid_vars() {

		if(isset($this->post["resume_form_fields"]) && count($this->post["resume_form_fields"]) > 0) {
			/**
	    	 * set datagrid form controller vars 
	    	 */
			$databases = array();
			foreach($this->post['resume_form_fields'] as $item) {
				$databases[] = substr($item,0,strpos($item,'.'));
			}
			$databases = array_unique($databases);
			
			
			if(count($databases) > 1 && isset($this->post['resume_rel_field1'])) {
				
				$where = array();
				for($i = 0; $i < count($this->post['resume_rel_field1']); $i++) {
					
					$where[] = "'".$this->post['resume_rel_field1'][$i]." = ".$this->post['resume_rel_field2'][$i]."'";
				}
				
				$where = 'array('.implode($where,",").');';
				
			} else {
				
				$where = 'array();';	
			}

			$data = array('fields' => $this->post['resume_field_names'],'data' => array(),
							'classname'=>$this->foldername,'vpath'=> $this->foldername, 
							'dbs' => $databases, 'where' => $where);

			if(isset($this->post['resume_form_fields'])) $data['data'] = array_unique(array_merge($data['data'], $this->post['resume_form_fields']));
			if(isset($this->post['edit_id_fields']))	 $data['data'] = array_unique(array_merge($data['data'],$this->post['edit_id_fields']));

			if(isset($this->post['insert_field_names']))	$data['edit'] = true;
			if(isset($this->post['edit_field_names']))		$data['new'] = true;

			$data["assets"] = $this->assets;
			$data["masterview"] = $this->masterview;

			$i=0;
			foreach( $data["data"] as $key => $val) {

				if( !isset($data["fields"][$i]) || $data["fields"][$i] != array_pop(explode(".", $data['data'][$key])) ) {
					
					if(isset($data["fields"][$i]))
						$data['data'][$key] = $data['data'][$key]." as ".$data['fields'][$i];
					else
						$data['data'][$key] = $data['data'][$key]." as ".array_pop(explode(".",$data['data'][$key]));
				}
				$i++;
			}

			$this->datagrid_vars["form"] = $data;
			unset($data);

			/**
	    	 * set datagrid view controller vars 
	    	 */
			$data = array(
							'fields' => isset($this->post['resume_field_names']) ? $this->post['resume_field_names'] : array(),
							'data' => isset($this->post['resume_form_fields']) ? $this->post['resume_form_fields'] : array(),
							'identifiers' => isset($this->post['edit_id_fields']) ? $this->post['edit_id_fields'] : array(),
							'delete_ids' => isset($this->post['remove_id_fields']) ? $this->post['remove_id_fields'] : array(),
							'uri' => $_POST['url'],
							'delete' => isset($this->post['delete']) ? true : false,
							'edit' => isset($this->post['edit_field_names']) ? true : false,
							'new' =>  isset($this->post['insert_field_names']) ? true : false,
							'path' => $this->foldername
						);

			$this->datagrid_vars["view"] = $data;
		}
    }

    function set_insert_vars() {

    	if(isset($this->post["insert_form_fields"]) && count($this->post["insert_form_fields"]) > 0) {
			/**
	    	 * set insert form controller vars 
	    	 */
			$this->insert_vars["form"] = array(

				'classname' => 'insert',
				'view' 	=> $this->foldername.'/insert',
				'assets' => $this->assets
			);

			/**
	    	 * set view vars 
	    	 */
			$view = array('target' => 'save','path' => $this->foldername);

			$view['field_names'] = array();
			if(isset($this->post['insert_field_names'])) {

				$view['field_names'] = $this->post['insert_field_names'];
			}

			$this->insert_vars["view"] = $view;
			unset($view);

	    	/**
	    	 * set save controller vars 
	    	 */
	    	$databases = array();

			if(isset($this->post['insert_form_fields'])) {

				foreach($this->post['insert_form_fields'] as $item) {

					$databases[] = substr($item,0,strpos($item,'.'));
				}

				$data = array(
							'fields' => $this->post['insert_field_names'],
							'data' => $this->post['insert_form_fields'],
						  	'path'=> $this->foldername, 
							'dbs' => array_unique($databases)
						);

				$i = 0;

				$data['rules'] = array();
				foreach($this->post['insert_form_fields'] as $item) {

					$data['rules'][$this->post['insert_field_names'][$i]] = $this->post['insert_validation_rules'][$i++];
				}
				
				$data['ignore'] = array();
				if(isset($this->post['insert_ignoreInDB'])) {

					$data['ignore'] = $this->post['insert_ignoreInDB'];

				}

				$this->insert_vars["controller"] = $data;

			} else {
				
				$this->insert_vars["controller"] = array();
			} 
    	}
    }

	function set_update_vars() {

		if(isset($this->post["edit_form_fields"]) && count($this->post["edit_form_fields"]) > 0) {
		/*
		 * set edit form controller vars
		 */ 	
			$databases = array();
			foreach($this->post['edit_form_fields'] as $item) {

				$databases[] = substr($item,0,strpos($item,'.'));
			}

			$data = array(
				'classname'=>'edit',
				'path'=> site_url().$this->foldername, 
				'dbs' => array_unique($databases),
				'view' => $this->foldername.'/'.'edit',
				'uripos' => 1,
				'assets' => $this->assets
			);

			$data['indexes'] = array();
			if(isset($this->post['edit_id_fields'])) {
				$data['indexes'] = $this->post['edit_id_fields'];
			}


			if(isset($_POST['edit_field_names']))
				$data = array_merge($data,array('field_names' => $this->post['edit_field_names']));
			else
				$data['field_names'] = array();

			if(isset($_POST['edit_form_fields']))
				$data = array_merge($data,array('form_names' => $this->post['edit_form_fields']));
			else
				$data['form_names'] = array();

			array_merge($data, array('data' => $this->post['edit_id_fields']) );

			$this->update_vars["form"] = $data;
			unset($data);
		/*
		 * set edit form view vars
		 */ 
			$uripos = 1;
			$target = '/';

			if(isset($this->post['edit_id_fields']))
				foreach($this->post['edit_id_fields'] as $item) {
					 
					$target .= '".$this->uri->param('.$uripos++.')."';
				}

			$data = array('target' => 'update'.$target, 'path' => $this->foldername);

			if(isset($_POST['edit_field_names']))
				$data = array_merge($data,array('field_names' => $this->post['edit_field_names']));
			else
				$data['field_names'] = array();	

			if(isset($_POST['edit_form_fields']))
				$data = array_merge($data,array('form_names' => $this->post['edit_form_fields']));
			else
				$data['form_names'] = array();	

			$this->update_vars["view"] = $data;
			unset($data);
		/*
		 * set update controller vars
		 */ 
			$uripos = 1;

			$databases = array();
			if(isset($this->post['edit_form_fields']))
				foreach($this->post['edit_form_fields'] as $item) {
		
					$databases[] = substr($item,0,strpos($item,'.'));
				}

			$data = array(
						  	'path'=> $this->foldername, 
							'dbs' => array_unique($databases),
							'uripos' => $uripos,
							'view'  => $this->foldername.'/edit'
						 );

			if(isset($this->post['edit_form_fields']))
				$data = array_merge($data,array('fields' => $this->post['edit_field_names'],'data' => $this->post['edit_form_fields']));
			else {

				$data['edit_field_names'] = array();
				$data['edit_form_fields'] = array();
			}


			if(isset($this->post['edit_form_fields']))
				$data = array_merge($data, array('indexes' => $this->post['edit_id_fields']));

			$i = 0;

			$data['rules'] = array();
			if(isset($this->post['edit_form_fields'])) {
				foreach($this->post['edit_form_fields'] as $item) {

					$data['rules'][$this->post['edit_field_names'][$i]] = $this->post['edit_validation_rules'][$i++];
				}
			}

			$data['ignore'] = array();
			if(isset($this->post['edit_ignoreInDB'])) {

				$data['ignore'] = $this->post['edit_ignoreInDB'];
			}

			if(isset($this->post['edit_id_fields']))
				$data['indexes'] = $this->post['edit_id_fields'];
			else
				$data['indexes'] = array();

			$this->update_vars["controller"] = $data;
		}
    }

    function set_delete_vars() {

    	if(isset($this->post["delete"]) && isset($this->post["remove_id_fields"]) && count($this->post["remove_id_fields"]) > 0) {
	    	$this->delete_vars = array(
		    	'path' => $this->foldername,
		    	'table' => array_shift(explode(".",$this->post['remove_id_fields'][0])),
		    	'field' => $this->post['remove_id_fields'][0]
		    );
    	}
    }

    function set_model_vars() {

    	$this->model_vars["modelname"] = strtolower($this->post["modelname"]);

    	if(isset($this->datagrid_vars["form"])) {

    		$this->model_vars["datagrid"] = $this->datagrid_vars["form"];
    		$this->datagrid_vars["form"]["modelname"] = $this->post["modelname"];
    	}

    	if(isset($this->insert_vars["form"])) {

    		$this->model_vars["insert"] = $this->insert_vars["controller"];
    		$this->insert_vars["form"]["modelname"] = $this->post["modelname"];
    	}

    	if(isset($this->update_vars["form"])) {

    		$this->model_vars["update"] = $this->update_vars["controller"];
    		$this->update_vars["form"]["modelname"] = $this->post["modelname"];
    	}

    	if(count($this->delete_vars) > 0) {

    		$this->model_vars["delete"] = $this->delete_vars;
    		$this->delete_vars["form"]["modelname"] = $this->post["modelname"];
    	}

    	if(false) {
    		echo "<pre>";
    		print_r($this->model_vars);
    		die;
    	}
    }

    function debug ($input = false, $output = false, $die = true) {

    	if($input) {
	        echo 'Apppath: '.$this->apppath.'<br />';
			echo 'Public_data: '.$this->public_data.'<br />';
			echo 'Foldername: '.$this->foldername.'<br />';

	    	echo "<pre>";
	    		print_r($this->post);
	    		echo "@@@@@@@@@@@@@@@@@";

	    		echo "<br />######### insert ###########<br />";
	    		print_r($this->insert_vars);
	    		echo "<br />######### update ###########<br />";
	    		print_r($this->update_vars);
	    		echo "<br />######### datagrid ###########<br />";
	    		print_r($this->datagrid_vars);
	    		echo "<br />######### delete ###########<br />";
	    		print_r($this->delete_vars);
	    	echo "</pre>";
    	}

    	if($output) {

    		echo "<pre>";

    			echo "########## datagrid ##########";
    			print_r($this->datagrid);
    			echo "########## insert ##########";
    			print_r($this->insert);
    			echo "########## update ##########";
    			print_r($this->update);

    		echo "</pre>";

    	}

    	if($die)
    		die;
    }
}
?>