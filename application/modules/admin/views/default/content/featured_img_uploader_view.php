<!-- Bootstrap 3 Plan styles -->
<link id="plan-theme" href="<?php echo base_url();?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/admin/js/jquery.js">\x3C/script>')</script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>
<style type="text/css">
    body{
        background-color: #fff;
    }
</style>

<div id="trainingrecords-attachments" target=".trainingrecords-attachment-list">
    <div class="progress span3" style="display:none;margin:2px;padding:2px;">
        <div class="bar" style="background:#1A8FBF none repeat scroll 0 0;text-align:center"></div >
        <div class="percent">0%</div >
    </div>

    <form action="<?php echo site_url('admin/content/uploadfeaturedimage');?>" method="post" enctype="multipart/form-data">
        <ol class="filelist">
        </ol>
        <input type="file" name="photoimg" id="photoimg_featured" style="height:auto;" >
    </form>
    <div class="status"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){

        var tab = 'trainingrecords-attachments';
            var target = jQuery('#'+tab).attr('target');
            var bar = jQuery('#trainingrecords-attachments > .progress > .bar');
            var percent = jQuery('#trainingrecords-attachments > .progress > .percent');
            var progress = jQuery('#trainingrecords-attachments > .progress');

         jQuery('#photoimg_featured').change(function(){
            

            var formData = new FormData();
            var files = $("#photoimg_featured")[0].files;
            formData.append('photoimg', files[0]);

            var uploadURL = '<?php echo site_url("admin/content/uploadfeaturedimage");?>'; //Upload URL
            var extraData ={}; //Extra Data.
            var jqXHR=$.ajax({
                    xhr: function() {
                    var xhrobj = $.ajaxSettings.xhr();
                    if (xhrobj.upload) {
                            xhrobj.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                    var percentVal = percent+'%';
                                    bar.width(percentVal);
                                   jQuery('#trainingrecords-attachments > .progress > .bar').html(percentVal); 
                                }
                                
                            }, false);
                        }
                    return xhrobj;
                },
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
                cache: false,
                data: formData,
                beforeSend: function() {
                    //jQuery('#myModal').modal('show');
                    progress.show();
                    var percentVal = '0%';
                    bar.width(percentVal);
                   jQuery('#trainingrecords-attachments > .progress > .bar').html(percentVal);   
                },
                success: function(data){
                 
                    var percentVal = '100%';
                    bar.width(percentVal);
                   jQuery('#trainingrecords-attachments > .progress > .bar').html(percentVal);

                    var response = jQuery.parseJSON(data);
                   
                    if(response.error==0)
                    {
                        var base_url = "<?php echo base_url();?>uploads/";
                        //window.parent.jQuery('#featured_photo_input').attr("value",response.name);
                        window.parent.jQuery('#featured_photo_input').attr("value",response.name);
                        window.parent.jQuery('#featured_photo_input').trigger('change');
                    }
                    else
                    {
                        if(response.error=='upload_invalid_min_dimensions')
                            response.error = 'Image needs to be minimum 256x256 px';
                        var error = '<label class="col-sm-3 col-lg-2">&nbsp;</label><div class="col-sm-4 col-lg-5"><div class="alert alert-danger" style="margin-bottom:0;">'+response.error+'</div></div>';
                        window.parent.jQuery('#featured-photo-error').html(error);
                    }

                     progress.hide();               
                }
            });

    });


        
    });
</script>
