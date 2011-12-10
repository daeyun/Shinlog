<?php
/*

Constants:
	ADDRESS
	DESCRIPTION
	MAIN_TITLE
	NAME

Variables:
	$is_admin
Content:
	$posts_array
		$element
			['permalink']
			['title']
			['date']
			['content']
			['tags']
				$array_element

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
		<?php if(isset($posts_array)) foreach($posts_array as $p): ?>
		<div class="post">
			<h2 class="post-title">
				<a href="http://<?php echo ADDRESS; ?>/<?php echo sanitize_title_with_dashes($p['permalink']); ?>"><?php echo $p['title'] ?></a>
			</h2>
			<div class="post-content">
				<?php echo $p['content']; ?>
			</div>
			<div class="post-info">
				<div class="alignleft"><span class="entry-date"><?php echo $p['date'] ?></span></div>
				<div class="alignright">
					<a href="http://<?php echo ADDRESS; ?>/<?php echo sanitize_title_with_dashes($p['permalink']); ?>#comments">
						<?php 
                        //display number of comments here
						?>
					</a>
					<?php if($is_admin==true){
						echo '<a class="post-edit-link" href="http://'.ADDRESS.'/admin/edit/'.$p['id'].'">Edit</a>';
					}
					
					?>
				</div>
				<div class="clearfloat"></div>
			</div>
		</div>
		<?php endforeach; ?>
	</div> <!-- end of content -->
<?php include "inc/views/inc/sidebar.php"; ?>
<?php include "inc/views/inc/footer.php"; ?>
