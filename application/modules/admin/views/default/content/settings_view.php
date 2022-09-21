<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin("site_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <?php echo validation_errors();?>
                <?php $settings = json_decode($settings);?>
                <form class="form-horizontal" action="<?php echo site_url('admin/content/savesettings/');?>" method="post">
                    


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_signup'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_signup" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_signup==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_signup_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_signup'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('moderator_can_create_post'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="moderator_can_create_post" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->moderator_can_create_post==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="moderator_can_create_post_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('moderator_can_create_post'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('generaluser_can_create_post'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="generaluser_can_create_post" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->generaluser_can_create_post==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="generaluser_can_create_post_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('generaluser_can_create_post'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('publish_posts_directly'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="publish_directly" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->publish_directly==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="publish_directly_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('publish_directly'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('auto_crawl'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="auto_crawl" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->auto_crawl==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="auto_crawl_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('auto_crawl'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('save_images_locally'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="save_images_locally" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->save_images_locally==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="save_images_locally_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('save_images_locally'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('lazy_load_images'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="lazy_load_images" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->lazy_load_images==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="lazy_load_images_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('lazy_load_images'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_cache'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_cache" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_cache==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_cache_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_cache'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_cookie_policy_popup'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_cookie_policy_popup" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_cookie_policy_popup==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_cookie_policy_popup_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_cookie_policy_popup'); ?>
                        </div>
                    </div>



                    <div class="form-group cookie-policy-settings" id="cookie_policy_page_url" style="display:none">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('cookie_policy_page_url'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="cookie_policy_page_url" value="<?php echo(isset($settings->cookie_policy_page_url))?$settings->cookie_policy_page_url:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="cookie_policy_page_url_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('cookie_policy_page_url'); ?>
                        </div>
                    </div>
                   

                    <!-- added on version 1.4 -->
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('show_source_menu'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="show_source_menu" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->show_source_menu==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="show_source_menu_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('show_source_menu'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('show_cat_menu'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="show_cat_menu" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->show_cat_menu==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="show_cat_menu_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('show_cat_menu'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_adblocker_alert'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_adblocker_alert" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_adblocker_alert==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_adblocker_alert_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_adblocker_alert'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_featured_video_carousel'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_featured_video_carousel" class="form-control">
                                <?php $options = array('None','Carousel','Slider');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_featured_video_carousel==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_featured_video_carousel_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_featured_video_carousel'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('top_videos_instead_featured'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="top_videos_instead_featured" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->top_videos_instead_featured==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="top_videos_instead_featured_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('top_videos_instead_featured'); ?>
                        </div>
                    </div>


                    <!-- added on version 1.5 -->
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('menu_type'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="menu_type" class="form-control">
                                <?php $options = array('Normal','Mega Menu');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->menu_type==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="menu_type_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('menu_type'); ?>
                        </div>
                    </div>
                    <!-- end -->
                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key_admin('youtube_app_settings');?></div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('yt_api_key'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">
                            <input type="text" name="yt_api_key" value="<?php echo(isset($settings->yt_api_key))?$settings->yt_api_key:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="yt_api_key_rules" value="required">
                            <span class="help-inline"><a href="//support.skywebit.com/index.php/en/show/faqdetail/32/How-to-obtain-Youtube-APi-Key" target="_blank"><?php echo lang_key('how_to_yt_api_key');?></a></span>
                            <?php echo form_error('yt_api_key'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('autoplay_video'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="autoplay_video" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->autoplay_video==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="autoplay_video_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('autoplay_video'); ?>
                        </div>
                    </div>

                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key_admin('facebook_app_settings');?></div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_facebook_login'); ?></label>
                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_fb_login" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_fb_login==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_fb_login_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_fb_login'); ?>
                        </div>
                    </div>

                    <div class="form-group fb-settings" id="fb_app_id" style="display:none">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('fb_app_id'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="fb_app_id" value="<?php echo(isset($settings->fb_app_id))?$settings->fb_app_id:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="fb_app_id_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('fb_app_id'); ?>
                        </div>
                    </div>

                    <div class="form-group fb-settings" id="fb_secret_key" style="display:none">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('fb_secret_key'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="fb_secret_key" value="<?php echo(isset($settings->fb_secret_key))?$settings->fb_secret_key:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="fb_secret_key_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('fb_secret_key'); ?>
                        </div>
                    </div>

                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key('gplus_app_settings');?></div>
                    <span class="settings-help">
                        <div class="alert alert-info">
                        <a href="http://support.skywebit.com/index.php/en/show/faqdetail/26/How-to-get-google+-client-id-and-client-secret" target="_blank" data-toggle="tooltip" data-placement="left" title="Enble google+ api">[<?php echo lang_key('how_to_get_gplus_api');?>]</a><br/>
                            <?php echo lang_key('auth_redirect_url');?>: <?php echo site_url('account/google_plus_auth/auth_callback');?>
                        </div>
                    </span>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_gplus_login'); ?></label>
                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_gplus_login" class="form-control">
                                <?php $options = array('No','Yes');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->enable_gplus_login==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_gplus_login_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_gplus_login'); ?>
                        </div>
                    </div>

                    <div class="form-group gplus-settings" id="gplus_app_id">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('gplus_client_id'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="gplus_app_id" value="<?php echo(isset($settings->gplus_app_id))?$settings->gplus_app_id:'';?>" placeholder="Type somethin" class="form-control" >
                            <input type="hidden" name="gplus_app_id_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('gplus_app_id'); ?>
                        </div>
                    </div>

                    <div class="form-group gplus-settings" id="gplus_secret_key">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('gplus_client_secret'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="gplus_secret_key" value="<?php echo(isset($settings->gplus_secret_key))?$settings->gplus_secret_key:'';?>" placeholder="Type somethin" class="form-control" >
                            <input type="hidden" name="gplus_secret_key_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('gplus_secret_key'); ?>
                        </div>
                    </div>

                    
                    <!--start-->



                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key_admin('comment_settings');?></div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('enable_comment'); ?></label>
                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_comment" class="form-control">
                                <?php $options = array('No','Facebook Comment', 'Disqus Comment');?>
                                <?php foreach($options as $row){?>
                                    <?php $v = (set_value('enable_comment')!='')?set_value('enable_comment'):$settings->enable_comment;?>
                                    <?php $sel=($v==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_comment_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_comment'); ?>
                        </div>
                    </div>

                    <div class="form-group fb-comment-settings" id="fb_app_id" style="display:none">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('fb_app_id'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="fb_comment_app_id" value="<?php echo(isset($settings->fb_comment_app_id))?$settings->fb_comment_app_id:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="fb_comment_app_id_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('fb_comment_app_id'); ?>
                        </div>
                    </div>

                    <div class="form-group fb-comment-settings" id="disqus_shortname_holder" style="display:none">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('disqus_shortname'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="disqus_shortname" value="<?php echo(isset($settings->disqus_shortname))?$settings->disqus_shortname:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="disqus_shortname_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('disqus_shortname'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-check"></i><?php echo lang_key_admin("update") ?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin("media_url_update") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <form class="form-horizontal" action="<?php echo site_url('admin/content/updateoldmedia/');?>" method="post">
                    
                    <div class="form-group" id="">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('old_base_url'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="old_base_url" value="<?php echo(isset($settings->old_base_url))?$settings->old_base_url:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="old_base_url_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('old_base_url'); ?>
                        </div>
                    </div>

                    <div class="form-group" id="">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('new_base_url'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="new_base_url" value="<?php echo base_url();?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >
                            <input type="hidden" name="new_base_url_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('new_base_url'); ?>
                        </div>
                    </div>
                    


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-check"></i><?php echo lang_key_admin("update") ?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    

    
    
    jQuery('select[name=enable_fb_login]').change(function(e){
        var val = jQuery(this).val();
        if(val=='Yes')
        {
            jQuery('input[name=fb_app_id_rules]').attr('value','required');
            jQuery('input[name=fb_secret_key_rules]').attr('value','required');
            jQuery('.fb-settings').show();
        }
        else
        {
            jQuery('input[name=fb_app_id_rules]').attr('value','');
            jQuery('input[name=fb_secret_key_rules]').attr('value','');
            jQuery('.fb-settings').hide();
        }
    }).change();

    /* start facebook comment settings */

    jQuery('select[name=enable_comment]').change(function(e){
        var val = jQuery(this).val();
        if(val=='Facebook Comment')
        {
            jQuery('input[name=fb_comment_app_id_rules]').attr('value','required');
            jQuery('.fb-comment-settings').show();
        }
        else
        {
            jQuery('input[name=fb_comment_app_id_rules]').attr('value','');
            jQuery('.fb-comment-settings').hide();
        }

        if(val=='Disqus Comment')
        {
            jQuery('input[name=disqus_shortname_rules]').attr('value','required');
            jQuery('#disqus_shortname_holder').show();
        }
        else
        {
            jQuery('input[name=disqus_shortname_rules]').attr('value','');
            jQuery('#disqus_shortname_holder').hide();
        }
    }).change();

    /* end facebook comment settings*/

    jQuery('select[name=enable_gplus_login]').change(function(e){
        var val = jQuery(this).val();
        if(val=='Yes')
        {
            jQuery('input[name=gplus_app_id_rules]').attr('value','required');
            jQuery('input[name=gplus_secret_key_rules]').attr('value','required');
            jQuery('.gplus-settings').show();
        }
        else
        {
            jQuery('input[name=gplus_app_id_rules]').attr('value','');
            jQuery('input[name=gplus_secret_key_rules]').attr('value','');
            jQuery('.gplus-settings').hide();
        }
    }).change();

    jQuery('select[name=enable_cookie_policy_popup]').change(function(e){
        var val = jQuery(this).val();
        if(val=='Yes')
        {
            jQuery('input[name=cookie_policy_page_url_rules]').attr('value','required');
            jQuery('.cookie-policy-settings').show();
        }
        else
        {
            jQuery('input[name=cookie_policy_page_url_rules]').attr('value','');
            jQuery('.cookie-policy-settings').hide();
        }
    }).change();
});
</script>