<?php 
$source_id    = 'all';
$category 	  = 'all';
$sub_category = 'all';
$limit = 5;

$CI = get_instance();
$CI->load->model('admin/video_model');
$video_query = $CI->video_model->get_videos_by_source_category_subcategory($source_id,$category,$sub_category,$limit);
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-building color"></i>&nbsp; <?php echo lang_key('latest_videos');?></h5>
    <!-- Widgets Content -->
    <div class="widget-content hot-properties">
        <?php if($video_query->num_rows()<=0){?>
        <div class="alert alert-info"><?php echo lang_key('no_posts');?></div>
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