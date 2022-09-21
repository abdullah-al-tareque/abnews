<!DOCTYPE html>

<html lang="en">

<head>
    <!-- <?php echo (isset($alias))?$alias:'';?> -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <?php

    $page = get_current_page();


    if (!isset($sub_title))
        $sub_title = (isset($page['title'])) ? $page['title'] : lang_key('list_your_ad');

    $seo = (isset($page['seo_settings']) && $page['seo_settings'] != '') ? (array)json_decode($page['seo_settings']) : array();

    if (!isset($meta_desc))
        $meta_desc = (isset($seo['meta_description'])) ? $seo['meta_description'] : get_settings('site_settings', 'meta_description', 'autocon car dealership');

    if (!isset($key_words))
        $key_words = (isset($seo['key_words'])) ? $seo['key_words'] : get_settings('site_settings', 'key_words', 'car dealership,car listing, house, car');

    if (!isset($crawl_after))
        $crawl_after = (isset($seo['crawl_after'])) ? $seo['crawl_after'] : get_settings('site_settings', 'crawl_after', 3);

    ?>



    <title><?php echo translate(get_settings('site_settings', 'site_title', 'Videopilot')); ?>
        | <?php echo translate($sub_title); ?></title>

    <?php
    if(isset($post))
    {
        echo (isset($post))?social_sharing_meta_tags_for_post($post):'';
    }
    else if(isset($page))
    {
        echo social_sharing_meta_tags_for_pages($alias,translate(get_settings('site_settings', 'site_title', 'Videopilot')).'-'.translate($sub_title),$meta_desc,$key_words);
    }
    else
    {
    ?>
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <meta name="keywords" content="<?php echo $key_words; ?>"/>
    <meta name="revisit-after" content="<?php echo $crawl_after; ?> days">
    <?php
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo theme_url();?>/assets/img/favicon.png">
    <?php require_once 'includes_top.php'; ?>


<script type="text/javascript">var old_ie = 0;var rtl=false;</script>
<!--[if lte IE 8]> <script type="text/javascript"> old_ie = 1; </script> < ![endif]-->

</head>



<?php
$CI = get_instance();
$curr_lang = get_current_lang();
if($curr_lang=='ar' || $curr_lang=='fa' || $curr_lang=='he' || $curr_lang=='ur' || get_settings('site_settings','site_direction','ltr')=='rtl')
{
    $rtl = true;
?>
<script type="text/javascript">rtl=true;</script>
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/rtl-fix.css">
<body class="home" dir="rtl">
<?php 
}else{
?>
<body class="home" dir="<?php echo get_settings('site_settings','site_direction','ltr');?>">
<?php 
}
?>

<!-- Outer Starts -->
<!-- added on version 1.4 -->
<div class="outer">
<?php require_once 'header.php'; ?>

<?php 
if($alias=='home'){
if(get_settings('global_settings','enable_featured_video_carousel','Slider')!='None'){?>
<div class="banner-block">
    <div class="container">
        <?php 
        if(get_settings('global_settings','enable_featured_video_carousel','Slider')=='Carousel') 
            require_once'carousel_view.php';
        else
            require_once'banner_view.php';
        ?>
    </div>
</div>
<?php }
}
?>
<!-- end -->
<!-- Main content starts -->
<div class="main-block">
    <?php echo (isset($content))?$content:'';?>
</div>

<!-- Main content ends -->
<?php require_once 'footer.php'; ?>


</div>
<?php require_once 'includes_bottom.php'; ?>

<?php 
if(get_settings('global_settings','enable_cookie_policy_popup','No')=='Yes'){
    require_once 'eu_cookie_popup.php';     
}
?>

</body>

</html>