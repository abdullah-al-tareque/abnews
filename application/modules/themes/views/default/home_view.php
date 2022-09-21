<?php
$search_active = get_settings('global_settings', 'show_home_page_search', 'yes');
if($search_active == 'yes')
{
  //  require 'home_custom_search.php';
}
?>

<!-- Container -->
<div class="container main-container">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php render_widgets('home_page');?>
        </div>


    </div>
</div>
