<?php $settings = json_decode($settings);?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin("web_email_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                   </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <form class="form-horizontal" action="<?php echo site_url('admin/system/savesettings/webadmin_email');?>" method="post">


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('contact_email'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="contact_email" value="<?php echo(isset($settings->contact_email))?$settings->contact_email:'';?>" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('contact_email'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('webadmin_name'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="webadmin_name" value="<?php echo(isset($settings->webadmin_name))?$settings->webadmin_name:'';?>" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('webadmin_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('webadmin_email'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="webadmin_email" value="<?php echo(isset($settings->webadmin_email))?$settings->webadmin_email:'';?>" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('webadmin_email'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('phone'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="phone" value="<?php echo(isset($settings->phone))?$settings->phone:'';?>" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('phone'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('address'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="address" value="<?php echo(isset($settings->address))?$settings->address:'';?>" class="form-control" >
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('address'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Facebook url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="facebook_url" value="<?php echo(isset($settings->facebook_url))?$settings->facebook_url:'';?>" class="form-control" >           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Youtube url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="youtube_url" value="<?php echo(isset($settings->youtube_url))?$settings->youtube_url:'';?>" class="form-control" >                      
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Twitter url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="twitter_url" value="<?php echo(isset($settings->twitter_url))?$settings->twitter_url:'';?>" class="form-control" >                        
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('LinkedIn url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="linkedIn_url" value="<?php echo(isset($settings->linkedIn_url))?$settings->linkedIn_url:'';?>" class="form-control" > 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Pinterest url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="pinterest_url" value="<?php echo(isset($settings->pinterest_url))?$settings->pinterest_url:'';?>" class="form-control" > 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Google+ url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="google_url" value="<?php echo(isset($settings->google_url))?$settings->google_url:'';?>" class="form-control" > 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('Instagram url'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="instagram_url" value="<?php echo(isset($settings->instagram_url))?$settings->instagram_url:'';?>" class="form-control" > 
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
