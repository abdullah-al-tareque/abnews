<!-- file added on version 1.3 -->
<ul class="all_sub_category">

    <?php
    $class = 'orange';
    foreach ($posts->result() as $child) :
        $sub_category_url = category_video_url($child->id,$child->title);
    ?>

    <li>
        <a class="" title="<?php echo lang_key($child->title);?>" href="<?php echo $sub_category_url;?>">
            <?php echo lang_key($child->title);?>
            <span dir="rtl" class="category-counter <?php echo $class;?> color">(<?php echo count_videos_by_subcategory($child->id);?>)&nbsp;</span>
        </a>
    </li>

    <?php
    endforeach;
    ?>
</ul>
<style type="text/css">
	.all_sub_category{
		list-style: none;
		margin-left: 0;
		padding-left:10px;
	}
</style>