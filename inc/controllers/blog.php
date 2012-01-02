<?php 

if(isset($not_found) and $not_found==true){ // if $not_found is set and true
	require "inc/views/404.php";
	exit();
}

$q=$database->query("SELECT title, permalink from sl_posts WHERE (type=0 OR type=1) AND status=1 ORDER BY date DESC LIMIT 0,10");
while($row=$database->fetch_array($q)){
	$recent_posts_array[]=$row;
}

if($req[0]==""){ //main
	$show_post=true;
	$show_post_permalink="home";
}else if($req[0]=="home" and !isset($req[1])){
	header('Location: http://'.ADDRESS.'/'); // Redirect
}else if($req[0]=="blog" and !isset($req[1])){ //blog page
	$show_posts=true;
	$show_posts_query="SELECT id,date,title,html_content,permalink from sl_posts WHERE type=0 AND status=1 ORDER BY date DESC LIMIT 0,3";
}else if($req[0]=="tag" and isset($req[1])){
	$req[1]=str_replace("-", " ", $req[1]);
	$q=$database->query("SELECT sl_posts.title, sl_posts.permalink, sl_posts.date FROM sl_tags, sl_tag_connections, sl_posts WHERE sl_posts.status=1 AND sl_tags.tag='".mysql_real_escape_string($req[1])."' AND sl_tags.id=sl_tag_connections.tag_id AND sl_tag_connections.post_id=sl_posts.id ORDER BY sl_posts.id DESC");
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
	header("Location: https://www.google.com/#&q=site:shin.ws+".urlencode(urldecode($req[1])));
	exit(); //prevents caching
}else{ //normal post/page view
	$show_post=true;
	$show_post_permalink=$req[0];
}


if(isset($show_post) and $show_post==true){
    if(isset($is_admin) and $is_admin==true){
        $q=$database->query("SELECT id,date,title,html_content,permalink,level,widget_visibility from sl_posts WHERE (status!=3) AND permalink='".mysql_real_escape_string($show_post_permalink)."' ORDER BY date DESC LIMIT 1");
    }else{
        $q=$database->query("SELECT id,date,title,html_content,permalink,level,widget_visibility from sl_posts WHERE status=1 AND permalink='".mysql_real_escape_string($show_post_permalink)."' ORDER BY date DESC LIMIT 1");
    }
    while($row=$database->fetch_array($q)){
		$row["date"] = date("F j, Y", strtotime($row["date"]));
		$widget_visibility=str_split($row["widget_visibility"]);
		$wv_temp=array();
		foreach($widget as $key=>$w){
			if(isset($widget_visibility[$key]) and $row["widget_visibility"]!=""){
				$wv_temp[]=($widget_visibility[$key]=="1")?1:0;
			}else{
				$check=($w[1]==1)?1:0;
			}
		}
		$row["widget_visibility"]=$wv_temp;
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
}else if(isset($show_posts) and isset($show_posts_query) and $show_posts==true){
	$q=$database->query($show_posts_query);
	while($row=$database->fetch_array($q)){
		$row["date"] = date("F j, Y", strtotime($row["date"]));
		$posts_array[]=$row;
	}
	require "inc/views/posts-full.php";
}



?>
