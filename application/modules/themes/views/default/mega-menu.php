    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/mega-menu.css">
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/ionicons.min.css">
    <div class="menu-container">
        <div class="menu">
            <ul>
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
                        <li>
                            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <?php echo lang_key('categories');?><span class="caret"></span></a>
                            <ul>
                            <?php
                            $CI = get_instance();
                            $CI->load->model('show/post_model');
                            $parent_categories = $CI->post_model->get_all_parent_categories();
                            $cat_count = 0;
                            foreach ($parent_categories->result() as $category) {
                              $cat_count++;
                              $category_url = category_video_url($category->id,$category->title);
                            ?>    
                              <li>
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
                                  <ul>
                                      <?php foreach ($child_categories->result() as $child) { 
                                         $sub_category_url = category_video_url($child->id,$child->title);
                                      ?>
                                      <li><a tabindex="-1" href="<?php echo $sub_category_url;?>"><?php echo $child->title;?>
										<span dir="rtl" class="category-counter <?php echo $class;?> color">(<?php echo count_videos_by_subcategory($child->id);?>)</span>
                                      </a></li>
                                      <?php }?>
                                    <?php if($total>=5){?>
                                      <li><a class="see_all_sub_cat_menu" tabindex="-1" href="<?php echo site_url('show/allsubcat/'.$category->id);?>"><?php echo lang_key('view_all');?></a></li>
                                    <?php }?>
                                  </ul>
                                <?php }?>      
                              </li>
                              <?php if($cat_count%4==0){ ?>
                              <div class="clearfix"></div>
                              <?php }?>
                            <?php 
                            }
                            ?>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>

            </ul>
        </div>
    </div>
    <script src="<?php echo theme_url();?>/assets/js/megamenu.js"></script>