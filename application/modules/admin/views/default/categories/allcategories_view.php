<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key_admin('all_categories');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
        <?php $this->load->helper('text');?>
        <?php echo $this->session->flashdata('msg');?>
        <?php if($posts->num_rows()<=0){?>
        <div class="alert alert-info">No Category</div>
        <?php }else{?>
        <div id="no-more-tables">
        <form action="<?php echo site_url('admin/category/bulkdeletecategory');?>" method="post" id="bulk_delete">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>
                  <th style="padding-left:9px;" class="numeric"><input type="checkbox" id="select_all"></th>
                  <th class="numeric">#</th>
                  <th class="numeric"><?php echo lang_key_admin('title');?></th>
                  <th class="numeric"><?php echo lang_key_admin('parent');?></th>
                  <th class="numeric"><?php echo lang_key_admin('fa_icon');?></th>
                  <th class="numeric"><?php echo lang_key_admin('actions');?></th>
               </tr>
           </thead>
           <tbody>
        	<?php $i=1;foreach($posts->result() as $row):?>
               <tr>
                  <td data-title="#" class="numeric"><input type="checkbox" name="id[]" value="<?php echo $row->id;?>"></td>
                  <td data-title="#" class="numeric"><?php echo $i;?></td>
                  <td data-title="<?php echo lang_key_admin('title');?>" class="numeric"><a href="<?php echo site_url('admin/category/edit/'.$row->id);?>"><?php echo $row->title;?></a></td>
                  <td data-title="<?php echo lang_key_admin('parent');?>" class="numeric"><?php echo get_category_title_by_id($row->parent);?></td>
                  <td data-title="<?php echo lang_key_admin('fa_icon');?>" class="numeric"><i class="fa <?php echo $row->fa_icon;?>"></i></td>
                  <td data-title="<?php echo lang_key_admin('actions');?>" class="numeric">
                    <div class="btn-group">
                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key_admin('action');?> <span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-info">
                          <li><a href="<?php echo site_url('admin/category/edit/'.$row->id);?>"><?php echo lang_key_admin('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/category/delete/'.$row->id);?>"><?php echo lang_key_admin('delete');?></a></li>
                      </ul>
                    </div>
                  </td>
               </tr>
            <?php $i++;endforeach;?>   
           </tbody>
        </table>
        <input type="submit" value="<?php echo lang_key_admin('delete_selected');?>" class="btn btn-danger">
        </form>

        </div>

        <?php }?>
        </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#all-posts').dataTable();

        jQuery('#bulk_delete').submit(function(e){
          var r = confirm("<?php echo lang_key_admin('can_not_undo');?>");
          if (r == true) {
             return truel
          } else {
              return false;
          }

        });

    });
</script>