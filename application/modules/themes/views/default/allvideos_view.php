   
<!-- Container -->
<div class="container">
<h2>
        <?php if(isset($icon) && $icon!=''){?>
        <i class="fa <?php echo $icon;?>"></i>&nbsp;
        <?php }?>
        <?php echo (isset($title))?$title:'';?> <span>&nbsp;</span>
       
       
        </h2> 
    <div class="blog-one">
        <div class="row">

            <div class="col-md-9 col-sm-12 col-xs-12">

                <?php
                if($posts->num_rows()<=0){
                    ?>
                    <div class="alert alert-warning"><?php echo lang_key('post_not_found'); ?></div>
                <?php
                }
                else
                    foreach($posts->result() as $videos){
                        $videos_url = post_detail_url($videos); 
                        $title = $videos->title;
                        $desc = $videos->description;
                        ?>

                        <!-- Blog item starts -->
                        <div class="blog-one-item row">
                            <!-- blog One Img -->
                            <div class="blog-one-img col-md-3 col-sm-3 col-xs-12">
                                <!-- Image -->
                                <a href="<?php echo $videos_url;?>">
                                    <div class="itemsContainer">
                                        <img src="<?php echo $videos->media;?>" alt="" class="img-responsive img-thumbnail" style="width:100%" />
                                        <div class="play-mid"></div>                                        
                                    </div>
                                </a>
                            </div>
                            <!-- blog One Content -->
                            <div class="blog-one-content  col-md-9 col-sm-9 col-xs-12">
                                <!-- Heading -->
                                <h3><a href="<?php echo $videos_url;?>"><?php echo $title;?></a></h3>
                                <!-- Blog meta -->
                                <div class="blog-meta">
                                    <!-- Author -->
                                   
                                    <!-- Date -->
                                    <i class="fa fa-calendar"></i> &nbsp; <a href="<?php echo date_video_url($videos->publish_time);?>"><?php echo translateable_date($videos->publish_time); ?></a>

                                </div>
                                <!-- Paragraph -->
                                <p><?php echo truncate(strip_tags($desc),100,'&nbsp;<a href="'.$videos_url.'">...'.lang_key('view_more').'</a>',false);?></p>
                            </div>
                        </div>
                        <!-- Blog item ends -->
                    <?php } ?>
                <?php render_widgets('all_videos_page');?>    
                <ul class="pagination">
                    <?php echo (isset($pages))?$pages:'';?>
                </ul>


            </div>


            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <?php render_widgets('right_bar_all_videos');?>
                </div>
            </div>

        </div>
    </div>

</div> 
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53fb1205151cc4cf"></script>