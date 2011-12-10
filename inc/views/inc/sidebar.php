	<div class="sidebar1"> 
 
		<ul class="xoxo"> 
			<li><h3 class="widget-title">Recent Posts</h3> 
				<ul> 
					<?php if(isset($recent_posts_array)) foreach($recent_posts_array as $recent): ?>
					<li><a href="http://<?php echo ADDRESS; ?>/<?php echo sanitize_title_with_dashes($recent['permalink']) ?>"><?php echo $recent['title'] ?></a></li>		
					<?php endforeach; ?>
				</ul> 
			</li> 
 
		</ul> 
		
	</div>
