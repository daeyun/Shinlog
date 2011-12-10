<?php
header('Content-type: application/xml'); 
/*

Constants:
	SITE_address
	SITE_description
	SITE_main_title
	SITE_name


Content:
	$items_array
		$array_element
			['id'],
			['permalink'],
			['title'],
			['date'],
			['content'],
			['tags']
				$array_element

Note: posts are in DESC order
*/
echo '<?xml version="1.0" encoding="UTF-8"?>';
?> 
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	> 

<channel> 
	<title><?php echo SITE_name; ?></title> 
	<atom:link href="http://<?php echo SITE_address; ?>/feed/" rel="self" type="application/rss+xml" /> 
	<link><?php echo SITE_address; ?></link> 
	<description><?php echo SITE_description; ?></description> 
	<lastBuildDate>Sun, 20 Feb 2011 10:49:16 +0000</lastBuildDate> 
	<language>en</language> 
	<sy:updatePeriod>hourly</sy:updatePeriod> 
	<sy:updateFrequency>1</sy:updateFrequency> 
	
	<?php foreach($items_array as $item): ?>
	<item>
		<title><?php echo $item['title'] ?></title>
		<link>http://<?php echo SITE_address; ?>/<?php echo $item['permalink'] ?>/</link>
		<comments>http://<?php echo SITE_address; ?>/<?php echo $item['permalink'] ?>/#comments</comments>
		<pubDate><?php echo $item['date'] ?></pubDate>

		<content:encoded><![CDATA[ <?php echo $item['content'] ?> ]]></content:encoded>
	</item>
	<?php endforeach; ?>
	
	
	</channel>
</rss>