<!--<h2>New controller wizard</h2>-->
<form action="<? echo site_url();?>tools/newcontroller/save" method="post">
	<div id="forms">
		<ul class="btnTabs idTabs">
			<li><a href="#resume">Datagrid</a></li>
			<li><a href="#insert">New record view</a></li>
			<li><a href="#edit">Edition view</a></li>
		</ul>
		<div id="resume">
			<div class="frame">
				<div class="db_list dir floatl">
					<img src="<?php echo base_url();?>public_data/img/tools/validation.png"> <input type="text" class="filter" />
					<hr />
					<ul style="" class="jqueryFileTree">
					<?foreach($fields as $item):?>
						<li class="file ext_bat">
							<a><? echo $item?></a>
						</li>
					<?endforeach;?>	
					</ul>
				</div>
				<div class="help">
					<h1>Info</h1>
					<p>
						Select the table you want to work with
					</p>
				</div>
				<div  class="buttons">
					<input type="button" class="go2db_fields" value="Next" />
				</div>	
			</div>
			<div class="frame"  style="display: none;">
				<div class="db_fields floatl">
				</div>
				<div class="help">
					<div>
						<h1>Select fields</h1>
						<p>
							Manipulate table fields to get the structure you are looking for. You can:
							<ul>
								<li>Change the order that fields are shown by drad and droping them</li>
								<li>Delete the fields you dont need in result form. Press right click and choose Delete in the context menu</li>
								<li>Edit field names that will be shown in result form. Press right click and choose Edit in the context menu, 
								type a new name, press right click again and choose apply to commit changes or undo to return to the original value.</li>
							</ul>
						</p>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="back2db_list" value="Prev" />
				</div>
			</div>
		</div>
		<!--	end resume -->
		<div id="edit" style="display: none;">
			<div class="frame">
				<div class="db_list dir floatl">
					<img src="<?php echo base_url();?>public_data/img/tools/validation.png"> <input type="text" class="filter" />
					<hr />
					<ul style="" class="jqueryFileTree">
					<?foreach($fields as $item):?>
						<li class="file ext_bat">
							<a><? echo $item?></a>
						</li>
					<?endforeach;?>	
					</ul>
				</div>
				<div class="help">
					<h1>Info</h1>
					<p>
						 Select the table you want to work with 
					</p>
				</div>
				<div  class="buttons">
					<input type="button" class="go2db_fields" value="Next" />
				</div>	
			</div>
			<div class="frame"  style="display: none;">
				<div class="db_fields floatl">
				</div>
				<div class="help">
					<div>
						<h1>Select fields</h1>
						<p>
							Manipulate table fields to get the structure you are looking for. You can:
							<ul>
								<li>Change the order that fields are shown by drad and droping them</li>
								<li>Delete the fields you dont need in result form. Press right click and choose Delete in the context menu</li>
								<li>Edit field names that will be shown in result form. Press right click and choose Edit in the context menu, 
								type a new name, press right click again and choose apply to commit changes or undo to return to the original value.</li>
								<li>Click on validation rules on the top-left form corner and select as much filter as want for desired fields</li>
							</ul> 
						</p>
					</div>
					<div style="display: none;">
						<h1>Rule Reference:</h1>
						<p>
							<strong>required</strong><br />Returns FALSE if the form element is empty.<br />
							<strong>matches</strong><br />
								<i>example: matches[form_item]</i><br />
								Returns FALSE if the form element does not match the one in the parameter. 	<br />
							<strong>min_length</strong><br />
								<i>example: min_length[6]</i><br />
								Returns FALSE if the form element is shorter then the parameter value.<br />
							<strong>max_length</strong><br />
								<i>example: max_length[12]</i><br />
								Returns FALSE if the form element is longer then the parameter value.<br />
							<strong>exact_length</strong><br />
								<i>example: exact_length[8]</i><br />
								Returns FALSE if the form element is not exactly the parameter value.<br />
							<strong>alpha</strong><br />
								Returns FALSE if the form element contains anything other than alphabetical characters.<br />
							<strong>alpha_numeric</strong><br />
								Returns FALSE if the form element contains anything other than alpha-numeric characters.<br /> 	 
							<strong>alpha_dash</strong><br />
								Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.<br />
							<strong>numeric</strong><br />
								Returns FALSE if the form element contains anything other than numeric characters.<br />
							<strong>integer</strong><br />
								Returns FALSE if the form element contains anything other than an integer.<br />
							<strong>is_natural</strong><br />
								Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.<br />
							<strong>is_natural_no_zero</strong><br />
								Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.<br />
							<strong>valid_email</strong><br />
								Returns FALSE if the form element does not contain a valid email address.<br />
							<strong>valid_emails</strong><br />
								Returns FALSE if any value provided in a comma separated list is not a valid email.<br />
							<strong>valid_ip</strong><br />
								Returns FALSE if the supplied IP is not valid.<br />
							<strong>valid_base64</strong><br />
								Returns FALSE if the supplied string contains anything other than valid Base64 characters.<br />
						</p>
						<h1>Prepping Reference:</h1>
						<p>
						<strong>xss_clean</strong><br />
							Runs the data through the XSS filtering function, described in the Input Class  page. <br />
						<strong>prep_for_form</strong><br />
						 	 Converts special characters so that HTML data can be shown in a form field without breaking it.<br /> 
						<strong>prep_url</strong><br />
						 	 Adds "http://" to URLs if missing. <br />
						<strong>strip_image_tags  </strong><br />
						 	  	 Strips the HTML from image tags leaving the raw URL. <br />
						<strong>encode_php_tags  </strong><br />
						 	  	 Converts PHP tags to entities.<br />
						</p> 
						<h1>Native PHP functions</h1>
						<p>You can also use any native PHP functions that permit one parameter, like  <strong>trim</strong> ,  <strong>htmlspecialchars</strong> ,  <strong>urldecode</strong> , etc.</p>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="back2db_list" value="Prev" />
					<input type="button" class="go2db_styles" value="Next" />
				</div>
			</div>
			<div class="frame"  style="display: none;">
				<div class="db_styles floatl">
				</div>
				<div class="help">
					<div>
						<h1>Select fields</h1>
						<p>
							Manipulate table fields to get the structure you are looking for. You can:
							<ul>
								<li>Change the order that fields are shown by drad and droping them</li>
								<li>Delete the fields you dont need in result form. Press right click and choose Delete in the context menu</li>
								<li>Edit field names that will be shown in result form. Press right click and choose Edit in the context menu, 
								type a new name, press right click again and choose apply to commit changes or undo to return to the original value.</li>
							</ul>
						</p>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="back2db_fields" value="Prev" />
				</div>
			</div>
		</div>
		<!--	end edit -->
		<div id="insert" style="display: none;">	
			<div class="frame">
				<div class="db_list dir floatl">
					<img src="<?php echo base_url();?>public_data/img/tools/validation.png"> <input type="text" class="filter" />
					<hr />
					<ul style="" class="jqueryFileTree">
					<?foreach($fields as $item):?>
						<li class="file ext_bat">
							<a><? echo $item?></a>
						</li>
					<?endforeach;?>	
					</ul>
				</div>
				<div class="help">
					<h1>Info</h1>
					<p>
						Select the table you want to work with 
					</p>
				</div>
				<div  class="buttons">
					<input type="button" class="go2db_fields" value="Next" />
				</div>	
			</div>
			<div class="frame"  style="display: none;">
				<div class="db_fields floatl">
				</div>
				<div class="help">
					<div>
						<h1>Select fields</h1>
						<p>
							Manipulate database table fields to get the structure you are looking for. You can:
							<ul>
								<li>Change the order that fields are shown by drad and droping them</li>
								<li>Delete the fields you dont need in result form. Press right click and choose Delete in the context menu</li>
								<li>Edit field names that will be shown in result form. Press right click and choose Edit in the context menu, 
								type a new name, press right click again and choose apply to commit changes or undo to return to the original value.</li>
								<li>Click on validation rules on the top-left form corner and select as much filter as want for desired fields</li>
							</ul>  
						</p>
					</div>
					<div style="display: none;">
						<h1>Rule Reference:</h1>
						<p>
							<strong>required</strong><br />Returns FALSE if the form element is empty.<br />
							<strong>matches</strong><br />
								<i>example: matches[form_item]</i><br />
								Returns FALSE if the form element does not match the one in the parameter. 	<br />
							<strong>min_length</strong><br />
								<i>example: min_length[6]</i><br />
								Returns FALSE if the form element is shorter then the parameter value.<br />
							<strong>max_length</strong><br />
								<i>example: max_length[12]</i><br />
								Returns FALSE if the form element is longer then the parameter value.<br />
							<strong>exact_length</strong><br />
								<i>example: exact_length[8]</i><br />
								Returns FALSE if the form element is not exactly the parameter value.<br />
							<strong>alpha</strong><br />
								Returns FALSE if the form element contains anything other than alphabetical characters.<br />
							<strong>alpha_numeric</strong><br />
								Returns FALSE if the form element contains anything other than alpha-numeric characters.<br /> 	 
							<strong>alpha_dash</strong><br />
								Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.<br />
							<strong>numeric</strong><br />
								Returns FALSE if the form element contains anything other than numeric characters.<br />
							<strong>integer</strong><br />
								Returns FALSE if the form element contains anything other than an integer.<br />
							<strong>is_natural</strong><br />
								Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.<br />
							<strong>is_natural_no_zero</strong><br />
								Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.<br />
							<strong>valid_email</strong><br />
								Returns FALSE if the form element does not contain a valid email address.<br />
							<strong>valid_emails</strong><br />
								Returns FALSE if any value provided in a comma separated list is not a valid email.<br />
							<strong>valid_ip</strong><br />
								Returns FALSE if the supplied IP is not valid.<br />
							<strong>valid_base64</strong><br />
								Returns FALSE if the supplied string contains anything other than valid Base64 characters.<br />
						</p>
						<h1>Prepping Reference:</h1>
						<p>
						<strong>xss_clean</strong><br />
							Runs the data through the XSS filtering function, described in the Input Class  page. <br />
						<strong>prep_for_form</strong><br />
						 	 Converts special characters so that HTML data can be shown in a form field without breaking it. <br />
						<strong>prep_url</strong><br />
						 	 Adds "http://" to URLs if missing. <br />
						<strong>strip_image_tags  </strong><br />
						 	  	 Strips the HTML from image tags leaving the raw URL. <br />
						<strong>encode_php_tags  </strong><br />
						 	  	 Converts PHP tags to entities.<br />
						</p> 
						<h1>Native PHP functions</h1>
						<p>You can also use any native PHP functions that permit one parameter, like  <strong>trim</strong> ,  <strong>htmlspecialchars</strong> ,  <strong>urldecode</strong> , etc.</p> 
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="back2db_list" value="Prev" />
					<input type="button" class="go2db_styles" value="Next" />
				</div>
			</div>
			<div class="frame"  style="display: none;">
				<div class="db_styles floatl">
				</div>
				<div class="help">
					<div>
						<h1>Select fields</h1>
						<p>
							Manipulate table fields to get the structure you are looking for. You can:
							<ul>
								<li>Change the order that fields are shown by drad and droping them</li>
								<li>Delete the fields you dont need in result form. Press right click and choose Delete in the context menu</li>
								<li>Edit field names that will be shown in result form. Press right click and choose Edit in the context menu, 
								type a new name, press right click again and choose apply to commit changes or undo to return to the original value.</li>
							</ul>
						</p>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="back2db_fields" value="Prev" />
				</div>
			</div>
		</div>
		<!--	end insert -->
		<ul id="myMenu" class="contextMenu">
		    <li class="edit">
		        <a href="#edit">Edit</a>
		    </li>
		    <li class="copy">
		        <a href="#copy">Copy</a>
		    </li>
		    <li class="delete">
		        <a href="#delete">Delete</a>
		    </li>
		    <li class="undo oculto">
		        <a href="#undo">Undo</a>
		    </li>
		    <li class="apply oculto">
		        <a href="#apply">Apply</a>
		    </li>
		    <li class="quit separator">
		        <a href="#quit">Quit</a>
		    </li>
		</ul>
		<ul id="moreValidations" class="contextMenu">
		    <li class="addV">
		        <a href="#required">Required</a>
		    </li>
		    <li class="addV">
		        <a href="#matches[field_name]" class="submenu">matches</a>
				<ul class="contextMenu">
					<li class="addSubV"><a href="#matches[a]">opt a</a></li>
					<li class="addSubV"><a href="#matches[b]">opt b</a></li>
				</ul>
		    </li>
		    <li class="addV">
		        <a href="#min_length[n]">min_length</a>
		    </li>
		    <li class="addV">
		        <a href="#exact_length[n]">exact_length</a>
		    </li>
		    <li class="addV">
		        <a href="#valid_email">valid_email</a>
		    </li>
		    <li class="addV">
		        <a href="#valid_emails">valid_emails</a>
		    </li>
		    <li class="addV">
		        <a href="#valid_ip">valid_ip</a>
		    </li>
		    <li class="addV">
		        <a href="#valid_base64">valid_base64</a>
		    </li>
		    <li class="addV">
		        <a href="#xss_clean">XSS clean</a>
		    </li>
		    <li class="quit separator">
		        <a href="#quit">Quit</a>
		    </li>
		</ul>
	</div>
	<div id="assets" style="display: none;">
		<ul class="btnTabs idTabs">
			<li ><a href="#base">Base configuration</a></li>
			<li ><a href="#javascript">Javascript</a></li>
			<li ><a href="#css">Css</a></li>
			<li ><a href="#header">Header</a></li>
			<li ><a href="#footer">Footer</a></li>
		</ul>
		<input type="checkbox" class="checkbox" id="enable_preview" value="1" /> Enable file preview
		<div id="base" class="rblock">
			<div id="masterview_list" class="dir floatl" >
				<ul class="jqueryFileTree">
				<?php foreach($masterview as $item) { ?>
					<li class="file conf">
						<a rel="masterview/<?php echo $item;?>	">
							<?php echo $item;?>			
						</a>
					</li>
				<?php }//endforeach  ?>
				</ul>
			</div>
			<div id="masterview_select" class="dir" >
				<ul class="jqueryFileTree ui-sortable">
					<li class="file conf"><?php echo $masterview[0];?><input type="hidden" value="<?php echo $masterview[0];?>" name="masterview"></li>
				</ul>
			</div>
		</div>
		<div id="javascript" class="rblock">
			<div id="js_list" class="dir floatl" ></div>
			<div id="js_select" class="dir" >
				<ul class="jqueryFileTree"></ul>
			</div>
		</div>
		<div id="css" class="rblock">
			<div id="css_list"  class="dir floatl"></div>
			<div id="css_select" class="dir" >
				<ul class="jqueryFileTree"></ul>
			</div>
		</div>	
		<div id="header" class="rblock">
			<div id="header_list"  class="dir floatl"></div>
			<div id="header_select" class="dir" >
				<ul class="jqueryFileTree"></ul>
			</div>
		</div>			
		<div id="footer" class="rblock">
			<div id="footer_list"  class="dir floatl"></div>
			<div id="footer_select" class="dir" >
				<ul class="jqueryFileTree"></ul>
			</div>
		</div>
	</div>
	<div id="finish" style="display: none;">
		<div class="dir floatl">
			<table>
				<tr>
					<td>Controller path</td>
					<td>
						<input type="text" name="url" value="demo"/>
					</td>
				</tr>
				<tr>
					<td>Action</td>
					<td>
						<select name="action" style="width:255px;">
							<option value="create">Create files</option>
							<option value="show">Just show code in browser</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><br /></td>
				</tr>
				<tr>
					<td style="vertical-align: super;">Options</td>
					<td>
						<div <?php if(count($templates) < 2) { ?> style="display:none;" <?php }//endif ?>>
						Template: 
						<select name="template" style="width: 183px;">
						<?php foreach($templates as $template) { ?>
							<option value="<?php echo $template;?>">
								<?php echo $template;?>
							</option>
						<?php }//endforeach ?>
						</select>
						</div>
						Create model 
						<select name="model"  id="cmodel" style="width:163px;">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<div style="display:none;">
							Model name: <input type="text"name="modelname" value="myModel" style="width:158px;float:right;"/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="text-align:center;margin-top:15px;">
							<input type="submit" value="send"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="help">
			<h1>Controller path</h1>
			<p>
				Type the container folder where files will reside (If it does not exist it will be created).
				<strong>Note: </strong> If selected folder has any file matching new files name they will be rewritted  
			</p>
			<h1>Action</h1>
			<p>
				Choose between create files or just show their content in the screen
			</p>
		</div>
	</div>
	<ul id="preview" class="oculto">
	    Loading...
	</ul>
</form>