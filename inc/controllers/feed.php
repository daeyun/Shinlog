<?php

if(strpos($_SERVER['HTTP_USER_AGENT'],'FEEDBURNER_ID')==false){ // unless user agent contains the word FeedBurner
	header('Location: http://feeds.feedburner.com/'.FEEDBURNER_ID); // redirect to FeedBurner feed
	exit;
}

$q=$database->query("SELECT id,date,title,content,permalink from sl_posts WHERE type=0 ORDER BY date DESC");
while($row=$database->fetch_array($q)){
	$row["date"] = date("D, d M Y H:i:s O", strtotime($row["date"]));
	$items_array[]=$row;
}

unset($item); // this is important because of the &
include "inc/views/rss2.php";

?>