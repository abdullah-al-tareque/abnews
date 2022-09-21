<!-- Social media starts -->
        <div class="tb-social pull-right">
            <div class="brand-bg text-right">
                <!-- Brand Icons -->
                <a target="_blank" href="https://www.facebook.com/" class="facebook"><i class="fa fa-facebook square-2 rounded-1"></i></a>
                <a target="_blank" href="https://twitter.com/" class="twitter"><i class="fa fa-twitter square-2 rounded-1"></i></a>
                <a target="_blank" href="https://plus.google.com/" class="google-plus"><i class="fa fa-google-plus square-2 rounded-1"></i></a>
                <a  target="_blank" href="#" class="linkedin"><i class="fa fa-linkedin square-2 rounded-1"></i></a>
                <a target="_blank" href="#" class="pinterest"><i class="fa fa-pinterest square-2 rounded-1"></i></a>
            
            
            
                <?php if(!is_loggedin()){?>
                        <?php if(get_settings('global_settings','enable_signup','Yes')=='Yes'){?>
                       
                            <a class="signup" href="<?php echo site_url('account/signupform');?>"><?php echo lang_key('signup')?></a>
                      
                        <?php }?>

                       
                            <a class="signin" href="#"><?php echo lang_key('signin');?></a>
                      
                        <?php }else{ ?>
                        <?php if(is_admin() || is_moderator()){?>
                        
                            <a class="signup" href="<?php echo site_url('admin');?>"><?php echo lang_key('user_panel');?></a>
                      
                        <?php }else if(is_generaluser()){?>
                        
                            <a class="signup" href="<?php echo site_url('admin/editprofile');?>"><?php echo lang_key('user_panel');?></a>
                       
                        <?php }?>
                        
                            <a class="signup" href="<?php echo site_url('account/logout');?>"><?php echo lang_key('logout');?></a>
                       
                        <?php }?>
            
            
            
            </div>
        </div>
        <!-- Social media ends -->