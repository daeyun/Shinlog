<?php
require_once 'inc/config.php';
$REQUEST_URI=$_SERVER["REQUEST_URI"];
$req_uri=isset($REQUEST_URI) ? $REQUEST_URI:null;
$dir=dirname(__FILE__);
//$starttime= microtime(TRUE);
if($temp=strpos($req_uri,'?'))
	$req_uri=substr($req_uri, 0, $temp); //ignore ? and the following substring
if($temp=strpos($req_uri,'//'))
	$req_uri=substr($req_uri, 0, $temp); //ignore everything after consecutive slashes
if(substr($req_uri, -1) == '/' AND $req_uri!='/') //if the last character is a slash
	$req_uri=substr($req_uri,0,-1); // remove last character
if(substr($req_uri, 0,10)=='/index.php') // if it starts with /index.php
	$req_uri='/';
	
$will_redirect=($REQUEST_URI!=$req_uri);
if($will_redirect){
    header('Location: http://'.ADDRESS.$req_uri); // Redirect to the new uri
    exit();
}

$req_uri=substr($req_uri, 1); //remove the slash at the begining
$req=explode('/',$req_uri);
$cacheFile = $dir."/cache/html/tmp_".str_replace("/"," ",$req_uri);
$cacheTime=(int)file_get_contents($dir."/cache/cachetime");

if(!isset($_COOKIE["shinlog_user"]) and $req[0]!="admin" and file_exists($cacheFile) and $cacheTime<filemtime($cacheFile)){
	include($cacheFile);
}else{
	ob_start();
	require_once "inc/models/MySQL.php";
	require_once "inc/models/formatting.php";
	require_once "inc/models/functions.php";
	$database = new MySQLDatabase();

	foreach($req as $r){
		if(preg_match('/[^A-Za-z0-9\_\-\.\@\+\,\%\^\!\'\"]/',$r)){
			require "inc/views/404.php";
			exit();
		}
	}

	$is_admin=false;
	if(isset($_COOKIE["shinlog_user"])){
		$delete_cookie=true;
		$cookieVar=explode('|',mysql_real_escape_string(base64_decode($_COOKIE["shinlog_user"])));
		if(strlen($cookieVar[0])<50){
			$q=$database->query("SELECT id,password,name,rand_md5 from sl_users WHERE name='".$cookieVar[0]."' AND status='42' LIMIT 1");
			if($q=$database->fetch_array($q)){
				$serverUserHash=getHash($q['name'].'::'.$q['rand_md5'].'::'.$q['password']);
				if(getMD5($cookieVar[0].$cookieVar[2].mysql_real_escape_string($_SERVER['REMOTE_ADDR']))==$cookieVar[1] AND $serverUserHash==$cookieVar[3]){
					//time()-$cookieVar[2] is the time (in seconds) passed since the cookie was set
					//cookie format: name|MD5|time|sha256
					//MD5 contains name.time.IP
					$is_admin=true;
					$admin_name=$q['name'];
					$admin_id=$q['id'];
					$delete_cookie=false; //keep cookie
				}
			}
		}
		if($delete_cookie){
			setcookie ("shinlog_user", '' , 1);
		}
	}

	if($req[0]=="admin"){
		include "inc/controllers/admin.php";
	}else if($req[0]=="feed" and !isset($req[1])){
		include "inc/controllers/feed.php";
	}else if( $req[0]=="" or !isset($req[1]) or (($req[0]=="tag" or $req[0]=="search") and isset($req[1])) ){
		include "inc/controllers/blog.php";
	}else{ // page not found
		require "inc/views/404.php";
		exit();
	}

	if(!$is_admin and (!isset($not_found) or $not_found==false) and $req[0]!="admin" ){
		$cacheFile = $dir."/cache/html/tmp_".str_replace("/"," ",$req_uri);
		$fp = fopen($cacheFile, 'w'); 
		fwrite($fp, ob_get_contents()); 
		fclose($fp); 
		ob_end_flush(); 
	}

	if(isset($database)) $database->close_connection();
}

//if(isset($is_admin) AND $is_admin){
//	$endtime= microtime(TRUE);
//	echo '</br>'.($endtime-$starttime);
//}


?>
