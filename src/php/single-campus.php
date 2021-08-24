<?php
get_header();

while (have_posts()) {
    the_post(); ?>

    <?php page_banner(array(
        // 'title' => get_the_title(),
    )) ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>All Campuses
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <?php $map_location = get_field('map_location'); ?>
        <?php if ($map_location) : ?>
            <div class="acf-map">
                <div class="marker" data-lat="<?php echo $map_location['lat'] ?>" data-lng="<?php echo $map_location['lng'] ?>">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php echo $map_location['address']; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- related programs -->
        <?php
        $query = new WP_Query(
            array(
                'post_type' => 'program',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'related_campus',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"',
                    )
                ),
            )
        );
        ?>

        <?php if ($query->have_posts()) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">開講科目</h2>
            <ul class="link-list min-list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
<?php }

get_footer();
?>