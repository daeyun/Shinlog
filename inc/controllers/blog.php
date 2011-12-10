<?php 

if(isset($not_found) and $not_found==true){ // if $not_found is set and true
	require "inc/views/404.php";
	exit();
}

$q=$database->query("SELECT title, permalink from sl_posts WHERE (type=0 OR type=1) AND status=1 ORDER BY date DESC");
while($row=$database->fetch_array($q)){
	$recent_posts_array[]=$row;
}

if($req[0]==""){ //main
	
	$q=$database->query("SELECT id,date,title,content,permalink from sl_posts WHERE type=0 AND status=1 ORDER BY date DESC");
	while($row=$database->fetch_array($q)){
		$row["date"] = date("F j, Y", strtotime($row["date"]));
		$posts_array[]=$row;
	}

	require "inc/views/posts-full.php";
}else if($req[0]=="tag" and isset($req[1])){
	$req[1]=str_replace("-", " ", $req[1]);
	$q=$database->query("SELECT sl_posts.title, sl_posts.permalink, sl_posts.date FROM sl_tags, sl_tag_connections, sl_posts WHERE sl_posts.status=1 AND (sl_posts.type=0 OR sl_posts.type=1) AND sl_tags.tag='".mysql_real_escape_string($req[1])."' AND sl_tags.id=sl_tag_connections.tag_id AND sl_tag_connections.post_id=sl_posts.id ORDER BY sl_posts.id DESC");
	while($row=$database->fetch_array($q)){
		$row["date"] = date("m-d-Y", strtotime($row["date"]));
		$posts_array[]=$row;
	}
	if(isset($posts_array)){
		$title="Tag Archives: <span>$req[1]</span>";
		require "inc/views/posts-list.php";
	}else{
		require "inc/views/404.php";
		exit();
	}
}else if($req[0]=="search" and isset($req[1])){
	echo "search page";
}else{ //normal post/page view
    if(isset($is_admin) and $is_admin==true){
        $q=$database->query("SELECT id,date,title,content,permalink,comments_allowed,social_media,level from sl_posts WHERE (status=1 OR status=2) AND permalink='$req[0]' ORDER BY date DESC LIMIT 1");
    }else{
        $q=$database->query("SELECT id,date,title,content,permalink,comments_allowed,social_media,level from sl_posts WHERE status=1 AND permalink='$req[0]' ORDER BY date DESC LIMIT 1");
    }
    while($row=$database->fetch_array($q)){
		$row["date"] = date("F j, Y", strtotime($row["date"]));
		$posts_array[]=$row;
	}
	
	if(isset($posts_array)){
		foreach($posts_array as &$item){ // notice the &. it lets you modify array's elements
			$q=$database->query("SELECT tl.tag FROM sl_tags tl INNER JOIN sl_tag_connections tc ON tc.tag_id = tl.id WHERE tc.post_id =".$item['id']);
			while($temp_row=$database->fetch_array($q)){
                $item['tags'][]=$temp_row['tag'];
			}
  
            //while($temp_row=$database->fetch_array($q)){
            //    $temp_array[]=$temp_row['tag'];
			//}
            
            //if(isset($temp_array)){
            //    $item['tags']=$temp_array;
            //    unset($temp_array);
            //}
		}
		unset($item); // this is important because of the &
		unset($temp_row);
	
		require "inc/views/post.php";
	}else{
		require "inc/views/404.php";
	}
}




?>
