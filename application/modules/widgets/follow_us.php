<h5 class="bold"><i class="fa fa-rocket"></i>  Follow Us</h5>
    <div class="brand-bg">
                        <!-- Social Media Icons -->
    <?php 
    $facebook_url = get_settings('webadmin_email','facebook_url');
    $youtube_url = get_settings('webadmin_email','youtube_url');
    $twitter_url = get_settings('webadmin_email','twitter_url');
    $linkedIn_url = get_settings('webadmin_email','linkedIn_url');
    $pinterest_url = get_settings('webadmin_email','pinterest_url');
    $google_url = get_settings('webadmin_email','google_url');
    $instagram_url = get_settings('webadmin_email','instagram_url');
    
    if($facebook_url){
            echo '<a class="facebook" target="_blank" href="'.$facebook_url.'"><i class="fa fa-facebook circle-3"></i></a>';   
    }
    if($youtube_url){
        echo '<a class="youtube" target="_blank" href="'.$youtube_url.'"><i class="fa fa-youtube circle-3"></i></a>';   
    }
    if($twitter_url){
    echo '<a class="twitter" target="_blank" href="'.$twitter_url.'"><i class="fa fa-twitter circle-3"></i></a>';   
        }
    if($linkedIn_url){
        echo '<a class="linkedin" target="_blank" href="'.$linkedIn_url.'"><i class="fa fa-linkedin circle-3"></i></a>';   
            }
    if($pinterest_url){
    echo '<a class="pinterest" target="_blank" href="'.$pinterest_url.'"><i class="fa fa-pinterest circle-3"></i></a>';   
        }
    if($google_url){
            echo '<a class="google-plus" target="_blank" href="'.$google_url.'"><i class="fa fa-google-plus circle-3"></i></a>';   
                }
    if($instagram_url){
        echo '<a class="instagram" target="_blank" href="'.$instagram_url.'"><i class="fa fa-instagram circle-3"></i></a>';   
            }
    ?>
</div>

<div class="clearfix" style="height: 10px"></div>
<?php if(@file_exists('./sitemap.xml')){?>
    <h5 class="bold hidden"><i class="fa fa-sitemap"></i>  <?php echo lang_key('site_map');?></h5>
    <a href="<?php echo site_url('show/sitemap')?>" class="hidden"><?php echo lang_key('show_site_map');?></a>
<?php }?>
