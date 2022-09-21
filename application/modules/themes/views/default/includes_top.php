<?php 
$compress_css = get_settings('site_settings','css_compression','No');
if($compress_css=='Yes')
{
?>
<link href="<?php echo theme_url();?>/assets/css/all-css.php" rel="stylesheet" type="text/css" />
<?php
}
else
{
?>
    <link href="<?php echo theme_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/jquery.mCustomScrollbar.css">
    <link href="<?php echo theme_url();?>/assets/css/styles/style.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/styles/skin-lblue.css" rel="stylesheet" id="color_theme">

    <link href="<?php echo theme_url();?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/custom-style.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/custom-media.css" rel="stylesheet">
<?php
}
?>

<script src="<?php echo theme_url();?>/assets/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/jquery.lazyload.js"></script>
<script src="<?php echo theme_url();?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/jquery.tooltipster.min.js"></script>