<?php
@define("ADDRESS","domain.tld");
@define("NAME","name");
@define("MAIN_TITLE","main title");
@define("DESCRIPTION","description");
@define("OWNER","name");

@define("FEEDBURNER_ID","feedburner id");

// Database Constants
@define("DB_SERVER", "localhost");
@define("DB_USER", "user");
@define("DB_PASS", "password");
@define("DB_NAME", "name");

date_default_timezone_set('America/Chicago');

//This is where widgets are registered.
//format: array(name,visible-by-default?)
$widget[0]=array("header",1);
$widget[1]=array("sidebar",1);
$widget[2]=array("footer",1);
$widget[3]=array("navbar",1);
$widget[4]=array("title",1);
$widget[5]=array("date",1);
$widget[6]=array("about me",1);
$widget[7]=array("recent posts",1);
$widget[8]=array("comments",1);
$widget[9]=array("social media",1);
$widget[10]=array("tags",1);
?>
