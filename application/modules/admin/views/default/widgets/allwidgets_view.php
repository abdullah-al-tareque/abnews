<div class="row">
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin('create_widget');?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <form action="<?php echo site_url('admin/widgets/create');?>" method="post">
                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('name');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <input type="text" name="name" value="" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
                            <?php echo form_error("name");?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label">&nbsp;</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key_admin('create');?></button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key_admin('generate_widgets');?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <form action="<?php echo site_url('admin/widgets/generate');?>" method="post">
                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('name');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <input type="text" name="widget_name" value="" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
                            <?php echo form_error("widget_name");?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label">&nbsp;</label>
                        <div class="col-sm-4 col-lg-10 controls">
                            <label style="white-space:unset">
                            <input type="checkbox" name="use_name_as_title" value="1"> <?php echo lang_key_admin('use_name_as_frontend_widget_title');?>
                            </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('type');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="type" id="type">
                            <?php $sel = (set_value('type')=='video_source')?'selected="selected"':'';?>
                            <option value="video_source" <?php echo $sel;?>><?php echo lang_key_admin('video_source');?></option>  
                            <?php $sel = (set_value('type')=='video_category')?'selected="selected"':'';?>
                            <option value="video_category" <?php echo $sel;?>><?php echo lang_key_admin('video_category');?></option>  
                            </select>
                            <?php echo form_error('type'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group news-source">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('source');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="source_id" id="source_id">
                                <option value=""><?php echo lang_key_admin('any_source');?></option>
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
                    <div class="clearfix"></div>

                    <div class="form-group news-category">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('category');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="parent_category" id="parent_category">
                            <option value=""><?php echo lang_key_admin('any_category');?></option>
                            <?php 
                            $v = isset($post->parent_category)?$post->parent_category:'';
                            $v = (set_value('parent_category')!='')?set_value('parent_category'):$v;
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
                        <?php echo form_error('parent_category'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group news-category">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('sub_category');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="sub_category" id="sub_category">
                            <option value=""><?php echo lang_key_admin('any_subcategory');?></option>
                            <?php 
                            $v = isset($post->sub_category)?$post->sub_category:'';
                            $v = (set_value('sub_category')!='')?set_value('sub_category'):$v;
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
                        <?php echo form_error('sub_category'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <!--div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('sub_category');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="sub_category" id="sub_category">
                            <option value=""><?php echo lang_key_admin('select_one');?></option>  

                            </select>
                            <?php echo form_error('sub_category'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div-->

                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label"><?php echo lang_key_admin('limit');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <select class="form-control input-sm" name="limit" id="limit">
                            <?php 
                            $options = array(5,10,15,20);
                            foreach ($options as $option) {
                            ?>
                            <option value="<?php echo $option;?>"><?php echo $option;?></option>
                            <?php
                            }
                            ?>
                            </select>
                            <?php echo form_error('limit'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    

                    <div class="form-group">
                        <label class="col-sm-4 col-lg-2 control-label">&nbsp;</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key_admin('create');?></button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i> <?php echo lang_key_admin('all_widgets');?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <div id="no-more-tables">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="numeric">#</th>
                            <th class="numeric"><?php echo lang_key_admin('widget_name');?></th>
                            <th class="numeric"><?php echo lang_key_admin('activate_deactivate');?></th>
                            <th class="numeric"><?php echo lang_key_admin('actions');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($widgets->result() as $row){?>
                        <tr>
                            <td data-title="#" class="numeric"><?php echo $i;?></td>
                            <input type="hidden" name="widget[]" value="<?php echo $row->name;?>">
                            <td data-title="<?php echo lang_key_admin('widget_name');?>" class="numeric"><?php echo $row->name;?></td>
                            <td data-title="<?php echo lang_key_admin('activate_deactivate');?>" class="numeric">
                                <?php if($row->status==1){?>
                                    <a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/0');?>" style="" class="btn btn-warning">Deactivate</a>
                                <?php }else{?>
                                    <a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/1');?>" style="" class="btn btn-success">Activate</a>
                                <?php }?>
                            </td>
                            <td data-title="<?php echo lang_key_admin('actions');?>" class="numeric">
                                <div class="btn-group">
                                    <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key_admin('action');?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-info">
                                        <li><a href="<?php echo site_url('admin/widgets/edit/'.$row->alias);?>" class="edit-widget"><?php echo lang_key_admin('edit');?></a></li>
                                        <?php if($row->editable==1){?>
                                        <li><a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/2');?>"><?php echo lang_key_admin('delete');?></a></li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        <?php $i++;}?>
                        </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editWidgetModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    
    jQuery('#type').change(function(){
        var val = jQuery(this).val();
        if(val=='video_source')
        {
            jQuery('.news-source').show();
            jQuery('.news-category').hide();                
        }
        else
        {
            jQuery('.news-source').hide();
            jQuery('.news-category').show();                
        }
    }).change();


    jQuery(".edit-widget").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#editWidgetModal').modal('show');
        jQuery("#editWidgetModal  .modal-body").html("Loading...");
        jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#editWidgetModal  .modal-body").html(responseText);
                },
                "html"
            );
    });
});

    var base_url = '<?php echo base_url();?>';
    jQuery(document).ready(function(){
        
        jQuery('#parent_category').change(function(e){
            var val = jQuery(this).val();
            if(val!='')
            {
                var loadUrl = site_url+'/show/load_sub_categories/'+val+'/1';
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
                            if(sub_category!=0)
                            jQuery('#sub_category').val(sub_category);
                            else
                            jQuery('#sub_category').val("");                            
                        }
                        else
                        {
                            jQuery('#sub_category').val("");                            
                        }
                    }
                );                
            }
        }).change();
        
    });

</script>
