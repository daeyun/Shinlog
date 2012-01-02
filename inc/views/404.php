<?php
header('HTTP/1.0 404 Not Found'); 
$not_found=true;
include "inc/views/inc/header.php";
include "inc/views/inc/navbar.php";
?>
	<div class="container">
	<div class="content">
		<div class="post">
			<h2 class="post-title">Page Not Found</h2>
			<div class="post-content">
				Sorry, the page you are looking for does not exist.
				<img src="http://i.imgur.com/B0OEC.jpg" />
			</div>
		</div>
	</div> <!-- end of content -->
<?php //include "inc/views/inc/sidebar.php"; ?>
<?php include "inc/views/inc/footer.php"; ?>
