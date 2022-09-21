<?php 
$source_id    	= 6;
$category 	  	= 'all';
$sub_category 	= 'all';
$limit 			= 20;
$wid_title 		= 'Test source';
$more_url 		= source_video_url($source_id,get_source_title_by_id($source_id));

require'pagebody_widget_content.php';
?>