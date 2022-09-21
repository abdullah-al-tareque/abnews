<div class="row">

    <div class="col-md-12">

        <div class="box">

            <div class="box-title">

                <h3><i class="fa fa-bars"></i> <?php echo lang_key_admin("create_user"); ?> </h3>

                <div class="box-tool">

                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                    <a href="#" data-action="close"><i class="fa fa-times"></i></a>

                </div>

            </div>

            <div class="box-content">

                <?php echo $this->session->flashdata('msg'); ?>

                <form class="form-horizontal" action="<?php echo site_url('admin/users/add'); ?>" method="post">
                    <?php echo validation_errors();?>
                
                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('useremail'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="text" name="user_email" value="<?php echo set_value('user_email'); ?>"

                                   placeholder="<?php echo lang_key_admin('useremail'); ?>" class="form-control">

                            <?php echo form_error('user_email'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('username'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="text" name="user_name" value="<?php echo set_value('user_name'); ?>"

                                   placeholder="<?php echo lang_key_admin('username'); ?>" class="form-control">
                            <?php echo form_error('user_name'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('first_name'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"

                                   placeholder="<?php echo lang_key_admin('first_name'); ?>" class="form-control">
                            <?php echo form_error('first_name'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('last_name'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"

                                   placeholder="<?php echo lang_key_admin('last_name'); ?>" class="form-control">
                            <?php echo form_error('last_name'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('type'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <?php $curr_value=(set_value('user_type')!='')?set_value('user_type'):'';?>

                            <select class="form-control" name="user_type" id="user_type">
                                <?php foreach($usertypes as $usertype){ 
                                        $sel = ($usertype->id==set_value('user_type'))?'selected="selected"':'';
                                ?>
                                <option value="<?php echo $usertype->id;?>" <?php echo $sel;?>><?php echo $usertype->name;?></option>
                                <?php }?>
                            </select>
                            <?php echo form_error('user_type'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>




                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('gender'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <?php $curr_value=(set_value('gender')!='')?set_value('gender'):'';?>

                            <select class="form-control" name="gender">

                                <?php $sel=($curr_value=='male')?'selected="selected"':'';?>

                                <option value="male" <?php echo $sel;?>>Male</option>

                                <?php $sel=($curr_value=='female')?'selected="selected"':'';?>

                                <option value="female" <?php echo $sel;?>>Female</option>

                            </select>
                            <?php echo form_error('gender'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>
                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('password'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="password" name="password" value="<?php echo ''; ?>"

                                   placeholder="<?php echo lang_key_admin('password'); ?>" class="form-control">
                            <?php echo form_error('password'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('re_password'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <input type="password" name="confirm_password" value="<?php echo ''; ?>"

                                   placeholder="<?php echo lang_key_admin('confirm_password'); ?>" class="form-control">
                            <?php echo form_error('confirm_password'); ?>
                            <span class="help-inline">&nbsp;</span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-6 controls">

                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i><?php echo lang_key_admin("create") ?>
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

jQuery(document).ready(function(){

    var base_url = "<?php echo base_url();?>";

    jQuery('#profile_photo').change(function(){

        var val = jQuery(this).val();

        var src = base_url+'uploads/profile_photos/thumb/'+val;        

        jQuery('#user_photo').attr('src',src);

    }).change();


});

</script>