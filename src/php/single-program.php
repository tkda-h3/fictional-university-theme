<?php
get_header();

while (have_posts()) {
    the_post(); ?>

<?php page_banner(); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> All Programs
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <?php
        // https://www.advancedcustomfields.com/resources/querying-relationship-fields/
        $query = new WP_Query(
            array(
                'post_type' => 'professor',
                'posts_per_page' => -1,
                // 'meta_key' => 'event_date',
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'related_programs',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"', // serialized array で完全一致で検索する
                    )
                ),
            )
        );
        ?>

        <?php if ($query->have_posts()) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium"><?php the_title(); ?>の教授</h2>
            <ul class="">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li class="professor-card__list-item">
                        <a class="professor-card" href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('professor-landscape'); ?>" alt="" class="professor-card__image">
                            <span class="professor-card__name"><?php the_title(); ?></span>
                        </a>
                    </li>
                <?php endwhile;  ?>
            </ul>
        <?php endif;  ?>
        <?php wp_reset_postdata(); ?>
        <!-- professor end -->

        <?php
        $query = new WP_Query(
            array(
                'post_type' => 'event',
                'posts_per_page' => 2,
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => date('Ymd'),
                        'type' => 'numeric'
                    ),
                    array(
                        'key' => 'related_programs',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"', // serialized array で完全一致で検索する
                    )
                ),
            )
        );
        ?>

        <?php if ($query->have_posts()) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium"><?php the_title(); ?> の予定イベント</h2>
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
                        <p><?php
                            if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                echo wp_trim_words(get_the_content(), 18);
                            } ?><a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
                        </p>
                    </div>
                </div>
        <?php endwhile;
        endif; ?>
        <?php wp_reset_postdata(); ?>



    </div>
<?php }

get_footer();
?>