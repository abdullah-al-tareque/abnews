<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo $title;?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
        <?php $this->load->helper('text');?>
        <?php echo $this->session->flashdata('msg');?>
        <?php if($posts->num_rows()<=0){?>
        <div class="alert alert-info"><?php echo lang_key_admin('no_sources');?></div>
        <?php }else{?>
        <div id="no-more-tables">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>
                  <th class="numeric">#</th>
                  <th class="numeric"><?php echo lang_key_admin('source_name');?></th>
                  <th class="numeric"><?php echo lang_key_admin('source_type');?></th>
                  <th class="numeric"><?php echo lang_key_admin('auto_grabbing');?></th>
                  <th class="numeric"><?php echo lang_key_admin('parent_category');?></th>
                  <th class="numeric"><?php echo lang_key_admin('sub_category');?></th>
                  <th class="numeric"><?php echo lang_key_admin('actions');?></th>
               </tr>
           </thead>
           <tbody>
        	<?php $i=1;foreach($posts->result() as $row):?>
               <tr>
                  <td data-title="#" class="numeric"><?php echo $i;?></td>
                  <td data-title="<?php echo lang_key_admin('source_name');?>" class="numeric"><a href="<?php echo site_url('admin/content/addsource/'.$row->id);?>"><?php echo $row->source_name;?></a></td>
                  <td data-title="<?php echo lang_key_admin('source_type');?>" class="numeric"><?php echo lang_key_admin($row->source_type);?></td>
                  <td data-title="<?php echo lang_key_admin('auto_grabbing');?>" class="numeric">
                    <?php echo ($row->auto_grabbing==1)?'<span class="label label-success">'.lang_key_admin('yes').'</span>':'<span class="label label-danger">'.lang_key_admin('no').'</span>';?>
                  </td>
                  <td data-title="<?php echo lang_key_admin('parent_category');?>" class="numeric"><?php echo get_category_title_by_id($row->parent_category);?></td>
                  <td data-title="<?php echo lang_key_admin('sub_category');?>" class="numeric"><?php echo get_category_title_by_id($row->sub_category);?></td>
                  <td data-title="<?php echo lang_key_admin('actions');?>" class="numeric">
                    <div class="btn-group">
                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key_admin('action');?> <span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-info">
                          <li><a href="<?php echo site_url('grab/grabsingle/'.$row->id.'/manual');?>"><?php echo lang_key_admin('grabnow');?></a></li>
                          <li><a href="<?php echo site_url('admin/content/addsource/'.$row->id);?>"><?php echo lang_key_admin('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/content/deletesource/0/'.$row->id);?>"><?php echo lang_key_admin('delete');?></a></li>
                      </ul>
                    </div>
                  </td>
               </tr>
            <?php $i++;endforeach;?>   
           </tbody>
        </table>
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
    });
</script>