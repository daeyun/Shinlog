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
			['html_content']
			['markdown_content']
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
		<div class="posts">
		<?php if(isset($posts_array)) foreach($posts_array as $p): ?>
		<div class="post">
			<h2 class="post-title">
				<a href="http://<?php echo ADDRESS; ?>/<?php echo $p['permalink']; ?>"><?php echo $p['title'] ?></a>
			</h2>
			<div class="post-content">
				<?php echo $p['html_content']; ?>
			</div>
			<div class="post-info">
				<div class="alignleft"><span class="entry-date"><?php echo $p['date'] ?></span></div>
				<div class="alignright">
					<a href="http://<?php echo ADDRESS; ?>/<?php echo $p['permalink']; ?>#comments">
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
		</div>
		<div class="blognav">
		<a class="alignleft olderposts" href="#2">Older Posts</a>
		<a class="alignright newerposts" href="#1">Newer Posts</a>
		</div>
	</div> <!-- end of content -->
<?php include "inc/views/inc/sidebar.php"; ?>
<?php include "inc/views/inc/footer.php"; ?>
