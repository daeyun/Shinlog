<?php

/*

Constants:
	ADDRESS
	DESCRIPTION
	MAIN_TITLE
	NAME

Content:
	$edit_content
		['id'],
		['title'],
		['content'],
		['author_id'],
		['type'],
		['permalink'],
		['excerpt'],
		['status'],
		['date'],
		['comments_allowed'],
		['social_media']
*/

if(isset($edit_content)){
	$edit_mode=true;
	//print_r($edit_content);
	
}else{
	$edit_mode=false;
}
$showeditor=true;
include "inc/views/inc/header.php";
?>

<form method="post" id="postform" action="http://<?php echo ADDRESS; ?>/admin/<?php if(isset($edit_mode) and $edit_mode) {echo "edit/".$edit_content['id'];} else { echo "new/save"; } ?>">
	<div class="content">

	
	<input type="text" class="title" name="title" size="60" value="<?php if(isset($edit_mode) and $edit_mode) echo str_replace('"',"&quot;",$edit_content['title']); ?>" /><br />
	<textarea id="body" name="body"><?php
	if(isset($edit_content['content'])){ 
		$html_content = str_replace("<", "[", $edit_content['content']);
		$html_content = str_replace(">", "]", $html_content);
		echo $html_content;
	}
	?></textarea>

	
	<link href="http://<?php echo ADDRESS; ?>/STE/SimpleTextEditor.css" rel="stylesheet" type="text/css" />
	<script>
		//document.getElementById("body").value="<p>testdd<font></p>";
	</script>
	<script src="http://<?php echo ADDRESS; ?>/STE/SimpleTextEditor.js"></script>
	
	<script>
		var ste = new SimpleTextEditor("body", "ste");
		ste.cssFile = 'http://<?php echo ADDRESS; ?>/css/style.css';
		ste.charset = 'utf-8';
		ste.path = "http://<?php echo ADDRESS; ?>/STE/";
		ste.init();
	</script>
	</div> <!-- end of content -->
	
	
	<div class="sidebar1"> 
 
		<ul class="xoxo"> 
		
			
			
			<h3 class="widget-title">Status</h3> 
			<select name="status">
				<option value="0" <?php if(isset($edit_content["status"]) and $edit_content["status"]=="0") print "SELECTED"; ?>>Draft</option>
				<option value="2" <?php if(isset($edit_content["status"]) and $edit_content["status"]=="2") print "SELECTED"; ?>>Private</option>
				<option value="1" <?php if(isset($edit_content["status"]) and $edit_content["status"]=="1") print "SELECTED"; ?>>Published</option>
				<option value="3" <?php if(isset($edit_content["status"]) and $edit_content["status"]=="3") print "SELECTED"; ?>>Deleted</option>
			</select>
			<br /><br />
			
			<h3 class="widget-title">Tags</h3> 
			<input type="text" id="tags" name="tags" size="25" value="<?php
                        if(isset($edit_content["id"])){
                            
                            $first=true;
                            $q=$database->query("SELECT tl.tag FROM sl_tags tl INNER JOIN sl_tag_connections tc ON tc.tag_id = tl.id WHERE tc.post_id =".$edit_content["id"]);
                            while($temp_row=$database->fetch_array($q)){
                                if($first==false){
                                    echo ', ';
                                }else{
                                    $first=false;
                                }
                                echo str_replace('"', "&quot;", $temp_row['tag']);
                            }
                        }
                        ?>" />
			<br /><br />
			
			
			
			<h3 class="widget-title">Level</h3> 
			<select id="level" name="level">
				<option value="0" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="0") print "SELECTED"; ?>>0</option>
				<option value="1" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="1") print "SELECTED"; ?>>1</option>
				<option value="2" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="2") print "SELECTED"; ?>>2</option>
				<option value="3" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="3") print "SELECTED"; ?>>3</option>
				<option value="4" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="4") print "SELECTED"; ?>>4</option>
				<option value="5" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="5") print "SELECTED"; ?>>5</option>
				<option value="6" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="6") print "SELECTED"; ?>>6</option>
				<option value="7" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="7") print "SELECTED"; ?>>7</option>
				<option value="8" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="8") print "SELECTED"; ?>>8</option>
				<option value="9" <?php if(isset($edit_content["level"]) and $edit_content["level"]=="9") print "SELECTED"; ?>>9</option>
			</select>
			<br /><br />
			
			
			
			<div id="toggle-advanced-options">Advanced Options <span>[+]</span></div>
			<div id="advanced-options">
		
				<h3 class="widget-title">Date</h3> 
				<input type="text" id="date" name="date" disabled="disabled" size="26" value="<?php 
				
				if(isset($edit_content["date"]))
				{
					print $edit_content["date"];
				}else{
					echo date("Y-m-d H:i:s"); 
				}
				?>" />
				<input type="checkbox" id="datecheckbox" name="datecheckbox">
				<br /><br />
				
				<h3 class="widget-title">Comments</h3> 
				<select name="comments">
					<?php
					$option1="";
					$option0="";
					if(isset($edit_content["comments_allowed"]) and $edit_content["comments_allowed"]=="1"){
						$option1= "SELECTED";
					}else{
						$option0= "SELECTED";
					}
					?>
					<option value="1" <?php echo $option1; ?>>Allowed</option>
					<option value="0" <?php echo $option0; ?>>Not Allowed</option>
				</select>
				<br /><br />
				
				<h3 class="widget-title">Social Media</h3> 
				<select name="social-media">
				<?php
				$option1="";
				$option0="";
				if(isset($edit_content["social_media"]) and $edit_content["social_media"]=="1"){
					$option1= "SELECTED";
				}else{
					$option0= "SELECTED";
				}
				?>
					<option value="1" <?php echo $option1; ?>>Show</option>
					<option value="0" <?php echo $option0; ?>>Hidden</option>
				</select>
				<br /><br />
				
				<h3 class="widget-title">Type</h3> 
				<select name="type">
					<?php
					$option0="";
					$option1="";
					$option2="";
					if(isset($edit_content["type"]) and $edit_content["type"]=="0"){
						$option0= "SELECTED";
					}else if(isset($edit_content["type"]) and $edit_content["type"]=="1"){
						$option1= "SELECTED";
					}else if(isset($edit_content["type"]) and $edit_content["type"]=="2"){
						$option2= "SELECTED";
					}
					?>
					<option value="0" title="displayed on the main page and recent posts list" <?php echo $option0; ?>>Post</option>
					<option value="1" title="a post that is not displayed on the main page" <?php echo $option1; ?>>Note</option>
					<option value="2" title="hidden" <?php echo $option2; ?>>Page</option>
				</select>
				<br /><br />
				
				<h3 class="widget-title">Permalink</h3> 
				<input type="text" id="permalink" disabled="disabled" name="permalink" size="28" value="<?php if(isset($edit_content["permalink"])) print $edit_content["permalink"]; ?>" />
				<input type="checkbox" id="permalinkcheckbox" name="permalinkcheckbox">
				<br /><br />
			
			</div>
			
			
			<br /><br />
			<input type="submit" value="Save" onclick="ste.submit();">

		</ul> 
	</div>
	
	
</form>
</div>  <!-- end of container -->
</body>
</html>
