<?php if(widgetCheck(1,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
	<div class="sidebar1"> 
		<ul class="sidebar_list"> 
			<?php if(widgetCheck(6,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
			<li>
				<div class="about-me">
				<img class="gravatar" src="http://www.gravatar.com/avatar/e6a3d0d92de965529fa0a8d92be0e689.png" />
				Hi, I'm Daeyun Shin. I'm a <a href="http://en.wikipedia.org/wiki/Computer_engineering">Computer Engineering</a> student at <a href="http://en.wikipedia.org/wiki/Uiuc">UIUC</a>. 
				<div class="clearfloat"></div>
				</div>
			<li>
			<?php } ?>
			<?php if(widgetCheck(7,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
			<li><h3 class="widget-title">Recent Posts</h3> 
				<ul> 
					<?php if(isset($recent_posts_array)) foreach($recent_posts_array as $recent): ?>
					<li><a href="http://<?php echo ADDRESS; ?>/<?php echo $recent['permalink'] ?>"><?php echo $recent['title'] ?></a></li>		
					<?php endforeach; ?>
				</ul> 
			</li> 
			<?php } ?>
 
		</ul> 
	</div>
<?php } ?>
