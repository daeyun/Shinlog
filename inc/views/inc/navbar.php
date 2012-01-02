<?php if(widgetCheck(3,&$posts_array[0]["widget_visibility"],&$widget)){ ?>
	<div class="navbar">
        <ul>
			<li><a href="http://<?php echo ADDRESS; ?>/" title="Home">Home</a></li>
			<li><a href="http://<?php echo ADDRESS; ?>/projects" title="Projects">Projects</a></li>
			<li><a href="http://<?php echo ADDRESS; ?>/blog" title="Blog">Blog</a></li>
			<li><a href="http://<?php echo ADDRESS; ?>/feed" title="Subscribe">Subscribe</a></li>
			<li><a href="http://<?php echo ADDRESS; ?>/contact" title="Contact">Contact</a></li>
         
			<li id="search">
				<form role="search" method="get" id="searchform" action="#" >
					<input type="text" value="Search" name="s" id="s" />
				</form>
			</li>
        </ul>
    </div>
<?php } ?>
