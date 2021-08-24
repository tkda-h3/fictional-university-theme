<?php
get_header();
?>
<?php page_banner(array(
    'title' => 'All Campuses',
    'subtitle' => '学問に集中できるキャンパスたち',
)) ?>

<div class="container container--narrow page-section">
    <div class="acf-map">
        <?php while (have_posts()) : the_post(); ?>
            <?php $map_location = get_field('map_location'); ?>
            <?php if ($map_location) : ?>
                <div class="marker" data-lat="<?php echo $map_location['lat'] ?>" data-lng="<?php echo $map_location['lng'] ?>">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php echo $map_location['address']; ?>
                </div>
            <?php endif; ?>

        <?php endwhile;
        echo paginate_links();
        ?>
    </div>

</div>
<?php
get_footer();
?>