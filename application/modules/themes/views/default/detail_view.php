<script type="text/javascript">
    var switchTo5x=true;
    var url = "http://w.sharethis.com/button/buttons.js";
    $.getScript( url, function() {
        stLight.options({publisher: "14ee463c-2587-4a82-9bf6-73dad7fc1c93", doNotHash: false, doNotCopy: false, hashAddressBar: false});
    });
</script>
<style type="text/css">

</style>
<?php 
$main_video = $post->row_array();
$main_video_url = post_detail_url($main_video);
$source_name = get_source_title_by_id($main_video['source_id']);
$CI = get_instance();
$CI->load->model('admin/content_model');
$source = $CI->content_model->get_source_data_by_id($main_video['source_id']);
$main_source_url = source_video_url($main_video['source_id'],$source_name);
?>


<div class="container">
        <h2><?php echo $main_video['title'];?></h2>        
        <div class="clearfix"></div>
    <!-- Actual content -->
    <div class="rs-property">
        <!-- Block heading two -->
        
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">

                <article  itemscope="">
                    

                    <!--a class="image-link" title="<?php echo $main_video['title'];?>" href="">
                        <img title="<?php echo $main_video['title'];?>" alt="<?php echo $main_video['title'];?>" class="img-responsive main-news-image" src="<?php echo $main_video['media'];?>">                      
                    </a-->
                    <div class="video-container">
                    <?php 
                    $auto_play = get_settings('global_settings','autoplay_video','Yes');
                    $autoplay_video = ($auto_play=='Yes')?1:0;
                    $rel_videos = ($this->config->item('show_related_video_on_player')!='')?$this->config->item('show_related_video_on_player'):0;
                    ?>
					<iframe allowfullscreen id="ytplayer" type="text/html" width="640" height="360" src="https://www.youtube.com/embed/<?php echo $main_video['youtube_id'];?>?rel=<?php echo $rel_videos;?>&amp;autoplay=<?php echo $autoplay_video;?>&amp;modestbranding=1" frameborder="0"></iframe>


                    </div>

                    <div class="main-news-meta">
                        <span class="news-by hidden">
                            <span class="news-by-title">
                                <?php echo lang_key('video_by');?>:
                            </span>
                            <span class="news-by-body">
                                <a href="<?php echo $main_source_url;?>"><?php echo $source_name;?></a>
                            </span>
                        </span>

                        <span class="news-by">
                            <span class="news-by-title">
                                <?php echo lang_key('on');?>:
                            </span>
                            <span class="news-by-body">
                                <a href="<?php echo $main_video_url;?>"><?php echo translateable_date($main_video['publish_time'])?></a>
                            </span>
                        </span>
                                                            
                        <span class="comments news-by">
                            <span class="news-by-title">
                                <?php echo lang_key('seen_by');?>:
                            </span>
                            <span class="news-by-body">
                                <a href="<?php echo $main_video_url;?>"><i class="fa fa-eye"></i> <?php echo $main_video['total_view'];?></a>
                            </span>
                        </span>                 
                    </div>
                    
                    <h2 class="main-news-big-title"><a title="<?php echo $main_video['title'];?>" href="#"><?php echo $main_video['title'];?></a></h2>
                    
                    <div class="excerpt">
                        <p class="detail">

<!-- Optional script that automatically makes iframe content responsive. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.14/iframeResizer.min.js"></script>
<script>iFrameResize({}, '.button-api-frame');</script>
                        
                        <?php 
                            if((isset($source->grab_full_news) && $source->grab_full_news==1) || $main_video['manual_creation']==1 )
                                $description = $main_video['full_description'];
                            else
                                $description = $main_video['description'];

                            $description = str_replace('<a href="https://blockads.fivefilters.org">Let\'s block ads!</a>', '', $description);
                            echo str_replace('<a href="https://github.com/fivefilters/block-ads/wiki/There-are-no-acceptable-ads">(Why?)</a>', '',$description);
                        ?>
                        </p>
                        <p>
                            <?php 
                            if($main_video['tags']!=''){
                                ?>
                                <div style="font-weight:bold"><?php echo lang_key('tags');?>:</div>
                                <?php
                                $tags = explode(',', $main_video['tags']);
                                foreach ($tags as $tag) {
                                    $tag_url = site_url('show/searchvideos/plainkey='.$tag.'|');
                                ?>
                                <a href="<?php echo $tag_url;?>">#<?php echo $tag;?></a>&nbsp;
                                <?php
                                }
                            }
                            ?>
                        </p>
                    </div>
                
                    
                    <div class="share-links">
                        <span class='st_sharethis_hcount'></span>
                        <span class='st_facebook_hcount'></span>
                        <span class='st_twitter_hcount'></span>
                        <span class='st_linkedin_hcount'></span>
                        <span class='st_pinterest_hcount'></span>
                        <span class='st_email_hcount'></span>
                    </div>

                    <?php //render_widgets('detail_page');?>

                    <?php

                                $comment_settings = get_settings('global_settings', 'enable_comment', 'No');
                                if($comment_settings == 'Disqus Comment')
                                { 
                                    $disqus_shortname = get_settings('global_settings', 'disqus_shortname', '');

                                ?>
                                <div id="disqus_thread"></div>
                                <script type="text/javascript">
                                    var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname

                                    (function() {
                                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                <div class="clearfix"></div>
                                
                                <?php 
                                } 
                                ?>

                                <?php 

                                if($comment_settings == 'Facebook Comment')
                                { 
                                    $fb_app_id = get_settings('global_settings', 'fb_comment_app_id', ''); ?>
                                    <style>
                                        .fb-comments, .fb-comments iframe[style] {width: 100% !important;}
                                    </style>
                                    <div id="fb-root"></div>
                                    <script>
                                        var fb_app_id = '<?php echo $fb_app_id; ?>';

                                        (function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s); js.id = id;
                                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=" + fb_app_id + "&version=v2.7";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));
                                    </script>

                                    <div style="clear:both;margin-top:10px;"></div>
                                    <div class="fb-comments" data-href=" <?php echo current_url();?>" data-numposts="10" data-colorscheme="light"></div>

                                <?php 
                                } 
                                ?>

                </article>

            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 sidebar">
                

                    <?php render_widgets('right_bar_detail');?>
               
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.stButton .stFb, .stButton .stTwbutton, .stButton .stMainServices{ height: 23px; } .stButton .stButton_gradient{ height: 23px; }
</style>