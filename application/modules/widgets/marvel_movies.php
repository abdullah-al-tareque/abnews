<?php 
$source_id    	= 1;
$category 	  	= 'all';
$sub_category 	= 'all';
$limit 			= 15;
$wid_title 		= 'Marvel movies';
$more_url 		= source_video_url($source_id,get_source_title_by_id($source_id));

require'pagebody_widget_content.php';
?>