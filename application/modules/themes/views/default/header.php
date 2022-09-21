    <div class="top-bar">
      <div class="container">
        <div class="row">
            <div class="col-md-12 holder">
            <?php render_widget('top_bar_contact'); ?>
            <?php render_widget('top_bar_social'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header">
      <div class="container">
        <div class="row main-header">
          <div class="col-md-2 col-sm-2 logo-panel">
            <?php 
            $logo_type = get_settings('site_settings','logo_type','Image');
            if($logo_type=='Image')
            {
            ?>
            <h3>
                <a href="<?php echo site_url();?>">
                <img src="<?php echo get_site_logo();?>" alt="Logo" style="height:63px">
                </a>
            </h3>
            <?php 
            }else{
            ?>
            <!-- added on version 1.4 -->
            <a href="<?php echo site_url();?>">
            <h1 class="logo-text" style="color:<?php echo get_settings('site_settings','logo_text_color','#222');?>">
                <?php echo  get_settings('site_settings','logo_text','No Logo')?>
            </h1>
            </a>
            <?php 
            }
            ?>
          </div>

          <div class="col-md-7 col-sm-7">

          <div class="menu">
          <?php if(get_settings('global_settings','menu_type','Mega Menu')=='Normal'){ //added on version 1.5?>
          <nav class="navbar">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-menu" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>                
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="site-menu">
                <ul class="nav navbar-nav">
		                <?php
                            $CI = get_instance();
                            $CI->load->model('admin/page_model');
                            $CI->page_model->init();
                        ?>
                        <?php 
                            $alias = (isset($alias))?$alias:'';
                            foreach ($CI->page_model->get_menu() as $li) 
                            {
                                if($li->parent==0)
                                $CI->page_model->render_top_menu($li->id,0,$alias);
                            }
                        ?>

                        <?php 
                        if(get_settings('global_settings','show_cat_menu','Yes')=='Yes')
                        {
                        ?>
                        <li class="has-sub dropdown">
                            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <?php echo lang_key('categories');?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <?php
                            $CI = get_instance();
                            $CI->load->model('show/post_model');
                            $parent_categories = $CI->post_model->get_all_parent_categories();
                            foreach ($parent_categories->result() as $category) {
                              $category_url = category_video_url($category->id,$category->title);
                            ?>    
                              <li class="dropdown-submenu">
                  	            <?php
					            $child_categories = $CI->post_model->get_all_child_categories($category->id,5);
					            $total = $child_categories->num_rows();
					            ?>

                                  <a href="<?php echo $category_url;?>"><?php echo $category->title;?>
                                  		<?php if($total>0){?>
                                  		<span class="caret-right"></span>
                                  		<?php }?>
                                  </a>
	                       		<?php if($total>0){?>
                                  <ul class="dropdown-menu submenu">
							          <?php foreach ($child_categories->result() as $child) { 
							          	 $sub_category_url = category_video_url($child->id,$child->title);
							          ?>
							          <li><a tabindex="-1" href="<?php echo $sub_category_url;?>"><?php echo $child->title;?></a></li>
							          <?php }?>
                            		<?php if($total>=5){?>
							          <li><a class="see_all_sub_cat_menu" tabindex="-1" href="<?php echo site_url('show/allsubcat/'.$category->id);?>"><?php echo lang_key('view_all');?></a></li>
							        <?php }?>
							      </ul>
							    <?php }?>      
                              </li>
                            <?php 
                            }
                            ?>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>
                        <?php 
                        if(get_settings('global_settings','show_source_menu','Yes')=='Yes')
                        {
                        ?>
                        <li class="has-sub dropdown">
                            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <?php echo lang_key('video_sources');?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <?php
                            $CI = get_instance();
                            $CI->load->model('admin/content_model');
                            $sources = $CI->content_model->get_all_sources();
                            foreach ($sources->result() as $source) {
                              $source_video_url = source_video_url($source->id,$source->source_name);
                            ?>    
                              <li class=" -child">
                                  <a href="<?php echo $source_video_url;?>"><?php echo $source->source_name;?></a>
                              </li>
                            <?php 
                            }
                            ?>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>                       
                </ul>
                
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
          <?php }else{?>
          <?php require'mega-menu.php';?>
          <?php }?>
          <?php //require'marquee_view.php';?>

          <div class="header-separator">
        </div>
    </div>


          </div>

          <div class="col-md-3 col-sm-3 panel-right ad-block-top">
            <?php //render_widget('adsense_header'); ?>
            <form  action="<?php echo site_url('show/search')?>" method="post">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="<?php echo lang_key('type_anything');?>" value="<?php echo (isset($data['plainkey']))?rawurldecode($data['plainkey']):'';?>" name="plainkey">


                <span class="input-group-btn">
                    <button type="submit" class="btn btn-color"><?php echo lang_key('search');?></button>
                </span>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>    


<script type="text/javascript">
  // added on version 1.4
$(document).ready(function(){
  var ul='';
  $('.dropdown-submenu a').on("click", function(e){

  	console.log($(this).next('ul').attr('style'));
  	if(ul!='' && $(this).next('ul').attr('style')!='display: block;')
  	ul.hide();

    $(this).next('ul').toggle();
    ul = $(this).next('ul');
    e.stopPropagation();
    if($(this).next('ul').length>0)
    e.preventDefault();
  });
});
//end
</script>
<!-- added on version 1.5 -->
<div id="category-modal-menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel2"><?php echo lang_key('all_sub_categories'); ?> </h4>

                </div>

                <div class="modal-body">

                    
                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.see_all_sub_cat_menu').click(function(e){
            e.preventDefault();
            jQuery('#category-modal-menu').modal('show');

            var load_url = jQuery(this).attr('href');
              jQuery.post(
                  load_url,
                  {},
                  function(responseText){   
                    jQuery('#category-modal-menu  .modal-body').html(responseText);
                  }
              ); 
          
        });

    });

</script>