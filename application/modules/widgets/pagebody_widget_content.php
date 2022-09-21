<?php
//file updated on version 1.4
$CI = get_instance();
$CI->load->model('admin/video_model');
$video_query = $CI->video_model->get_videos_by_source_category_subcategory($source_id,$category,$sub_category,$limit);

?>
<div class="block-heading-two">
    <div class="body-widget-title"><span><i class="fa fa-folder"></i> <?php echo $wid_title;?></span>
	    <div class="view-all-category-top">
	    	<a href="<?php echo $more_url;?>"><?php echo lang_key('view_all');?></a>
	    </div>
    </div>
</div>
<div class="row">
	<?php 
	if($video_query->num_rows()<=0)
	{
	?>
	<div class="col-lg-12">
		<div class="alert alert-info"><?php echo lang_key('no_videos_found');?></div>
	</div>
	<?php
	}
	else
	{
		$video_array = $video_query->result_array();

		$main_video = $video_array[0];
		$main_video_url = post_detail_url($main_video);
		$main_video_source = get_source_title_by_id($main_video['source_id']);

		#added on version 1.4
	    $main_video_source_url 	= source_video_url($main_video['source_id'],$main_video_source);
	    $main_video_date_url 		= date_video_url($main_video['publish_time']);

		unset($video_array[0]);
	?>
	<div class="col-md-6 col-sm-6 col-xs-12 main-news">
		<article>
					
				<a class="image-link" title="<?php echo $main_video['title'];?>" href="<?php echo $main_video_url;?>">
					<div class="itemsContainer page-body-widget-main-img">					
					<img title="<?php echo $main_video['title'];?>" alt="<?php echo $main_video['title'];?>" class="img-responsive main-news-image" src="<?php echo $main_video['media'];?>">						
					<div class="play"></div>
					</div>
				</a>
				
				<div class="main-news-meta">

					<span class="news-by">
						<span class="news-by-title">
						<?php echo lang_key('video_by');?>:
						</span>
						<span class="news-by-body">
						 <a href="<?php echo $main_video_source_url;?>"><?php echo $main_video_source;#added on version 1.4?></a>
						</span>
					</span>

					<span class="news-by">
						<span class="news-by-title">
							<?php echo lang_key('on');?>: 
						</span>
						<span class="news-by-body">						
							<a href="<?php echo $main_video_date_url;?>"><?php echo translateable_date($main_video['publish_time']);#added on version 1.4?></a>
						</span>	
					</span>
														
					<span class="news-by comments">
						<span class="news-by-title">
							<?php echo lang_key('seen_by');?>: 
						</span>
						
						<span class="news-by-body">						
							<a href="<?php echo $main_video_url;?>"><i class="fa fa-eye"></i><?php echo $main_video['total_view'];?></a>
						</span>
					</span>					
				</div>
				
				<h2 class="main-news-title"><a title="<?php echo $main_video['title'];?>" href="<?php echo $main_video_url;?>"><?php echo $main_video['title'];?></a></h2>
				
				<div class="excerpt">
					<p>
					<?php echo truncate(strip_tags($main_video['description']),100,'&nbsp;<a href="'.$main_video_url.'">...'.lang_key('view_more').'</a>',false);?>
					</p>
				</div>
				
		</article>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12 news-lists v-separator">
		<div class="s-widget">
			<div class="widget-content hot-properties">
			<ul class="list-unstyled">
				<?php 
				foreach ($video_array as $videos)
				{
					$videos_url = post_detail_url($videos);
					$videos_source = get_source_title_by_id($videos['source_id']);
					$source_url 	= source_video_url($videos['source_id'],$videos_source);
				    $date_url 		= date_video_url($videos['publish_time']);
				?>
	            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                
	                <a href="<?php echo $videos_url;?>">
	                	<div class="itemsContainer">
		                	<img alt="<?php echo $videos['title'];?>" src="<?php echo $videos['media'];?>" class="img-responsive img-thumbnail">
		                	<div class=" play-small"></div>
	                	</div>
	                </a>
	                <div class="sub-head"><a href="<?php echo $videos_url;?>">
	                	<?php echo $videos['title'];?>
	                </a></div>
	                <!-- Price -->
	                <div class="price">
						<span class="news-by">
							<span class="news-by-title">
								<?php echo lang_key('on');?>: 
							</span>
							<span class="news-by-body">
								<a href="<?php echo $date_url;?>"><?php echo translateable_date($videos['publish_time'])?></a>
							</span>
						</span>
	                	<span class="news-by">
							<span class="news-by-title">
								<?php echo lang_key('video_by');?>:
							</span>
							<span class="news-by-body">
								<a href="<?php echo $source_url;?>"><?php echo $videos_source;?></a>
							</span>
						</span>
	                </div>
	                <div class="clearfix"></div>
	            </li>
	            <?php
		        }
	            ?>          	            	            
            </ul>
	        </div>            
	    </div>
	</div>
<?php 
	}
?>	
</div>
<hr class="separator">
<script type="text/javascript">
$(function(){
    $(".news-lists .list-unstyled").mCustomScrollbar();
});

</script>
