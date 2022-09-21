<h5 class="bold"><i class="fa fa-rocket"></i>  Follow Us</h5>
                    <div class="brand-bg">
                        <!-- Social Media Icons -->
                        <a class="facebook" href="https://www.facebook.com/"><i class="fa fa-facebook circle-3"></i></a>
                        <a class="twitter" target="_blank" href="https://twitter.com/"><i class="fa fa-twitter circle-3"></i></a>
                        <a class="google-plus" href="#"><i class="fa fa-google-plus circle-3"></i></a>
                        <a class="linkedin" href="#"><i class="fa fa-linkedin circle-3"></i></a>
                        <a class="pinterest" href="#"><i class="fa fa-pinterest circle-3"></i></a>
<a class="pinterest" href="<?php echo site_url('show/feed');?>"><i class="fa fa-rss  circle-3"></i></a>
                    </div>

<div class="clearfix" style="height: 10px"></div>
<?php if(@file_exists('./sitemap.xml')){?>
    <h5 class="bold"><i class="fa fa-sitemap"></i>  <?php echo lang_key('site_map');?></h5>
    <a href="<?php echo site_url('show/sitemap')?>"><?php echo lang_key('show_site_map');?></a>
<?php }?>
