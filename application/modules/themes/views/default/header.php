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
          <div class="col-md-2 col-sm-2 col-xs-3 logo-panel">
            <?php 
            $logo_type = get_settings('site_settings','logo_type','Image');
            if($logo_type=='Image')
            {
            ?>
            <h3>
                <a href="<?php echo site_url();?>">
                <img src="<?php echo get_site_logo();?>" alt="Logo" style="height:60px;width: 100%;">
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

          <div class="col-md-10 col-sm-10 col-xs-9">

          <div class="menu">
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
                                  $CI->load->model('show/post_model');
                                  $parent_categories = $CI->post_model->get_all_parent_categories();
                                  foreach ($parent_categories->result() as $category) {
                                    $category_url = category_video_url($category->id,$category->title);

                                    $child_categories = $CI->post_model->get_all_child_categories($category->id,5);
                                    $total = $child_categories->num_rows();

                                    if($category->parent == 0){ ?>

                                     <li>
                                        <a href="<?php echo $category_url;?>">
                                          <?php echo $category->title;?>
                                          
                                        </a>
                                    </li>


                                   <?php }else{ ?>

                                    <li class="has-sub dropdown">
                                      <?php
                                       
                                        ?>
                                          <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="<?php echo $category_url;?>">
                                          <?php echo $category->title;?>
                                            <?php if($total>0){?>
                                              <span class="caret"></span>
                                            <?php }?>
                                        </a>
                                      <?php if($total>0){?>
                                          <ul class="dropdown-menu">
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


                                  <?php  }


                                  ?>    

                                  <?php 
                                  }
                                  ?>
                          
                        </ul> 
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
                </nav>
     
                    <?php //require'marquee_view.php';?>

                     <div class="header-separator">
               </div>
              </div>
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