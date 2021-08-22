<?php
get_header();

while (have_posts()) {
    the_post(); ?>

<?php page_banner(array(
    'title' => get_the_title(),
    // 'background-image' => '',
)) ?>

    <!-- <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/img/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>変更を忘れるな</p>
            </div>
        </div>
    </div> -->
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Event Home
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <?php $related_programs = get_field('related_programs'); ?>
        <?php if ($related_programs) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Program(s)</h2>
            <ul class="link-list min-list">
                <?php foreach ($related_programs as $program) : ?>
                    <li><a href="<?php the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php }

get_footer();
?>