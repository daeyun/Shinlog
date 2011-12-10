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
			['permalink'],
			['title'],
			['content'],
			['date'],
			['status'],
			['comments_allowed'],
			['type'],

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
			<h1 class="post-title">
				<?php echo $p['title'] ?>
			</h1>
			<div class="post-content">
				<?php echo $p['content']; ?>
			</div>
			<div class="post-info">
				<div class="alignleft"><span class="entry-date"><?php echo $p['date'] ?></span></div>
				<div class="alignright">
					<?php if($is_admin==true){
						echo '<a class="post-edit-link" href="http://'.ADDRESS.'/admin/edit/'.$p['id'].'">Edit</a>';
					}
					?>
				</div>
				<div class="clearfloat"></div>
				
				<div class="cats-and-tags">
					<?php  if(isset($p['tags'])) foreach($p['tags'] as $tag): ?>
						<a class="tag alignleft" href="http://<?php echo ADDRESS; ?>/tag/<?php echo str_replace(" ", "-", $tag) ?>"><?php echo $tag ?></a>
					<?php endforeach; //display tags ?>
				</div>
				
				<div class="clearfloat"></div>
			</div>
		</div>
		<?php if($p["comments_allowed"]=="1"){ ?>
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
