<!-- Social media starts -->
        <div class="tb-social pull-right">
            <div class="brand-bg text-right">
                <!-- Brand Icons -->
               

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
                        echo '<a class="facebook" target="_blank" href="'.$facebook_url.'"><i class="fa fa-facebook square-2 rounded-1"></i></a>';   
                }
                if($youtube_url){
                    echo '<a class="youtube" target="_blank" href="'.$youtube_url.'"><i class="fa fa-youtube square-2 rounded-1"></i></a>';   
                }
                if($twitter_url){
                echo '<a class="twitter" target="_blank" href="'.$twitter_url.'"><i class="fa fa-twitter square-2 rounded-1"></i></a>';   
                    }
                if($linkedIn_url){
                    echo '<a class="linkedin" target="_blank" href="'.$linkedIn_url.'"><i class="fa fa-linkedin square-2 rounded-1"></i></a>';   
                        }
                if($pinterest_url){
                echo '<a class="pinterest" target="_blank" href="'.$pinterest_url.'"><i class="fa fa-pinterest square-2 rounded-1"></i></a>';   
                    }
                if($google_url){
                        echo '<a class="google-plus" target="_blank" href="'.$google_url.'"><i class="fa fa-google-plus square-2 rounded-1"></i></a>';   
                            }
                if($instagram_url){
                    echo '<a class="instagram" target="_blank" href="'.$instagram_url.'"><i class="fa fa-instagram square-2 rounded-1"></i></a>';   
                        }
                ?>

            
                <?php if(!is_loggedin()){?>
                        <?php if(get_settings('global_settings','enable_signup','Yes')=='Yes'){?>
                       
                            <a class="hidden signup" href="<?php echo site_url('account/signupform');?>"><?php echo lang_key('signup')?></a>
                      
                        <?php }?>

                       
                            <a class="hidden signin" href="#"><?php echo lang_key('signin');?></a>
                      
                        <?php }else{ ?>
                        <?php if(is_admin() || is_moderator()){?>
                        
                            <a class="hidden signup" href="<?php echo site_url('admin');?>"><?php echo lang_key('user_panel');?></a>
                      
                        <?php }else if(is_generaluser()){?>
                        
                            <a class="hidden signup" href="<?php echo site_url('admin/editprofile');?>"><?php echo lang_key('user_panel');?></a>
                       
                        <?php }?>
                        
                            <a class="hidden signup" href="<?php echo site_url('account/logout');?>"><?php echo lang_key('logout');?></a>
                       
                        <?php }?>
            
            
            
            </div>
        </div>
        <!-- Social media ends -->