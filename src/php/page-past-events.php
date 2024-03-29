<?php
get_header();
?>
<?php page_banner(array(
    'title' => 'Past Events',
    'subtitle' => 'See what is going on in our world.',
)) ?>

<div class="container container--narrow page-section">
    <?php
    // 今日より古い開催日
    $query = new WP_Query(
        array(
            'post_type' => 'event',
            'paged' => get_query_var('paged', 1),
            'meta_key' => 'event_date',
            'orderby' => array(
                'meta_value_num' => 'ASC',
                'title' => 'ASC',
            ),
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                )
            ),
        )
    );
    ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <?php get_template_part('template-parts/content', 'event'); ?>
    <?php
    endwhile;
    ?>
    <div class="pagination">
        <?php echo paginate_links(array(
            'total' => $query->max_num_pages,
        )); ?>
    </div>
</div>
<?php
get_footer();
?>