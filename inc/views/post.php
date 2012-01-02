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
			['id'],
			['date'],
			['title'],
			['html_content'],
			['permalink'],
			['level'],
			['widget_visibility'][]

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
		<?php foreach($posts_array as $p): ?>
		<div class="post">
			<?php if(widgetCheck(4,&$posts_array[0]["widget_visibility"],&$widget)){ ?>			
			<h1 class="post-title">
				<?php echo $p['title'] ?>
			</h1>
			<?php } ?>
			<?php if(widgetCheck(5,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
			<div class="entry-date"><?php echo $p['date'] ?></div>
			<?php } ?>
			<div class="post-content">
				<?php echo $p['html_content']; ?>
			</div>
			<div class="post-info">
				<?php if($is_admin==true){ ?>
					<div class="alignright">
						<a class="post-edit-link" href="http://<?php echo ADDRESS; ?>/admin/edit/<?php echo $p['id']; ?>">Edit</a>
					</div>
					<div class="clearfloat"></div>
				<?php } ?>
				
				<?php if(widgetCheck(10,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
				<div class="tags">
					<?php  if(isset($p['tags'])) foreach($p['tags'] as $tag): ?>
						<a class="tag alignleft" href="http://<?php echo ADDRESS; ?>/tag/<?php echo str_replace(" ", "-", $tag) ?>"><?php echo $tag ?></a>
					<?php endforeach; //display tags ?>
				</div>
				<?php } ?>
				<div class="clearfloat"></div>
			</div>
		</div>
		<?php if(widgetCheck(8,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
		<div class="comments">
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    var disqus_shortname = 'daeyun'; // required: replace example with your forum shortname
                    var disqus_identifier = '<?php echo $p['id']; ?>';
                    var disqus_url = 'http://<?php echo ADDRESS."/".$p['permalink']; ?>';
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the comments.</noscript>
        </div>
		<?php } ?>
		<?php endforeach; ?>
	</div> <!-- end of content -->
<?php include "inc/views/inc/sidebar.php"; ?>
<?php include "inc/views/inc/footer.php"; ?>
