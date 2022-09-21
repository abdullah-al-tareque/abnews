<?php 
$source_id    	= 'all';
$category 	  	= 1;
$sub_category 	= 3;
$limit 			= 20;
$wid_title 		= 'Top music tracks';
$more_url 		= category_video_url($sub_category,get_category_title_by_id($sub_category));

require'pagebody_widget_content.php';
?>