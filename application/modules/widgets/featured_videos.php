<?php 
$limit = 5;

$CI = get_instance();
$CI->load->model('admin/video_model');
$video_query = $CI->video_model->get_featured_videos($limit);
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-building color"></i>&nbsp; নির্বাচিত ভিডিও</h5>
    <!-- Widgets Content -->
    <div class="widget-content hot-properties">
        <?php if($video_query->num_rows()<=0){?>
        <div class="alert alert-info"><?php echo lang_key('no_videos');?></div>
        <?php }else{?>
        <ul class="list-unstyled">
            <?php 
            foreach ($video_query->result() as $post) {
            ?>
            <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <!-- Image -->
                <a href="<?php echo post_detail_url($post);?>">
                    <div class="itemsContainer">
                        <img class="img-responsive img-thumbnail" src="<?php echo $post->media;?>" alt="<?php echo $post->title;?>" />
                        <div class=" play-small"></div>
                    </div>
                </a>
                <!-- Heading -->
                <div class="sub-head"><a href="<?php echo post_detail_url($post);?>"><?php echo $post->title;?></a></div>
                <!-- Price -->
                <!--div class="price">
					<span class="news-by">
						<?php echo lang_key('on');?>: <a href="<?php echo $post->link;?>"><?php echo translateable_date($post->publish_time)?></a>
					</span>
                	<span class="news-by">
						<?php echo lang_key('video_by');?>: <a href="<?php echo $post->link;?>">Source Name</a>
					</span>
                </div-->
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