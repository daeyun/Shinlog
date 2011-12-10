<?php
/*

Constants:
	ADDRESS
	DESCRIPTION
	MAIN_TITLE
	NAME

Variables:
	$is_admin
	$title
Content:
	$posts_array
		$element
			['permalink']
			['title']
			['date']

Sidebar:
	$recent_posts_array
		$element
			['permalink'],
			['title']
			
	
	
*/
include "inc/views/inc/header.php";
include "inc/views/inc/navbar.php";
?>
	<div class="content">
		<div class="list">
			<h2 class="list-title">
				<?php echo $title; ?>
			</h2>
			<div class="list-content">
				<ul>
				<?php foreach($posts_array as $p): ?>
					<li><a href="http://<?php echo ADDRESS ?>/<?php echo $p['permalink']; ?>"><?php echo $p['title']; ?></a><span><?php echo $p['date']; ?></span></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div> <!-- end of content -->
<?php include "inc/views/inc/sidebar.php"; ?>
<?php include "inc/views/inc/footer.php"; ?>