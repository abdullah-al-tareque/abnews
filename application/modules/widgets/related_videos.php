<?php 
$category 	  = 'all';
$source_id    = 'all';
$sub_category = 'all';
$limit = 5;

$CI = get_instance();
$CI->load->model('admin/video_model');
if($CI->uri->segment(1)!='video')
{
	echo 'This widget is not for this page';
}
else
{
	$video_id = $CI->uri->segment(2);
	$video = $CI->video_model->get_video_by_id($video_id);
	if($video->num_rows()>0)
	{
		$row = $video->row();
		$v_query = $CI->video_model->get_similar_videos_by_category($row->category, $row->sub_category, $row->id);
	}
	?>
	<div class="s-widget">
	    <!-- Heading -->
	    <h5><i class="fa fa-building color"></i>&nbsp; <?php echo lang_key('related_videos');?></h5>
	    <!-- Widgets Content -->
	    <div class="widget-content hot-properties">
	        <?php if($v_query->num_rows()<=0){?>
	        <div class="alert alert-info"><?php echo lang_key('no_posts');?></div>
	        <?php }else{?>
	        <ul class="list-unstyled">
	            <?php 
	            foreach ($v_query->result() as $post) {
	            ?>
	            <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
	                <!-- Image -->
	                <a href="<?php echo post_detail_url($post);?>"><img class="img-responsive img-thumbnail" src="<?php echo $post->media;?>" alt="<?php echo $post->title;?>" /></a>
	                <!-- Heading -->
	                <h4><a href="<?php echo post_detail_url($post);?>"><?php echo $post->title;?></a></h4>
	                <div class="clearfix"></div>
	            </li>
	            <?php 
	            }
	            ?>
	        </ul>
	        <?php }?>
	    </div>
	</div>
	<div style="clear:both"></div>
<?php
}
?>	