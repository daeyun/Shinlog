<?php
if(isset($_POST['logout']) AND $_POST['logout']=='yes-all' AND isset($_COOKIE["shinlog_user"])){
	session_start();
	session_unset();
	session_destroy();
	setcookie ("shinlog_user", '' , 1); //delete cookie
	if(isset($is_admin) AND $is_admin==true){
		$newMD5=getMD5(mt_rand());
		$database->query("UPDATE  sl_users SET  rand_md5 = '$newMD5' WHERE  sl_users.id =1;");
	}
	$redirect=(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'http://'.ADDRESS.'/admin';
	header("location: ".$redirect);
}else if (isset($_POST['username']) and isset($_POST['slpass']) and $_POST['slpass']!='' and $_POST['username']!='' and strlen($_POST['slpass'])<40 and strlen($_POST['username'])<40){
	$user=$_POST['username'];
	$pass=getHash($_POST['slpass']);
	
	$q=$database->query("SELECT password,name,rand_md5 from sl_users WHERE name='".mysql_real_escape_string($user)."' AND status='42' LIMIT 1");
	
	if($q=$database->fetch_array($q)){
		if($q['password'] == $pass){
			$time=time();
			$cookieString=base64_encode($q['name'].'|'.getMD5($q['name'].$time.$_SERVER['REMOTE_ADDR']).'|'.$time.'|'.getHash($q['name'].'::'.$q['rand_md5'].'::'.$q['password']));
			if(isset($_POST['slremember']) and $_POST['slremember']=="on"){
				setcookie ("shinlog_user", $cookieString, $time+60*60*24*365*5 , '/'); //  '/' makes it available to domain.tld
			}else{
				setcookie ("shinlog_user", $cookieString,0,'/'); // 0: until browser closes
			}
			//login successful. cookie is set. now redirect.
			header("location: http://".ADDRESS.'/admin');
		}else{
			//echo "wrong password";
		}
	}else{
		//echo "user does not exist";
	}
}

if(isset($is_admin) and $is_admin==true){
	if(!isset($req[1])){
		$q=$database->query("SELECT title, id from sl_posts WHERE author_id='".mysql_real_escape_string($admin_id)."' and status='2' ORDER BY date DESC");
		while($row=$database->fetch_array($q)){
			$admin_private_posts_array[]=$row;
		}
		$q=$database->query("SELECT title, id from sl_posts WHERE author_id='".mysql_real_escape_string($admin_id)."' and status='0' ORDER BY date DESC");
		while($row=$database->fetch_array($q)){
			$admin_draft_posts_array[]=$row;
		}
		$q=$database->query("SELECT title, id from sl_posts WHERE author_id='".mysql_real_escape_string($admin_id)."' and status='3' ORDER BY date DESC");
		while($row=$database->fetch_array($q)){
			$admin_deleted_posts_array[]=$row;
		}
		include "inc/views/admin-main.php";
	}else if($req[1]=="new" and !isset($req[2])){
		//starting a new page
		include "inc/views/admin-post.php";
	}else if((($req[1]=="new" and $req[2]=="save" ) or ($req[1]=="edit" and isset($req[2]))) and isset($_POST["status"]) and !isset($req[3])){
		//submitting a new or edited content
		require_once "inc/models/markdown.php";

	    if(isset($_POST["date"]) and $_POST["date"]!=""){
			$myDate=date('Y-m-d H:i:s', strtotime($_POST["date"]));
		}else{
			if($req[1]=="edit"){
				$myDate="";
			}else{
				$myDate=date("Y-m-d H:i:s");
			}
	    }
		$myTitle=$_POST["title"];
	    if(isset($_POST["permalink"]) and $_POST["permalink"]!=""){
			$myPermalink=$_POST["permalink"];
	    }else if(isset($_POST["permalink"]) and $_POST["permalink"]==""){
			$myPermalink=sanitize_title_with_dashes($myTitle);
	    }
	    $duplicate=true;
	    $number=2;
	    $myTempPermalink=$myPermalink;
	    while($duplicate){
			if($req[1]=="edit"){
				$q=$database->query("SELECT id FROM `sl_posts` WHERE id!=".$req[2]." AND permalink='".mysql_real_escape_string($myTempPermalink)."'");
			}else{
				$q=$database->query("SELECT id FROM `sl_posts` WHERE permalink='".mysql_real_escape_string($myTempPermalink)."'");
			}
			if($q=$database->fetch_array($q)){
				$myTempPermalink=$myPermalink."-".$number;
				$number++;
			}else{
				$duplicate=false;
				$myPermalink=$myTempPermalink;
			}
		}

		$count=0;
		$widget_visibility="";	
		while(isset($widget[$count])){
			if(isset($_POST["widget".$count]) and $_POST["widget".$count]=="1"){
				$widget_visibility.="1";
			}else{
				$widget_visibility.="0";
			}
			$count+=1;
		}
	    if($req[1]=="edit"){
			$queryString="UPDATE  `shinlog`.`sl_posts` SET `title` =  '".mysql_real_escape_string($myTitle)."', `html_content` =  '".mysql_real_escape_string(Markdown($_POST["body"]))."', `markdown_content` =  '".mysql_real_escape_string($_POST["body"])."', `author_id` =  '".mysql_real_escape_string($admin_id)."', `type` =  '".mysql_real_escape_string($_POST["type"])."', `permalink` =  '".mysql_real_escape_string($myPermalink)."', `status` =  '".mysql_real_escape_string($_POST["status"])."', ";
			
			if($req[1]!="edit" or $myDate!=""){
				$queryString.="`date` =  '".mysql_real_escape_string($myDate)."', "; 
			}
				
			$queryString.="`level` =  '".mysql_real_escape_string($_POST["level"])."', `widget_visibility`='{$widget_visibility}' WHERE  `sl_posts`.`id` =".$req[2];
		}else{
			$queryString="INSERT INTO `shinlog`.`sl_posts` (`id`, `title`, `html_content`, `markdown_content`, `author_id`, `type`, `permalink`, `status`, `date`, `level`, `widget_visibility`) VALUES (NULL, '".mysql_real_escape_string($myTitle)."', '".mysql_real_escape_string(Markdown($_POST["body"]))."', '".mysql_real_escape_string($_POST["body"])."', '".mysql_real_escape_string($admin_id)."', '".mysql_real_escape_string($_POST["type"])."', '".mysql_real_escape_string($myPermalink)."', '".mysql_real_escape_string($_POST["status"])."', '".mysql_real_escape_string($myDate)."', '".mysql_real_escape_string($_POST["level"])."', '{$widget_visibility}');";
		}
	    $q=$database->query($queryString);

	    if($q==1){
			if($req[1]=="edit"){
				$postID=$req[2];
			}else{
				$postID=mysql_insert_id();
			}
		    $tag_array=explode(',',mysql_real_escape_string($_POST["tags"]));
		    $tag_array=array_filter($tag_array); //filters false, null, or blank items
		    $tag_array=array_iunique($tag_array);
			$DBtags=array();
			if(isset($tag_array) and count($tag_array)>0){
				$queryString="SELECT `tag` FROM `sl_tags` WHERE ";
				$first=true;
				foreach($tag_array as &$tag){
					$tag=trim($tag);
					if($first){
						$first=false;
					}else{
						$queryString.=" OR ";
					}
					$queryString.="tag='".$tag."'";
				}
				unset($tag);
				$q=$database->query($queryString);
				while($row=$database->fetch_array($q)){
					$DBtags[] = mysql_real_escape_string($row["tag"]); //without escaping $row["tag"], it won't be able to compare escapable tag names
				}
			}
		    if(isset($DBtags)){
				$newTags = array_udiff($tag_array, $DBtags, 'strcasecmp');
		    }else{
				$newTags = $tag_array;
		    }
		    if(isset($DBtags)){
				$queryString="SELECT tag FROM sl_tag_connections, sl_tags WHERE sl_tag_connections.tag_id = sl_tags.id AND sl_tag_connections.post_id = '".mysql_real_escape_string($req[2])."'"; //$req[2] is the post id
		    	$q=$database->query($queryString);

		    	while($row=$database->fetch_array($q)){
		    		$DBtags_current[]=mysql_real_escape_string($row["tag"]);
				}
				if(isset($DBtags_current)){
					$updatableTags = array_udiff($DBtags, $DBtags_current, 'strcasecmp');
					$deletedTags = array_udiff($DBtags_current,$DBtags,  'strcasecmp');
				}else{
					$updatableTags = $DBtags;
				}
		    }

			if(isset($updatableTags) and count($updatableTags)>0){
				$queryString="UPDATE `sl_tags` SET `connection_count`=`connection_count`+1 WHERE ";
				$first=true;
				foreach($updatableTags as $tag){
					if($first){
						$first=false;
					}else{
						$queryString.=" OR ";
					}
					$queryString.="`tag`='$tag'";
				}
				$q=$database->query($queryString);
			}

		    if($req[1]=="edit"){
				if(isset($deletedTags) and count($deletedTags)>0){
					$queryString="UPDATE `sl_tags` SET `connection_count`=`connection_count`-1 WHERE ";
					$queryString2="DELETE FROM `sl_tag_connections` WHERE `sl_tag_connections`.`post_id` = ".$postID." AND `sl_tag_connections`.`tag_id` = ANY (SELECT `id` FROM `sl_tags` WHERE ";
					$first=true;
					foreach($deletedTags as $tag){
						if($first){
							$first=false;
						}else{
							$queryString.=" OR ";
							$queryString2.=" OR ";
						}
						$queryString.="`tag`='$tag'"; 
						$queryString2.="`tag`='$tag'"; 
					}
					$queryString2.=" )";
					$q=$database->query($queryString);
					$q=$database->query($queryString2);
				}

				$database->query("DELETE FROM `sl_tags` WHERE `connection_count` <= 0");
			}	

		    if(isset($newTags) and count($newTags)>0){
				$queryString="INSERT INTO `shinlog`.`sl_tags` (`id`, `tag`, `connection_count`) VALUES ";
				$first=true;
				foreach($newTags as $tag){
					if($first){
						$first=false;
					}else{
						$queryString.=", ";
					}
					$queryString.="(NULL, '$tag', '1')"; 
				}
				$q=$database->query($queryString);
		    }
			if(isset($updatableTags) and isset($newTags)){
				$newConnTags=array_merge($newTags,$updatableTags);
			}else if(isset($updatableTags)){
				$newConnTags=$updatableTags;	
			}else if(isset($newTags)){
				$newConnTags=$newTags;	
			}
		    if(isset($newConnTags) and count($newConnTags)>0){
				$queryString="SELECT `id` FROM `sl_tags` WHERE ";
				$first=true;
				foreach($newConnTags as $tag){
					if($first){
						$first=false;
					}else{
						$queryString.=" OR ";
					}
					$queryString.="`tag`='$tag'"; 
				}
				$q=$database->query($queryString);
				while($row=$database->fetch_array($q)){
					$tag_ids[] = $row["id"];
				}
		    }
		    if(isset($tag_ids) and count($tag_ids)>0){
				$queryString="INSERT INTO `shinlog`.`sl_tag_connections` (`id`, `post_id`, `tag_id`) VALUES ";
				$first=true;
				foreach($tag_ids as $id){
					if($first){
						$first=false;
					}else{
						$queryString.=", ";
					}
					if($req[1]=="edit"){
						$queryString.="(NULL, '".$req[2]."', '$id')";
					}else{
						$queryString.="(NULL, '".$postID."', '$id')"; //id is NULL because it will be automatically assigned by mysql
					}
				}
				$q=$database->query($queryString);
		    }
			
			//updates caching time
			if(isset($dir)){
				$filePath=$dir."/cache/cachetime";
				$fh = fopen($filePath, 'w') or die("cannot open cachetime file");
				fwrite($fh, time());
				fclose($fh);
			}
			if(isset($_POST["ajax"]) and $_POST["ajax"]=="true"){
				echo "successful";
				exit();
			}else{
				header("location: http://".ADDRESS."/admin/edit/".$postID); // Redirect to the new uri
			}

	    }
	    
	}else if($req[1]=="edit" and !isset($req[2])){
	    
	}else if($req[1]=="edit" and isset($req[2]) and !isset($req[3])){ //viewing a page to be edited. $req[2] is post id
		$post_id=$req[2];
		$q=$database->query("SELECT * FROM sl_posts WHERE id = '".mysql_real_escape_string($post_id)."' LIMIT 1");
		$edit_content=$database->fetch_array($q);
		include "inc/views/admin-post.php";
	}else{
		exit();
	}
}else if(isset($is_admin) AND $is_admin==false){
	include "inc/views/admin-login.php";
}
?>
