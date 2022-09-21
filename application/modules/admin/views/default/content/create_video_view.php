<div class="row">
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i> <?php echo $title;?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">

                <form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/content/addvideo');?>" method="post">
                    <input type="hidden" name="action" value="<?php echo isset($action)?$action:'';?>">
                    <input type="hidden" name="id" value="<?php echo isset($id)?$id:'';?>">
                    <input type="hidden" name="start" value="<?php echo isset($start)?$start:'';?>">
                    <?php
                    $v = isset($post->youtube_id)?$post->youtube_id:'';
                    $v = (set_value('youtube_id')!='')?set_value('youtube_id'):$v;
                    ?>
                    <input type="hidden" name="youtube_id" id="youtube_id" value="<?php echo $v;?>">
                    <?php $v = isset($post->manual_creation)?$post->manual_creation:1;?>
                    <input type="hidden" name="manual_creation" value="<?php echo $v;?>">

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('source');?>:</label>

                        <div class="col-sm-9 col-md-10 controls">
                            <select class="form-control input-sm" name="source_id" id="source_id">
                                <option value="0"><?php echo lang_key_admin('no_source');?></option>
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
                            <?php echo form_error('source'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('category');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <select class="form-control input-sm" name="category" id="category">
                                <option value="0"><?php echo lang_key_admin('no_category');?></option>
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
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('sub_category');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <select class="form-control input-sm" name="sub_category" id="sub_category">
                                <option value=""><?php echo lang_key_admin('select_one');?></option>

                            </select>
                            <?php echo form_error('sub_category'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('link_or_id');?>:</label>
                        <div class="col-sm-9 col-md-10 controls input-group">
                            <?php
                            $v = isset($post->youtube_id)?$post->youtube_id:'';
                            $v = (set_value('link')!='')?set_value('link'):$v;
                            ?>
                            <input type="text" name="link" id="link" value="<?php echo $v;?>" placeholder="<?php echo lang_key_admin('type_link_or_id');?>" class="form-control input-sm" >
                            
                            <a href="#" class="input-group-addon grab-button">
                                <span class="fa fa-copy"></span>
                                <?php echo lang_key_admin('grab_info');?>
                            </a>                            
                        </div>
                        <?php if(form_error('link')!=''){?>
                        <label class="col-sm-3 col-md-2 control-label">&nbsp;</label>
                        <div class="col-sm-9 col-md-10 controls input-group">
                            <?php echo form_error('link'); ?>
                        </div>
                        <?php }?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('title');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <?php
                            $v = isset($post->title)?$post->title:'';
                            $v = (set_value('title')!='')?set_value('title'):$v;
                            ?>
                            <input type="text" name="title" id="title" value="<?php echo $v;?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
                            <?php echo form_error('title'); ?>
                        </div>
                    </div>

                    <div class="form-group icon-class-holder">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('description');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <?php
                            $v = isset($post->full_description)?$post->full_description:'';
                            $v = (set_value('description')!='')?set_value('description'):$v;
                            ?>

                            <textarea name="description" id="description" class="form-control rich"><?php echo $v;?></textarea>
                            <?php echo form_error('description'); ?>
                        </div>
                    </div>





                     <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('tags');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <?php
                            $v = isset($post->tags)?$post->tags:'';
                            $v = (set_value('tags')!='')?set_value('tags'):$v;
                            ?>
                            <textarea name="tags" id="tags" value="<?php echo $v;?>" class="form-control input-sm"><?php echo $v;?></textarea>
                            <span><?php echo lang_key_admin('put_as_comma_separated');?></span>
                            <?php echo form_error('tags'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('media');?>:</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <img class="thumbnail" id="featured_photo" src="<?php echo get_featured_photo_by_id('');?>" style="width:256px;">
                        </div>
                        <div class="clearfix"></div>
                        <span id="featured-photo-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label">&nbsp;</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <?php
                            $v = isset($post->media)?$post->media:'';
                            $v = (set_value('media')!='')?set_value('media'):$v;
                            ?>
                            <input type="text" name="media" id="media" value="<?php echo $v;?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
                            <?php echo form_error('media'); ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label">&nbsp;</label>
                        <div class="col-sm-9 col-md-10 controls">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key_admin('save');?></button>
                            <a class="btn btn-primary" href="<?php echo site_url('admin/content/allvideos/'.$start);?>"><i class="fa fa-chevron-left"></i> <?php echo lang_key_admin('back');?></a>
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>
</div>
 <input name="image" type="file" id="upload" class="hidden" onchange="">
<script type="text/javascript" src="<?php echo base_url('assets/tinymce/tinymce.min.js');?>"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url();?>';
    jQuery(document).ready(function(){

        jQuery('.grab-button').click(function(e){
            e.preventDefault();
            var key = "<?php echo get_settings('global_settings','yt_api_key','');?>";
            if(key=='')
            {
                alert("<?php echo lang_key_admin('define_api_key_msg');?>");
                return;
            }


            var val = $('#link').val();
            if(val=='')
            {
                alert("<?php echo lang_key_admin('url_or_id_required');?>");
                return;
            }



            var loadUrl = site_url+'/grab/grabsingle_video_info/';
            jQuery('.grab-button').html('<?php echo lang_key_admin("loading");?>');
            jQuery.post(
                loadUrl,
                {'url':val},
                function(responseText){
                    var data = jQuery.parseJSON(responseText);
                    if(data.title==null)
                    {
                        alert("<?php echo lang_key_admin('video_id_not_valid');?>");
                        jQuery('.grab-button').html(' <span class="fa fa-copy"></span> <?php echo lang_key_admin("grab_info");?>');                        
                        return;
                    }
                    else
                    {
                        $('#title').val(data.title);
                        //console.log(data.description);
                        $('#description').html(data.description);
                        var editor = tinymce.get('description');
                        editor.setContent(data.description); 
                        $('#media').val(data.media);
                        $('#media').trigger('change');
                        $('#tags').val(data.tags);
                        $('#youtube_id').val(data.youtube_id);
                        jQuery('.grab-button').html(' <span class="fa fa-copy"></span> <?php echo lang_key_admin("grab_info");?>');                        
                    }
                }
            ); 
        });

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

    var manual_creation = '<?php echo (isset($post->manual_creation))?$post->manual_creation:1;?>';
    jQuery('#featured_photo_input').change(function(){
        var val = jQuery(this).val();
        if(val!='')
        {
            //if(manual_creation==1)
            var src = base_url+'uploads/images/'+val;
            // else
            // {

            //     var src = val;                
            // }
        }
        else
        {
            var src = base_url+'assets/admin/img/preview.jpg'
        }
        jQuery('#featured_photo').attr('src',src);
        jQuery('#media').attr('value',src);
    });

    function IsValidImageUrl(url) {
        $("<img>", {
            src: url,
            error: function() { 
                var src = base_url+'assets/admin/img/preview.jpg'
            },
            load: function() {

                jQuery('#featured_photo').attr('src',url);
            }
        });
    }

    jQuery('#media').change(function(){
        var src = jQuery(this).val();
        IsValidImageUrl(src);
    }).change();

    var defaultToolbar = "undo redo | styleselect | bold italic | alignleft" 
                   + "aligncenter alignright alignjustify | " 
                   + "bullist numlist outdent indent | link image | ltr | rtl";

  tinymce.init({
    selector: "#description",
    convert_urls : 0,
    theme: "modern",
    paste_data_images: true,
    toolbar: defaultToolbar,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save code table contextmenu directionality emoticons template paste textcolor"
    ],
    image_advtab: true,
    file_picker_callback: function(callback, value, meta) {
      if (meta.filetype == 'image') {
        $('#upload').trigger('click');
        $('#upload').on('change', function() {
          var file = this.files[0];
          var reader = new FileReader();
          reader.onload = function(e) {
            callback(e.target.result, {
              alt: ''
            });
          };
          reader.readAsDataURL(file);
        });
      }
    }
  });

</script>
<style type="text/css">
    .hidden{display:none;}
</style>