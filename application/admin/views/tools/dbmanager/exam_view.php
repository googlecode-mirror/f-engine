	<div class="pagination" style="padding-bottom:5px;">
        <div style="float: left; padding-right: 10px; border-right: 1px dotted #2F3B6F;">
        	<a class="refresh" style="cursor:pointer;" href="<?php echo site_url('tools/dbmanager/ajax/view/'.$offset);?>">
        		<img style="cursor: pointer;vertical-align:middle;" title="edit this record" 
        		src="<?php echo base_url();?>public_data/img/tools/arrow_refresh.png"> 
        		Refresh
        	</a>
        </div>
        <div style="float: left;margin-left: 10px;"><?php echo $exam['paginate']; ?></div>
        <br style="clear: both;" />
    </div>

	<div id="current_query">
		<img class="oculto" src="<?php echo public_data();?>img/tools/preloader.gif" alt="loading" title="loading" style="vertical-align:sub;float:left;" />
		<span style="white-space:pre;max-height:140px;overflow-y:auto;display:block;"><?php echo preg_replace("/,(?=.*(from|where).*)/i",", ",$exam["sql"]);?></span>
		<span class="meta">(~<?php echo isset($total_rows) ? $total_rows : count($exam['query']->result()); ?> total, Query took <?php echo $exam["execution_time"]; ?> sec)</span>
	</div>

    <table border="0" cellpadding="0" cellspacing="1" style="width:100%;margin-top:10px;">
        <tr>
        	<?php if(isset($actions) && $actions == true && count($exam['query']->result()) > 0) { ?>
            <th width="<?php echo $exam['primary'] == "" ? 80:50; ?>px" class="actions">
                <center>
                	<?php if($exam['primary'] == "") { ?>

                		<img 
                		alt="This table has not any index defined. Record edition could throw unexpected results" 
                		title="This table has not any index defined. Record edition could throw unexpected results"
                		style="vertical-align:text-top;" src="<?php echo public_data("img/tools/table_error.png");?>" />

                	<?php }//endif ?>
                	Actions
                </center>
            </th>
             <?php }// end if ?>

            <?php foreach($exam['fields'] as $field): ?>
            <?php if( isset($exam['orderby']) && $exam['orderby'][0] === $field) { ?>
            <th class="<?php echo $exam['orderby'][1]; ?>">
            <?php } else { ?>
            <th>
            <?php } ?>
                <center><?php  echo $field;?></center>
            </th>
            <?php endforeach; ?>
        </tr>
        <?php if( count($exam['query']->result()) === 0) { ?>
        <tr>
        	<td colspan="<?php echo count($exam['fields']); ?>" style="text-align:center;">No result found</td>
        </tr>
        <?php } //endif ?>
        <?php foreach($exam['query']->result() as $row) { ?>
        <tr style="vertical-align:top;">
        	<?php if(isset($actions) && $actions == true) { ?>
 			<td>
                <center>
                    <form>
                        <?php if($exam['primary']) { ?>
                            <?php 
                                $tmp = explode('|',$exam['primary']);
                                $exam_keys = explode(",",$tmp[1]);
                                $exam_key = $exam_keys[0];
                                $lcase_exam_key = strtolower($exam_keys[0]);

                                foreach($exam["fields"] as $field) {

                                	if(strtolower($field) == strtolower($exam_key)) {
                                		$exam_key = $field;	
                                	}
                                }

                                //multiple indexes ? 
                                if(strpos($tmp[1],",")) {
                            ?>
									<input type="hidden" name="<?php  echo $tmp[0];?>" value="<?php  echo $tmp[1];?>" />
									<?php foreach(explode(",",$tmp[1]) as $fld) { 
										  $lcase_fld = strtolower($fld);
									?>
		                            <input type="hidden" name="<?php  echo $tmp[0];?>_value[]" value="<?php  echo isset($row->$fld) ? $row->$fld : $row->$lcase_fld;?>" />
		                            <?php }//endforeach ?>

							<?php } else { ?>

									<input type="hidden" name="<?php  echo $tmp[0];?>" value="<?php  echo $tmp[1];?>" />
		                            <input type="hidden" name="<?php  echo $tmp[0];?>_value" value="<?php  echo isset($row->$exam_key) ? $row->$exam_key : $row->$lcase_exam_key;?>" />

							<?php }//endif ?>
		                            <a href="<?php  echo site_url();?>tools/dbmanager/ajax/edit/" class="edit">
		                                <img class="delete_field" style="cursor: pointer;" title="edit this record" src="<?php  echo base_url();?>public_data/img/contextmenu/page_white_edit.png"/>
		                            </a>
		
		                            <a style="margin-left:5px;" href="<?php  echo site_url();?>tools/dbmanager/ajax/delete/" class="delete">
		                                <img class="delete_field" style="cursor: pointer;" title="delete this record" src="<?php  echo base_url();?>public_data/img/contextmenu/delete.png"/>
		                            </a>
                        <?php } else { ?>

                             <?php foreach($exam['fields'] as $field): ?>
				            	<textarea name="<?php echo $field; ?>" style="display:none;"><?php echo rawurlencode($row->$field); ?></textarea>
				            <?php endforeach; ?>

							<a href="<?php  echo site_url();?>tools/dbmanager/ajax/edit/" class="edit">
                                <img class="delete_field" style="cursor: pointer;" title="edit this record" src="<?php  echo base_url();?>public_data/img/contextmenu/page_white_edit.png"/>
                            </a>

                            <a style="margin-left:5px;" href="<?php  echo site_url();?>tools/dbmanager/ajax/delete/" class="delete">
                                <img class="delete_field" style="cursor: pointer;" title="delete this record" src="<?php  echo base_url();?>public_data/img/contextmenu/delete.png"/>
                            </a>

                        <?php } //endif?>
                    </form>
                </center>
            </td>
            <?php } //end if ?>

            <?php foreach($exam['fields'] as $field) { ?>
            <td>
            	<?php if(strlen($row->$field) > 45) { ?>
                	<span title="<?php  echo htmlspecialchars(str_replace(array("<",">"),array("&lt;","&gt;"),$row->$field));?>"><?php  echo htmlspecialchars(substr($row->$field,0,45));?></span>
                	<img class="expand" alt="expand" title="expand" style="vertical-align:sub;cursor:pointer;opacity:0.3;" src="<?php echo public_data("img/tools/eye.png");?>" />
                <?php } else { ?>
                	<span><?php  echo htmlspecialchars(substr($row->$field,0,45));?></span>
                <?php }//endif ?>
            </td>
            <?php } //endforeach; ?>
        </tr>
        <?php } //endforeach; ?>
    </table>
	<div class="pagination" style="clear: both;padding:5px 0;">
        <div style="float: left; padding-right: 10px; border-right: 1px dotted #2F3B6F;">
        	<a class="refresh" style="cursor:pointer;" href="<?php echo site_url().'tools/dbmanager/ajax/view/'.$offset;?>">
        		<img style="cursor: pointer;vertical-align:middle;" title="edit this record" 
        		src="<?php echo base_url();?>public_data/img/tools/arrow_refresh.png"> 
        		Refresh
        	</a>
        </div>
        <div style="float: left;margin-left: 10px;"><?php echo $exam['paginate']; ?></div>
    </div>