<?php
get_header();

while (have_posts()) {
    the_post(); ?>

    <?php page_banner(); ?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>ブログ一覧
                </a>
                <span class="metabox__main"><a href="<?php echo get_month_link(get_the_date('Y'), get_the_date('m')); ?>"><?php the_time('Y-m-d'); ?></a> in <?php echo get_the_category_list(', '); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php }

get_footer();
?>