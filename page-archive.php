<?php
/**
 * Created by PhpStorm.
 * User: JackyCui
 * Date: 15/4/1
 * Time: 19:42
 */

?>
<?php get_header(); ?>
<?php get_template_part( 'includes/breadcrumbs');?>
    <!-- Header Banner -->
<?php $headerad=ot_get_option('headerad');if (!empty($headerad)) {?>
    <div id="header-banner">
        <div class="container">
            <?php echo ot_get_option('headerad');?>
        </div>
    </div>
<?php }?>
    <!-- /.Header Banner -->
    <!-- Main Wrap -->
    <div id="main-wrap">
        <div id="single-blog-wrap" class="container two-col-container">
            <div id="main-wrap-left">
                <!-- Content -->
                <div class="content">

                    <?php  wp_easyarchives(); ?>

                    <!-- Single Activity -->
                    <div class="sg-act">
                        <?php get_template_part('includes/like_collect'); ?>
                        <?php get_template_part('includes/bdshare'); ?>
                    </div>
                    <!-- /.Single Activity -->

                    <?php $singlebottomad=ot_get_option('singlebottomad');if (!empty($singlebottomad)) {?>
                        <div id="singlebottom-banner">
                            <?php echo ot_get_option('singlebottomad');?>
                        </div>
                    <?php }?>
                    <!-- Single Author Info -->
                    <?php get_template_part('includes/author-info'); ?>
                    <!-- /.Single Author Info -->
                </div>
                <!-- /.Content -->
            </div>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /.Sidebar -->
        </div>
    </div>
    <!--/.Main Wrap -->
    <!-- Bottom Banner -->
<?php $bottomad=ot_get_option('bottomad');if (!empty($bottomad)) {?>
    <div id="bottom-banner">
        <div class="container">
            <?php echo ot_get_option('bottomad');?>
        </div>
    </div>
<?php }else{?>
    <div style="height:50px;"></div>
<?php }?>
    <!-- /.Bottom Banner -->
<?php if(ot_get_option('footer-widgets-singlerow') == 'on'){?>
    <div id="ft-wg-sr">
        <div class="container">
            <?php dynamic_sidebar( 'footer-row'); ?>
        </div>
    </div>
<?php }?>
<?php get_footer(); ?>