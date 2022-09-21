<!-- file added on version 1.4 -->
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.carousel.css">
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.theme.default.min.css">

<?php 
$limit = 10;

$CI = get_instance();
$CI->load->model('admin/video_model');
$top_instead_featured = get_settings('global_settings','top_videos_instead_featured','No');
if($top_instead_featured=='No')
$video_query = $CI->video_model->get_featured_videos($limit);
else
$video_query = $CI->video_model->get_popular_videos($limit);

$i=1;
$video_array = array();
foreach ($video_query->result() as $post) {
	array_push($video_array, $post);
	$i++;
}
$i--;
$left = (ceil($i/5)*5)-$i;

if($left>0 && $i>5)
	echo '<script type="text/javascript">var loop=true;</script>';	
else
	echo '<script type="text/javascript">var loop=false;</script>';	


for($i=1;$i<=$left;$i++)
{
	array_push($video_array, array());
}

?>
<div id="owl-demo">

<?php
$i=1;
foreach ($video_array as $post) {  
	$source_title = get_source_title_by_id($post->source_id);
	$source_url = source_video_url($post->source_id,$source_title);            
	if($i==1){
?>
<div class="row banner item">
	<div class="col-md-6 col-sm-6 col-xs-12 first-img">
		<a href="<?php echo post_detail_url($post);?>" class="image-link">
			<img class="img-responsive" src="<?php echo $post->media;?>">
		</a>
		<div class="caption">									
			<span class="label label-danger">
				<a title="<?php echo $source_title;?>" href="<?php echo $source_url;?>"><?php echo $source_title;?></a>
			</span>
			<div class="first-title">
				<a class="item-heading" href="<?php echo post_detail_url($post);?>"><?php echo $post->title;?></a>
			</div>							
			<time datetime="<?php echo translateable_date($post->publish_time)?>" class="the-date"><?php echo translateable_date($post->publish_time)?></time>
		</div>
	</div>
	
<?php }else{?>

	<?php 
	if($i==2){
	?>
	<div class="col-md-6 col-sm-6 col-xs-12 second-img">
	<?php }?>
		<?php
		if(isset($post->media)){
			
		?>
		<div class="col-md-6 col-sm-6 col-xs-6 other-img other-img-<?php echo $i;?>">
			<a href="<?php echo post_detail_url($post);?>" class="image-link">
				<img class="img-responsive" src="<?php echo $post->media;?>">
			</a>
			<div class="caption">									
				<span class="label label-danger">
					<a title="<?php echo $source_title;?>" href="<?php echo $source_url;?>"><?php echo $source_title;?></a>
				</span>
				<div class="other-title">
					<a class="item-heading" href="<?php echo post_detail_url($post);?>"><?php echo $post->title;?></a>
				</div>		
				<time datetime="<?php echo translateable_date($post->publish_time)?>" class="the-date"><?php echo translateable_date($post->publish_time)?></time>					
			</div>

		</div>
		<?php }?>
		<?php 
	if($i==5){
	?>
	</div>
	</div>
	<?php }?>

<?php }
	$i++;
	if($i>5)
	 	$i=1;
}
?>
</div>
<style type="text/css">
	.banner{
		margin: 0;
		padding: 0;
	}
	.banner img{
		width: 100% !important;
	}
	.banner .col-md-6{
		padding: 0;
	}
	.banner .image-link::after {
	  background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.42) 50%, rgba(0, 0, 0, 0.88) 100%) repeat scroll 0 0;
	  bottom: 0;
	  content: "";
	  height: 80%;
	  opacity: 0.92;
	  position: absolute;
	  transition: all 0.3s ease-in 0s;
	  width: 100%;
	  will-change: opacity;
	}
	.first-img{
		padding-right: 5px;
		width: 49:50% !important;
		overflow: hidden;
		border-right: 1px solid #fff;
	}
	.other-img{
/*		height: 175px;
*/		overflow: hidden;
	}
	.other-img-2{
		border-right: 1px solid #fff;
		border-bottom: 1px solid #fff;
	}
	.other-img-3{
		border-bottom: 1px solid #fff;
	}
	.other-img-4{
		border-right: 1px solid #fff;
	}
	.first-img .caption {
	  bottom: 20px;
	  padding-left: 15px;
	  position: absolute;
	}
	.first-img .caption h3{
		font-size: 18px;
	}
	.first-img .caption a{
		color: #fff;
		transition: all 0.3s ease-in 0s;
		opacity: 0.92;
	}
	.first-img .caption:hover a{
		opacity: 1;
	}

	.second-img .caption {
	  bottom: 0px;
	  padding-left: 15px;
	  position: absolute;
	}
	.second-img .caption h3{
		font-size: 12px;
		font-weight: normal;
		line-height: 2.0;
	}
	.second-img .caption a{
		color: #fff;
	}
	.other-img .label-danger{
		opacity: 0;
		transition: all 0.3s ease-out 0s;
	}
	.other-img:hover .label-danger{
		opacity: 1;
	}
	.other-img time{
		font-size: 10px;
	}
	.first-title{
		font-weight: bold;
		font-size: 18px;
	}
	.other-title{
		line-height: 18px;
	}
	@media (max-width: 767px) {
		.first-img{
			border-right: none !important;
			width: 100% !important;
		}
		.other-img{
		}
	}
	@media (max-width: 600px) {
		.first-img{
		}
		.other-img{
		}
	}

	@media (max-width: 480px) {
		.first-img{
		}
		.other-img{
		}
	}

</style>
<script src="<?php echo theme_url();?>/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript">
    

    $(document).ready(function() {
     
      $("#owl-demo").owlCarousel({
     
          rtl:rtl,
          loop:loop,
          autoplay: true,
          responsive:{
              0:{
                  items:1
              },
              600:{
                  items:1
              },
              1000:{
                  items:1
              }
          }

     
      });


       function imageLoaded() {
       	   counter--; 
	       if( counter === 0 ) {
	           calculate_banner_height();
	       }
	    }
	    var images = $('#owl-demo img');
	    var counter = images.length;  // initialize the counter

	    images.each(function() {
	        if( this.complete ) {
	            imageLoaded.call( this );
	        } else {
	            $(this).one('load', imageLoaded);
	        }
	    });


       jQuery(window).resize(function(){
       		calculate_banner_height();
       });

       $( window ).on( "orientationchange", function( event ) {	   
	       calculate_banner_height();
	   });

       
     
    });

    function calculate_banner_height()
    {
      $('.other-img').css('height','auto');
      $('.first-img').css('height','auto');

      var min_height = 1000;
      $('.other-img').each(function(){
      	var height = $(this).height(); 
      	if(height<min_height)
      		min_height = height;
      });

      if(min_height==1000)
      	min_height = 180;

      var main_img_min_height = 1000;
      $('.first-img').each(function(){
      	var height = $(this).height(); 
      	if(height<main_img_min_height)
      		main_img_min_height = height;
      });

      if(min_height*2>main_img_min_height)
      	min_height = main_img_min_height/2;

      $('.other-img').each(function(){
      	$(this).css('height',min_height);
      });
      $('.first-img').css('height',2*min_height);
    }

</script>