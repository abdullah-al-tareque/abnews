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
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/content/savesource');?>" method="post">
				<input type="hidden" name="action" value="<?php echo isset($action)?$action:'';?>">
				<input type="hidden" name="id" value="<?php echo isset($id)?$id:'';?>">

				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('source_name');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<?php 
						$v = isset($post->source_name)?$post->source_name:'';
						$v = (set_value('source_name')!='')?set_value('source_name'):$v;
						?>
						<input type="text" name="source_name" value="<?php echo $v;?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
						<?php echo form_error('source_name'); ?>
					</div>
				</div>	

				<div class="form-group icon-class-holder">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('source_type');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="source_type" id="source_type">
							<?php 
							$v = isset($post->source_type)?$post->source_type:'';
							$v = (set_value('source_type')!='')?set_value('source_type'):$v;
							?>						
							<?php 
							$options = $this->config->item('source_types');
							foreach ($options as $val) {
								$sel = ($val==$v)?'selected="selected"':'';
							?>
							<option value="<?php echo $val;?>" <?php echo $sel;?>><?php echo lang_key_admin($val);?></option>
							<?php
							}
							?>	
						</select>
						<?php echo form_error('source_type'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label rss-title"><?php echo lang_key_admin('rss_url');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<?php 
						$v = isset($post->rss_url)?$post->rss_url:'';
						$v = (set_value('rss_url')!='')?set_value('rss_url'):$v;
						?>						
						<input type="text" name="rss_url" id="rss_url" value="<?php echo $v;?>" placeholder="<?php echo lang_key_admin('type_something');?>" class="form-control input-sm" >
						<?php echo form_error('rss_url'); ?>
						<span class="rss-ins"></span>
					</div>
				</div>		

				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('parent_category');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="parent_category" id="parent_category">
							<option value=""><?php echo lang_key_admin('select_one');?></option>
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

				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('sub_category');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="sub_category" id="sub_category">
							<option value=""><?php echo lang_key_admin('select_one');?></option>	

						</select>
						<?php echo form_error('sub_category'); ?>
					</div>
				</div>



				<div class="form-group icon-class-holder">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('auto_grabbing');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="auto_grabbing" id="auto_grabbing">
							<?php 
							$v = isset($post->auto_grabbing)?$post->auto_grabbing:'';
							$v = (set_value('auto_grabbing')!='')?set_value('auto_grabbing'):$v;
							?>						
							<?php 
							$options = array('1'=>'yes','0'=>'no');
							foreach ($options as $key=>$val) {
								$sel = ($key==$v)?'selected="selected"':'';
							?>
							<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo lang_key_admin($val);?></option>
							<?php
							}
							?>	
						</select>
						<?php echo form_error('auto_grabbing'); ?>
					</div>
				</div>

				<div class="form-group icon-class-holder auto_grabbing_options">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('start_on');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="start_on" id="start_on">
							<option value=""><?php echo lang_key_admin('select_one');?></option>
							<?php 
							$v = isset($post->start_on)?$post->start_on:'';
							$v = (set_value('start_on')!='')?set_value('start_on'):$v;
							?>							
							<?php 
							$options = start_time_options();
							foreach ($options as $key=>$val) {
								$sel = ($val==$v)?'selected="selected"':'';
							?>
							<option value="<?php echo $val;?>" <?php echo $sel;?>><?php echo lang_key_admin($val);?></option>
							<?php
							}
							?>	
						</select>
						<?php echo form_error('start_on'); ?>
					</div>
				</div>	

				<div class="form-group icon-class-holder auto_grabbing_options">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('grab_duration');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="grab_duration" id="grab_duration">
							<option value=""><?php echo lang_key_admin('select_one');?></option>
							<?php 
							$v = isset($post->grab_duration)?$post->grab_duration:'';
							$v = (set_value('grab_duration')!='')?set_value('grab_duration'):$v;
							?>							
							<?php 
							$options = grab_duration_options();
							foreach ($options as $key=>$val) {
								$sel = ($key==$v)?'selected="selected"':'';
							?>
							<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo lang_key_admin($val);?></option>
							<?php
							}
							?>	
						</select>
						<?php echo form_error('grab_duration'); ?>
					</div>
				</div>


				<div class="form-group icon-class-holder">
					<label class="col-sm-3 col-md-2 control-label"><?php echo lang_key_admin('item_per_grab');?>:</label>
					<div class="col-sm-9 col-md-10 controls">
						<select class="form-control input-sm" name="item_per_grab" id="item_per_grab">
							<option value=""><?php echo lang_key_admin('select_one');?></option>
							<?php 
							$v = isset($post->item_per_grab)?$post->item_per_grab:'';
							$v = (set_value('item_per_grab')!='')?set_value('item_per_grab'):$v;
							?>							
							<?php 
							$options = item_per_grab_options();
							foreach ($options as $key=>$val) {
								$sel = ($key==$v)?'selected="selected"':'';
							?>
							<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo lang_key_admin($val);?></option>
							<?php
							}
							?>	
						</select>
						<?php echo form_error('item_per_grab'); ?>
					</div>
				</div>

				<div class="form-group icon-class-holder">
					<label class="col-sm-3 col-md-2 control-label">&nbsp;</label>
					<div class="col-sm-9 col-md-10 controls">
						<label>
							<?php 
							$v = isset($post->use_youtube_publish_time)?$post->use_youtube_publish_time:'';
							$v = (set_value('use_youtube_publish_time')!='')?set_value('use_youtube_publish_time'):$v;
							$chk = ($v==1)?'checked="checked"':'';
							?>
							<input type="checkbox" value="1" <?php echo $chk;?> name="use_youtube_publish_time">
							<?php echo lang_key_admin('use_youtube_publish_time');?>
						</label>
						<?php echo form_error('use_youtube_publish_time'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label">&nbsp;</label>
					<div class="col-sm-9 col-md-10 controls">						
						<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key_admin('save');?></button>
					</div>
				</div>


			</form>

	  </div>
    </div>
  </div>
</div>



<script type="text/javascript">


jQuery(document).ready(function(){

	jQuery('#source_type').change(function(){
		var val = jQuery(this).val();
		if(val=='youtube_search')
		{
			jQuery('.rss-title').html('<?php echo lang_key_admin("search_text");?>:');
			jQuery('.rss-ins').html('<?php echo lang_key_admin("put_youtube_search_text");?>');
		}
		else if(val=='youtube_user')
		{
			jQuery('.rss-title').html('<?php echo lang_key_admin("user_id_or_url");?>:');
			jQuery('.rss-ins').html('<?php echo lang_key_admin("put_youtube_user_id_or_url");?>');
		}
		else if(val=='youtube_playlist')
		{
			jQuery('.rss-title').html('<?php echo lang_key_admin("playlist_id_or_url");?>:');
			jQuery('.rss-ins').html('<?php echo lang_key_admin("put_youtube_playlist_id_or_url");?>');
		}
		else
		{
			jQuery('.rss-title').html('<?php echo lang_key_admin("channel_id_or_url");?>:');
			jQuery('.rss-ins').html('<?php echo lang_key_admin("put_youtube_channel_id_or_url");?>');
		}
	}).change();

	jQuery('#parent_category').change(function(){
		var val = jQuery(this).val();
		var loadUrl = site_url+'/show/load_sub_categories/'+val;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#sub_category').html(responseText);

				<?php 
				$v = isset($post->parent_category)?$post->parent_category:'-1';
				$v = (set_value('parent_category')!='')?set_value('parent_category'):$v;
				?>	
				var parent_category = <?php echo $v;?>;

				<?php 
				$v = isset($post->sub_category)?$post->sub_category:'-1';
				$v = (set_value('sub_category')!='')?set_value('sub_category'):$v;
				?>	
				var sub_category = <?php echo $v;?>;			

				if(parent_category==val)
				{
					if(sub_category==0)
					jQuery('#sub_category').val("");
					else
					jQuery('#sub_category').val(sub_category);
				}
				else
				{
					jQuery('#sub_category').val("");					
				}
            }
        );

	}).change();	

	jQuery('#auto_grabbing').change(function(){
		var val = jQuery(this).val();
		if(val==1)
		{
			jQuery('.auto_grabbing_options').show('slow');
		}
		else
		{
			jQuery('.auto_grabbing_options').hide('slow');			
		}

	}).change();

});
</script>