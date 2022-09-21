<?php 
$source_id    	= 3;
$category 	  	= 'all';
$sub_category 	= 'all';
$limit 			= 5;
$wid_title 		= 'Best of Katy Perry';
$more_url 		= source_video_url($source_id,get_source_title_by_id($source_id));

require'pagebody_widget_content.php';
?>