<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
	<meta charset="UTF-8" /> 
	<title><?php if (backtrace_filename_includes('post.php')){
		if((isset($req[0]) and $req[0]!="") and isset($posts_array[0]['title'])){
			if($posts_array[0]['title']!=""){
				echo $posts_array[0]['title']." - ".ADDRESS;
			}else{
				echo ADDRESS;
			}
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
	<link href="http://<?php echo ADDRESS; ?>/js/vendor/google-code-prettify/prettify.css" rel="stylesheet" type="text/css" /> 
	<link rel="shortcut icon" href="http://<?php echo ADDRESS; ?>/favicon.ico" /> 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/script.js"></script> 
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/vendor/google-code-prettify/prettify.js"></script> 
	<?php if(backtrace_filename_includes('posts-full.php')){ ?>
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/vendor/underscore-min.js"></script> 
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/vendor/backbone-min.js"></script> 
	<script type="text/javascript" src="http://<?php echo ADDRESS; ?>/js/blog_navigation_backbone.js"></script>
	<script type="text/template" id="post">
		<div class="post">
			<h2 class="post-title">
				<a href="http://<?php echo ADDRESS; ?>/<%= permalink %>"><%= title %></a>
			</h2>
			<div class="post-content"><%= html_content %></div>
			<div class="post-info">
				<span class="entry-date"><%= date %></span>
			</div>
		</div>
	</script>
	<?php } ?>

<?php if(isset($is_admin) AND $is_admin){ ?>
	<link href="http://<?php echo ADDRESS; ?>/css/admin.css" rel="stylesheet" type="text/css" /> 
	<script src="http://<?php echo ADDRESS; ?>/js/admin.js"></script>
	<script src="http://<?php echo ADDRESS; ?>/js/plugins/jquery.hotkeys.js"></script>
<?php } ?>
</head> 
 
<body> 
<div class="container">
	<?php if(widgetCheck(0,&$posts_array[0]["widget_visibility"],&$widget)){ ?> 
	<div class="header"> 
		<a href="http://<?php echo ADDRESS; ?>/"><img src="http://<?php echo ADDRESS; ?>/img/shin.ws.gif" alt="<?php echo NAME; ?>"  class="logo"/></a> 
		<?php if(isset($is_admin) AND $is_admin){
			echo '<form method="post" class="alignright" action="http://'.ADDRESS.'/admin"><input type="hidden" name="logout" value="yes-all" /><input type="submit" value="'.$admin_name.'" /></form>';
		}
		?>
		<div class="tagline"><?php if(!isset($admin_mode) OR !$admin_mode) echo DESCRIPTION; ?></div> 
	</div>
	<?php } ?>
