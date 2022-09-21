<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin("clear_old_videos") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                   </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <form class="form-horizontal" action="<?php echo site_url('admin/content/clearvideos');?>" method="post" onsubmit="return clearvideos()">


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('videos_before'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                            <input style="position: relative; z-index: 100000;" type="text" name="videos_before" value="<?php echo(isset($settings->videos_before))?$settings->videos_before:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control date" >
                            <span class="help-inline"><?php echo lang_key_admin('leave_empty_if_doesnot_matter');?></span>
                            <?php echo form_error('videos_before'); ?>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('category'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                             <select class="form-control input-sm" name="category" id="category">
                                <option value=""><?php echo lang_key_admin('no_category');?></option>
                                <?php
                                $v = isset($post->category)?$post->category:'';
                                $v = (set_value('category')!='')?set_value('category'):$v;
                                ?>
                                <?php
                                $CI = get_instance();
                                $CI->load->model('admin/category_model');
                                $categories = $CI->category_model->get_all_parent_categories_by_range();
                                foreach ($categories->result() as $cat) {
                                    $sel = ($v==$cat->id)?'selected="selected"':'';
                                    ?>
                                    <option value="<?php echo $cat->id;?>" <?php echo $sel;?>><?php echo $cat->title;?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('category'); ?>
                        </div>
                    </div>

                   

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('sub_category'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                             <select class="form-control input-sm" name="sub_category" id="sub_category">
                                <option value=""><?php echo lang_key_admin('select_one');?></option>

                            </select>
                            <?php echo form_error('sub_category'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('source'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                              <select class="form-control input-sm" name="source_id" id="source_id">
                                <option value=""><?php echo lang_key_admin('no_source');?></option>
                                <?php
                                $v = isset($post->source_id)?$post->source_id:'';
                                $v = (set_value('source_id')!='')?set_value('source_id'):$v;
                                ?>
                                <?php
                                $CI = get_instance();
                                $CI->load->model('admin/content_model');
                                $sources = $CI->content_model->get_all_sources();
                                foreach ($sources->result() as $cat) {
                                    $sel = ($v==$cat->id)?'selected="selected"':'';
                                    ?>
                                    <option value="<?php echo $cat->id;?>" <?php echo $sel;?>><?php echo $cat->source_name;?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('source_id'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('view_less_than'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                            <input type="text" name="view_less_than" value="<?php echo(isset($settings->view_less_than))?$settings->view_less_than:'';?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control" >

                            <span class="help-inline"><?php echo lang_key_admin('leave_empty_if_doesnot_matter');?></span>
                            <?php echo form_error('view_less_than'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key_admin('without_image'); ?></label>

                        <div class="col-sm-9 col-lg-5 controls">
                             <select class="form-control input-sm" name="without_image" id="without_image">
                                <option value="0">No</option>
                                <option value="1">yes</option>
                            </select>
                            <?php echo form_error('without_image'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-5 controls">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-check"></i><?php echo lang_key_admin("clear") ?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){

    jQuery( ".date" ).datepicker({ dateFormat: 'dd-mm-yy' });


    jQuery('#category').change(function(e){
            var val = jQuery(this).val();
            if(val!='')
            {
                var loadUrl = site_url+'/show/load_sub_categories/'+val;
                jQuery.post(
                    loadUrl,
                    {},
                    function(responseText){
                        jQuery('#sub_category').html(responseText);

                        <?php 
                        $v = (isset($post->category))?$post->category:'-1';
                        $v = (set_value('parent_category')!='')?set_value('parent_category'):$v;
                        ?>  
                        var parent_category = <?php echo $v;?>;

                        <?php 
                        $v = (isset($post->sub_category))?$post->sub_category:'-1';
                        $v = (set_value('sub_category')!='')?set_value('sub_category'):$v;
                        ?>  
                        var sub_category = <?php echo $v;?>;


                        if(parent_category==val)
                        {
                            jQuery('#sub_category').val(sub_category);
                        }
                    }
                );                
            }
        }).change();

});

function clearvideos() {
    var txt;
    var r = confirm("<?php echo lang_key_admin('you_cant_undo_this_action');?>");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

</script>