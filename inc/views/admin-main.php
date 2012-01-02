<?php

include "inc/views/inc/header.php";
?>
<div class="content">
<?php
if(isset($admin_draft_posts_array)){
	echo "<h3>Drafts</h3><ul>";
	foreach($admin_draft_posts_array as $post){
		echo '<li><a href="http://'.ADDRESS.'/admin/edit/'.$post["id"].'">'.$post["title"].'</a></li>';
	}
	echo "</ul>";
}



if(isset($admin_private_posts_array)){
	echo "<h3>Private Posts</h3><ul>";
	foreach($admin_private_posts_array as $post){
		echo '<li><a href="http://'.ADDRESS.'/admin/edit/'.$post["id"].'">'.$post["title"].'</a></li>';
	}
	echo "</ul>";
}


if(isset($admin_deleted_posts_array)){
	echo "<h3>Deleted Posts</h3><ul>";
	foreach($admin_deleted_posts_array as $post){
		echo '<li><a href="http://'.ADDRESS.'/admin/edit/'.$post["id"].'">'.$post["title"].'</a></li>';
	}
	echo "</ul>";
}


?>
</div> <!-- end of content -->
<?php include "inc/views/inc/footer.php";

?>
