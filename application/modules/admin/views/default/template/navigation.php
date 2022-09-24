<div id="sidebar" class="navbar-collapse collapse">

    <div id="sidebar-collapse" class="">


        <i class="fa fa-angle-double-left"></i>


    </div>

    <ul class="nav nav-list">
        <?php if (is_admin()) { ?>
            <!--<li class="active"> HIGHLIGHTS MENU-->
            <li class="<?php echo is_active_menu('admin/index'); ?>">
                <a href="<?php echo site_url('admin/index'); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span><?php echo lang_key_admin("dashboard"); ?></span>
                </a>
            </li>
            
        <?php } ?>

        
        <li class="<?php echo is_active_menu('admin/content'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-plus-circle"></i>
                <span><?php echo lang_key_admin("content"); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>

            <ul class="submenu">

                <li class="<?php echo is_active_menu('admin/content/allvideos'); ?>">
                    <a href="<?php echo site_url('admin/content/allvideos'); ?>">
                        <?php echo lang_key_admin('all_videos'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/content/createvideo'); ?>">
                    <a href="<?php echo site_url('admin/content/createvideo'); ?>">
                        <?php echo lang_key_admin('new_video'); ?>
                    </a>
                </li>


                <?php if(is_admin()){?>
                <li class="hidden <?php echo is_active_menu('admin/content/clearoldvideos'); ?>">
                    <a href="<?php echo site_url('admin/content/clearoldvideos'); ?>">
                        <?php echo lang_key_admin('clear_old_videos'); ?>
                    </a>
                </li>

                <li class="hidden <?php echo is_active_menu('admin/content/allsources'); ?>">
                    <a href="<?php echo site_url('admin/content/allsources'); ?>">
                        <?php echo lang_key_admin('all_sources'); ?>
                    </a>
                </li>

                <li class="hidden <?php echo is_active_menu('admin/content/addsource'); ?>">
                    <a href="<?php echo site_url('admin/content/addsource'); ?>">
                        <?php echo lang_key_admin('new_source'); ?>
                    </a>
                </li>

                <li class="hidden <?php echo is_active_menu('admin/content/settings'); ?>">
                    <a href="<?php echo site_url('admin/content/settings'); ?>">
                        <?php echo lang_key_admin('site_settings'); ?>
                    </a>
                </li>                
                <?php }?>
                
            </ul>
        </li>


        <?php if (is_admin()) { ?>

        <li class="<?php echo is_active_menu('admin/category/'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-bars"></i>
                <span><?php echo lang_key_admin('category'); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>

            <ul class="submenu">
                <li class="<?php echo is_active_menu('admin/category/all'); ?>">
                    <a href="<?php echo site_url('admin/category/all'); ?>">
                        <?php echo lang_key_admin('all_categories'); ?>
                    </a>
                </li>
                <li class="<?php echo is_active_menu('admin/category/newcategory'); ?>">
                    <a href="<?php echo site_url('admin/category/newcategory'); ?>">
                        <?php echo lang_key_admin('new_category'); ?>
                    </a>
                </li>
            </ul>
        </li>

        <?php } ?>

        <li class="<?php echo is_active_menu('admin/editprofile'); ?>">
            <a href="<?php echo site_url('admin/editprofile'); ?>">
                <i class="fa fa-user"></i>
                <span><?php echo lang_key_admin('profile'); ?></span>
            </a>
        </li>

        <?php if (is_admin()) { ?>
            <li class="<?php echo is_active_menu(array('admin/users','admin/edituser')); ?>">
                <a href="<?php echo site_url('admin/users'); ?>">
                    <i class="fa fa-users"></i>
                    <span><?php echo lang_key_admin('users'); ?></span>
                </a>
            </li>

            <li class="hidden <?php echo is_active_menu('admin/themes'); ?>">
                <a href="<?php echo site_url('admin/themes'); ?>">
                    <i class="fa fa-desktop"></i>
                    <span><?php echo lang_key_admin("themes"); ?></span>
                </a>
            </li>


            <li class="hidden <?php echo is_active_menu('admin/widgets/'); ?>">
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-bars"></i>
                    <span><?php echo lang_key_admin('widgets'); ?></span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <ul class="submenu">
                    <li class="<?php echo is_active_menu('admin/widgets/all'); ?>"><a
                            href="<?php echo site_url('admin/widgets/all'); ?>">
                            <?php echo lang_key_admin('all_widgets'); ?>
                        </a>
                    </li>
                    <li class="<?php echo is_active_menu('admin/widgets/widgetpositions'); ?>"><a
                            href="<?php echo site_url('admin/widgets/widgetpositions'); ?>">
                            <?php echo lang_key_admin('widget_positions'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            
    
            <li class="<?php echo is_active_menu('admin/page/'); ?>">
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-file-o"></i>
                    <span><?php echo lang_key_admin('pages'); ?></span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <ul class="submenu">
                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->
                    <li class="<?php echo is_active_menu('admin/page/all'); ?>"><a
                            href="<?php echo site_url('admin/page/all'); ?>"><?php echo lang_key_admin('all_pages'); ?></a></li>

                    <li class="<?php echo is_active_menu('admin/page/index'); ?>"><a
                            href="<?php echo site_url('admin/page/index'); ?>"><?php echo lang_key_admin('new_page'); ?></a></li>

                    <li class="hidden <?php echo is_active_menu('admin/page/menu'); ?>"><a
                            href="<?php echo site_url('admin/page/menu'); ?>"><?php echo lang_key_admin('menu'); ?></a></li>
                </ul>


            </li>

            <li class="<?php echo is_active_menu('admin/system'); ?>">
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-cog"></i>
                    <span><?php echo lang_key_admin('system'); ?></span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <ul class="submenu">
                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->

                    <li class="hidden <?php echo is_active_menu('admin/system/allbackups'); ?>"><a
                            href="<?php echo site_url('admin/system/allbackups'); ?>"><?php echo lang_key_admin('manage_backups'); ?></a></li>

                    <li class="<?php echo is_active_menu('admin/system/smtpemailsettings'); ?>"><a
                            href="<?php echo site_url('admin/system/smtpemailsettings'); ?>"><?php echo lang_key_admin('smtp_email_settings'); ?></a>
                    </li>

                    <li class="hidden <?php echo is_active_menu('admin/system/translate'); ?>"><a
                            href="<?php echo site_url('admin/system/translate'); ?>"><?php echo lang_key_admin('auto_translate'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/emailtmpl'); ?>"><a
                            href="<?php echo site_url('admin/system/emailtmpl'); ?>"><?php echo lang_key_admin('edit_email_text'); ?></a></li>

                    <li class="hidden <?php echo is_active_menu('admin/system/debugemail'); ?>"><a
                            href="<?php echo site_url('admin/system/debugemail'); ?>"><?php echo lang_key_admin('debug_email'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/sitesettings'); ?>"><a
                            href="<?php echo site_url('admin/system/sitesettings'); ?>"><?php echo lang_key_admin('default_site_settings'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/settings'); ?>"><a
                            href="<?php echo site_url('admin/system/settings'); ?>"><?php echo lang_key_admin('admin_settings'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/generatesitemap'); ?>"><a
                            href="<?php echo site_url('admin/system/generatesitemap'); ?>"><?php echo lang_key_admin('sitemap'); ?></a></li>


                </ul>


            </li>



        <?php } ?>


    </ul>





</div>