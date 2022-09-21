<!-- file added on version 1.4 -->
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.carousel.css">
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.theme.default.min.css">


    <div id="owl-demo">
       <?php 
        $limit = 10;

        $CI = get_instance();
        $CI->load->model('admin/video_model');
        $top_instead_featured = get_settings('global_settings','top_videos_instead_featured','No');
        if($top_instead_featured=='No')
        $video_query = $CI->video_model->get_featured_videos($limit);
        else
        $video_query = $CI->video_model->get_popular_videos($limit);
      
      foreach ($video_query->result() as $post) {              
      ?>
      <div class="item">
        <div class="img-wrapper">
            <img src="<?php echo $post->media;?>" alt="Owl Image">
            <!--span class="source-label"><a href="<?php echo source_video_url($post->source_id,get_source_title_by_id($post->source_id));?>"><?php echo get_source_title_by_id($post->source_id);?></a></span-->
        </div>
        <div class="info-wrapper">
        <h2><a href="<?php echo post_detail_url($post);?>"><?php echo $post->title;?></a>
        </h2>        
        
        </div>
      </div>     
      <?php }?>
    </div>


<script src="<?php echo theme_url();?>/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript">
    

    $(document).ready(function() {
     
      $("#owl-demo").owlCarousel({
     
          rtl:rtl,
          loop:true,
          autoplay: false,
          margin:5,
          responsive:{
              0:{
                  items:1
              },
              600:{
                  items:3
              },
              1000:{
                  items:6
              }
          }

     
      });
     
    });


</script>