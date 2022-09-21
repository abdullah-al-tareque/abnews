<?php
$CI = get_instance();
$CI->load->model('show/post_model');
$parent_categories = $CI->post_model->get_all_parent_categories();
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-folder color"></i>&nbsp; <?php echo lang_key('categories') ?></h5>
    <!-- Widgets Content -->

    <div class="widget-content categories">
        <ul class="list-6">
            <?php
            $i = 0;
            foreach ($parent_categories->result() as $parent) {
            $i++;
            $main_category_url = category_video_url($parent->id,$parent->title);
            ?>
                <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                    <a href="<?php echo $main_category_url;?>">
                        <?php echo lang_key($parent->title); ?> 
                        <span dir="rtl" class="color">(<?php echo count_videos_by_category($parent->id);?>)</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="clearfix"></div>