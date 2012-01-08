<?php
if((strpos($_SERVER['HTTP_USER_AGENT'],'FeedBurner')!==false) or (strpos($_SERVER['HTTP_USER_AGENT'],'FeedValidator')!==false)){ // unless user agent contains the word FeedBurner
	$q=$database->query("SELECT id,date,title,html_content,permalink from sl_posts WHERE type=0 and status=1 ORDER BY date DESC LIMIT 0,10");
	while($row=$database->fetch_array($q)){
			$row["date"] = date("D, d M Y H:i:s O", strtotime($row["date"]));
				$items_array[]=$row;
	}
	unset($item); // this is important because of the &
	include "inc/views/rss2.php";
}else{
	header('Location: http://feeds.feedburner.com/'.FEEDBURNER_ID); // redirect to FeedBurner feed
}
exit(); //prevents caching
?>
