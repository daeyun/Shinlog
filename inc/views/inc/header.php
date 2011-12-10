<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
	<meta charset="UTF-8" /> 
	<title><?php if (backtrace_filename_includes('post.php')){
		if(isset($posts_array[0]['title'])){
			echo $posts_array[0]['title']." - ".ADDRESS;
		}else{
			echo MAIN_TITLE;
		}
	}else if(backtrace_filename_includes('posts-list.php')){
		echo strip_tags($title);
	}else{
		echo MAIN_TITLE;
	}
	?></title> 
	<link href="http://<?php echo ADDRESS; ?>/css/reset.css" rel="stylesheet" type="text/css" /> 
	<link href="http://<?php echo ADDRESS; ?>/css/style.css" rel="stylesheet" type="text/css" /> 
	<link rel="shortcut icon" href="http://<?php echo ADDRESS; ?>/favicon.ico" /> 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/script.js"></script> 
	<?php if(isset($is_admin) AND $is_admin AND isset($showeditor)){
		?>
		<link href="http://<?php echo ADDRESS; ?>/css/admin.css" rel="stylesheet" type="text/css" /> 
		<script src="http://<?php echo ADDRESS; ?>/js/admin.js"></script>
		<?php }
	?>
</head> 
 
<body> 
<div class="container"> 
	<div class="header"> 
		<a href="http://<?php echo ADDRESS; ?>/"><img src="http://<?php echo ADDRESS; ?>/img/shinlog.gif" alt="<?php echo NAME; ?>"  class="logo"/></a> 
		<?php if(isset($is_admin) AND $is_admin){
			echo '<form method="post" class="alignright" action="http://'.ADDRESS.'/admin"><input type="hidden" name="logout" value="yes-all" /><input type="submit" value="'.$admin_name.'" /></form>';
		}
		?>
		<div class="tagline"><?php echo DESCRIPTION; ?></div> 
		
	</div>