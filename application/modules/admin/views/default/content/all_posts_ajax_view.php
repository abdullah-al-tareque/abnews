<?php 
$curr_page = $this->uri->segment(5);
if($curr_page=='')
  $curr_page = 0;
$dl = default_lang();
?>
      
      <table id="all-posts" class="table table-hover table-advance">

           <thead>

               <tr>

                  <th class="numeric"><input type="checkbox" id="select_all"></th>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key_admin('media');?></th>

                  <th class="numeric"><?php echo lang_key_admin('title');?></th>

                   <th class="numeric hidden"><?php echo lang_key_admin('source');?></th>

                  <th class="numeric"><?php echo lang_key_admin('category');?></th>

                  <th class="numeric"><?php echo lang_key_admin('category_2');?></th>

                  <th class="numeric"><?php echo lang_key_admin('link');?></th>

                  <th class="numeric"><?php echo lang_key_admin('status');?></th>

                  <th class="numeric"><?php echo lang_key_admin('featured');?></th>

                   <th class="numeric"><?php echo lang_key_admin('actions');?></th>

               </tr>

           </thead>

           <tbody>

          <?php $i=1;foreach($posts->result() as $row):  
                $detail_link = post_detail_url($row);
          ?>

               <tr>

                  <td data-title="#" class="numeric"><input type="checkbox" name="id[]" value="<?php echo $row->id;?>"></td>
                  
                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key_admin('image');?>" class="numeric"><img class="thumbnail" style="width:50px;margin-bottom:0px;" src="<?php echo $row->media;?>" /></td>

                  <td data-title="<?php echo lang_key_admin('title');?>" class="numeric"><?php echo $row->title;?></td>

                   <td data-title="<?php echo lang_key_admin('source');?>" class="numeric hidden"><?php echo get_source_title_by_id($row->source_id);?></td>

                   <td data-title="<?php echo lang_key_admin('category');?>" class="numeric"><?php echo get_category_title_by_id($row->category);?></td>

                   <td data-title="<?php echo lang_key_admin('category_2');?>" class="numeric"><?php echo get_category_title_by_id($row->sub_category);?></td>

                   <td data-title="<?php echo lang_key_admin('link');?>" class="numeric"><a href="<?php echo post_detail_url($row);?>"><?php echo $row->title;?></a></td>

                   <td data-title="<?php echo lang_key_admin('status');?>" class="numeric">
                      <?php 
                      if($row->status==1)
                        echo '<span class="label label-success">'.lang_key_admin('published').'</span>';
                      else if($row->status==2)
                        echo '<span class="label label-warning">'.lang_key_admin('pending').'</span>';
                      ?>
                    </td>

                   <td data-title="<?php echo lang_key_admin('featured');?>" class="numeric">
                      <?php echo ($row->featured==1)?'<span class="label label-success">'.lang_key_admin('yes').'</span>':'<span class="label label-info">'.lang_key_admin('no').'</span>';?>
                    </td>

                   <td data-title="<?php echo lang_key_admin('actions');?>" class="numeric">
                       <div class="btn-group">
                           <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key_admin('action');?> <span class="caret"></span></a>
                           <ul class="dropdown-menu dropdown-info">
                               <?php if(is_admin() || (is_moderator() && get_settings('global_settings','moderator_can_create_post','Yes')=='Yes')){?>
                               <?php if($row->status==2){?>
                               <li><a href="<?php echo site_url('admin/content/approvevideo/'.$start.'/'.$row->id);?>"><?php echo lang_key_admin('publish');?></a></li>
                               <?php }else{?>
                               <li><a href="<?php echo site_url('admin/content/draftvideo/'.$start.'/'.$row->id);?>"><?php echo lang_key_admin('unpublish');?></a></li>
                               <?php }?>

                               <?php if($row->featured==0){?>
                               <li><a href="<?php echo site_url('admin/content/makefeatured/'.$row->id.'/'.$start);?>"><?php echo lang_key_admin('make_featured');?></a></li>
                               <?php }else{?>
                               <li><a href="<?php echo site_url('admin/content/removefeatured/'.$row->id.'/'.$start);?>"><?php echo lang_key_admin('remove_featured');?></a></li>
                               <?php }?>
                               <?php }?>
                               <li><a href="<?php echo site_url('admin/content/createvideo/'.$row->id.'/'.$start);?>"><?php echo lang_key_admin('edit');?></a></li>
                               <li><a href="<?php echo site_url('admin/content/deletevideo/'.$start.'/'.$row->id);?>"><?php echo lang_key_admin('delete');?></a></li>
                           </ul>
                       </div>
                   </td>

                   </ul>

                    </div>

                  </td>

               </tr>

            <?php $i++;endforeach;?>   

           </tbody>

        </table>

          <div class="pagination pull-right">
            <ul class="pagination pagination-colory"><?php echo $pages;?></ul>
          </div>
          <div class="pull-right">
            <img src="<?php echo base_url('assets/images/loading.gif');?>" style="width:20px;margin:5px;display:none" class="loading">
          </div>
          <div class="clearfix"></div>