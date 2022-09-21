<link rel="stylesheet"  href="<?php echo theme_url();?>/assets/css/jquery.marquee.min.css" property="">
<script type='text/javascript' src='<?php echo theme_url();?>/assets/js/jquery.marquee.min.js'></script>
<style type="text/css">

</style>
<div class="row marquee-holder">
	<div class="col-md-1 col-sm-2 col-xs-3 marquee-heading">
		<?php echo lang_key('latest_videos');?>:
	</div>
	<div class="col-md-11 col-sm-10 col-xs-9 marquee-body">
		<?php 
		$source_id    = 'all';
		$category 	  = 'all';
		$sub_category = 'all';
		$limit = 10;

		$CI = get_instance();
		$CI->load->helper('text');
		$CI->load->model('admin/video_model');
		$video_query = $CI->video_model->get_videos_by_source_category_subcategory($source_id,$category,$sub_category,$limit);
		?>
		<ul id="marquee" class="marquee" data-direction="<?php echo ($rtl)?'right':'left';?>" dir="ltr">
		  <?php foreach ($video_query->result() as $video) {
		  ?>
			  <li>
			  	<span class="news-by-main">
				    <span class="marquee-news-title">"<?php echo word_limiter($video->title,15);?>"</span> <a href="<?php echo post_detail_url($video);?>"><?php echo lang_key('more');?></a>
			    </span>
			    <?php 
			    $source_name 	= get_source_title_by_id($video->source_id);
			    $source_url 	= source_video_url($video->source_id,$source_name);
			    $date_url 		= date_video_url($video->publish_time);
			    ?>
			    <span class="news-by-marquee">
			    	<span class="news-by-title">
						<?php echo lang_key('video_by');?>:
					</span>
					<span class="news-by-body">
					 <a href="<?php echo $source_url;?>"><?php echo $source_name;?></a>
					</span>
				</span>

				<span class="news-by-marquee">
			    	<span class="news-by-title">
						<?php echo lang_key('on');?>:
					</span>
					<span class="news-by-body">
					 <a href="<?php echo $date_url;?>"><?php echo translateable_date($video->publish_time)?></a>
					</span>
				</span>
				&nbsp;|													
			  </li>		  
		  <?php
		  }
		  ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
	$('#marquee').marquee({pauseOnHover: true,duration: 9000});
</script>