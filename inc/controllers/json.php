<?php

if(isset($req[1]) and $req[1]=="blog-navbutton" and isset($req[2])){
	$q=$database->query("SELECT count(*) FROM `sl_posts` WHERE `type`=0 AND `status`=1");
	$row=$database->fetch_array($q);
	$count = (int)$row["count(*)"];
	$reqpage=(int)$req[2];
	if(is_numeric($req[2]) and strpos($req[2],'.')===false and $reqpage>0 and $count>($reqpage)*3){
		echo "1";
	}else{
		$not_found=true;
	}

}elseif(isset($req[1]) and $req[1]=="blog-page" and isset($req[2])){
	$q=$database->query("SELECT count(*) FROM `sl_posts` WHERE `type`=0 AND `status`=1");
	$row=$database->fetch_array($q);
	$count = (int)$row["count(*)"];
	$reqpage=(int)$req[2];
	if(is_numeric($req[2]) and strpos($req[2],'.')===false and $reqpage>0 and $count>($reqpage-1)*3){
		$q=$database->query("SELECT id,date,title,html_content,permalink from sl_posts WHERE type=0 AND status=1 ORDER BY date DESC LIMIT ".mysql_real_escape_string(($reqpage-1)*3).",3");
		while($row=$database->fetch_array($q)){
			$row["date"] = date("F j, Y", strtotime($row["date"]));
			$posts_array[]=$row;
		}
		echo json_encode($posts_array);
	}else{
		$not_found=true;
	}
}else{
	$not_found=true;
}

if(isset($not_found) and $not_found==true){
	header('HTTP/1.0 404 Not Found');
	exit();
}
?>
