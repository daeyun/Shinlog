	<div class="navbar">
        <ul>
			<li>
				<a href="http://<?php echo ADDRESS; ?>/" title="Home">Home</a>
			</li>
			<li>
				<a href="http://<?php echo ADDRESS; ?>/projects" title="Projects">Projects</a>
			</li>
			<?php /*<li>
				<a href="http://www.twitter.com/daeyunshin" title="Twitter">Twitter <span>(@DaeyunShin)</span></a>
			</li> */
			?>
			<li>
				<a href="http://<?php echo ADDRESS; ?>/feed" title="Subscribe">Subscribe</a>
			</li>
         
			<li id="search">
				<form role="search" method="get" id="searchform" action="#" >
					<input type="text" value="Search" name="s" id="s" onfocus="clearField('s', 'Search')" />
				</form>
			</li>
        </ul>
    </div>