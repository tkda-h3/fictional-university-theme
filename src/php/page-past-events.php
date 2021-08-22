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
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
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

        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                    <?php echo (new DateTime(get_field('event_date')))->format('M'); ?>
                </span>
                <span class="event-summary__day">
                    <?php echo (new DateTime(get_field('event_date')))->format('d'); ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>
    <?php
    endwhile;
    echo paginate_links(array(
        'total' => $query->max_num_pages,
    ));
    ?>
</div>
<?php
get_footer();
?>