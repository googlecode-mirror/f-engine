<h1>Welcome to F-engine</h1>
<p>
    F-engine is an Application Development Framework - a toolkit - for people who build web sites using PHP.
    Its goal is to enable you to develop projects much faster than you could if you were writing code
    from scratch, by providing a rich set of libraries and web based applications for commonly needed tasks, 
	as well as a simple interface and logical structure to access these libraries. 
	F-engine lets you creatively focus on your project by minimizing the amount of code needed for a given task.
</p>

<div style="width:325px;float:left;">
	<h2>Create a new project</h2>
	<form method="post" action="<?php echo site_url();?>tools/newproject" />
	<?php  if (is_really_writable(ROOTPATH) == 1) { ?>

		Project name:
		<input type="text" name="projectname" />

		<input type="submit" value="send" style="text-align:right;: 40px;" />
		
	<?php } else {
			
			echo ROOTPATH.' directory <strong>must be writable</strong>'; 
		
	} //endif ?>
	</form>
</div>
<div style="float:left; padding-left:50px ;width: 500px;">
	<h2>My projects</h2>
	<ul>
		<?php  foreach($myprojects as $project) { ?>
		<li><a href="<?php  echo base_url().'../'.$project?>"><?php  echo $project;?></a></li>
		<?php } //endforeach ?>
	</ul>
</div>