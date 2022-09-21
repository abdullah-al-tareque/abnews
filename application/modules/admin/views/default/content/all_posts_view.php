<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<?php 
$curr_page = $this->uri->segment(4);
if($curr_page=='')
  $curr_page = 0;
$dl = default_lang();
?>
<div class="row">
  

  <div class="col-md-12">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key_admin('all_videos');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php echo $this->session->flashdata('msg');?>

        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          
          <form action="<?php echo site_url('admin/content/allposts_ajax/0');?>" method="post" id="table-search-from" class="form-inline">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-group" style="float:right;width:170px;margin-left:5px;">
                  <input type="text" name="key" class="form-control" id="key" placeholder="<?php echo lang_key_admin('title_city_category');?>">
                  <div class="input-group-addon search-plain" style="cursor:pointer;border-radius:0 5px 5px 0"><i class="fa fa-search"></i></div>
                </div>

                <select name="filter_by" id="filter_by" class="form-control" style="width:150px;float:right;">
                    <?php $options = array('all','only_published','only_pending','only_featured');?>
                    <?php foreach($options as $opt){?>
                    <?php $sel = ($this->session->userdata('filter_by')==$opt)?'selected="selected"':'';?>
                    <option value="<?php echo $opt;?>" <?php echo $sel;?>><?php echo lang_key_admin($opt);?></option>
                    <?php }?>
                </select>
              </div>
          </form>

        </div>

        <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
            <img src="<?php echo base_url('assets/images/loading.gif');?>" style="width:20px;margin:5px;display:none" class="loading pull-right">
        </div>
        

        </div>
        <form action="<?php echo site_url('admin/content/bulkdeletevideo');?>" method="post" id="bulk_delete">
        <span class="msg-borad"></span>
        <div id="no-more-tables" class="table-responsive" style="border:0">

        </div>
        <input type="submit" value="<?php echo lang_key_admin('delete_selected');?>" class="btn btn-danger">
        </form>
  
      </div>

    </div>

  </div>

</div>



<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
      var bulk_del_msg = "<?php echo lang_key_admin('video_deleted');?>";
      jQuery('#bulk_delete').submit(function(e){
          e.preventDefault();
          jQuery('.loading').show();
          var load_url = jQuery(this).attr('action');
          jQuery.post(
              load_url,
              $("#bulk_delete").serialize(),
              function(responseText){   
                  $('#table-search-from').submit();
                  $('.msg-borad').html('<div class="alert alert-success">'+bulk_del_msg+'</div>');
              }
          ); 
      });

      jQuery('#filter_by').change(function(){
        $('#table-search-from').attr('action','<?php echo site_url();?>/admin/content/allposts_ajax/0');
        $('#table-search-from').submit();
      });

      $('#table-search-from').submit(function(e){
        e.preventDefault();
        jQuery('.loading').show();
        var load_url = jQuery(this).attr('action');
        jQuery.post(
            load_url,
            {key:$('#key').val(),'filter_by':$('#filter_by').val()},
            function(responseText){        
                jQuery('.loading').hide();
                jQuery('#no-more-tables').html(responseText);
                initPaging();
            }
        ); 
      });

      $('.search-plain').click(function(){
         var start = '<?php echo ($this->uri->segment("4")!="")?$this->uri->segment("4"):0;?>';
        $('#table-search-from').attr('action','<?php echo site_url();?>/admin/content/allposts_ajax/'+start);        
        $('#table-search-from').submit();
      }).click();

      initPaging();
});

function initPaging()
{
      //jQuery('#all-posts').dataTable();
    var page_num = "<?php echo $curr_page?>";

    $('.pagination a').click(function(e){
      // e.preventDefault();
      // var load_url = jQuery(this).attr('href');
      // if(load_url!='#')
      // {
      //   $('#table-search-from').attr('action',load_url);
      //   $('#table-search-from').submit();      
      // }
    });

    jQuery('#select_all').click(function(){
        if(jQuery(this).attr('checked')=='checked')
        {
          jQuery('input[type=checkbox]').attr('checked','checked');
        }
        else
        {
          jQuery('input[type=checkbox]').removeAttr('checked');          
        }
    });

      jQuery('input[type=checkbox]').click(function(){
        if(jQuery(this).attr('checked')=='checked')
        {          
        }
        else
        {
          jQuery('#select_all').removeAttr('checked');          
        }
    });
}
</script>