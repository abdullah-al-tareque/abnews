<?php
$CI = get_instance();
$CI->load->model('show/post_model');
$page_type      =  $CI->uri->segment(2);
$category_id    =  $CI->uri->segment(3);
$CI->load->database();
$CI->db->order_by('id','ASC');
$CI->db->where(array('status'=>1,'parent'=>0));
$query = $CI->db->get('categories');
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-sun-o color"></i>  ক্যাটেগরীজ</h5>
    <!-- Widgets Content -->
    <div class="widget-content hot-properties">
        <?php if($query->num_rows()<=0){?>
            <div class="alert alert-info">ক্যাটেগরীজ</div>
        <?php }else{?>
            <ul class="list-unstyled list-6">
                <?php
                foreach ($query->result() as $post) {
                	$category_url = category_video_url($post->id,$post->title);
                ?>
                    <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                        <a href="<?php echo $category_url;?>">
                            <?php echo lang_key($post->title); ?> <span dir="rtl" class="color">(<?php echo count_videos_by_category($post->id);?>)</span>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        <?php }?>
    </div>
</div>

<div style="clear:both"></div>