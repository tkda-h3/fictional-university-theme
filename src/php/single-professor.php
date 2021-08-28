<?php
get_header();

while (have_posts()) {
    the_post(); ?>
    <?php page_banner(); ?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professor-portrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php
                    $like_count = new WP_Query(array(
                        'post_type' => 'like',
                        'meta_query' => array(
                            array(
                                'key' => 'liked_professor_id',
                                'compare' => '=',
                                'value' => get_the_ID(),
                            )
                        ),
                    ));

                    $exist_status = 'no';

                    // 'author' => 0,
                    // を指定するとAll authorを意味してしまうのでクエリをログイン時に限定
                    if (is_user_logged_in()) {
                        $exist_query = new WP_Query(array(
                            'author' => get_current_user_id(),
                            'post_type' => 'like',
                            'meta_query' => array(
                                array(
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => get_the_ID(),
                                )
                            ),
                        ));
                        if ($exist_query->found_posts) {
                            $exist_status = 'yes';
                        }
                    }
                    ?>

                    <span class="like-box" data-exists="<?php echo $exist_status; ?>" data-professor-id="<?php the_ID(); ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $like_count->found_posts; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        user_id
        <?php echo get_current_user_id(); ?>

        <?php $related_programs = get_field('related_programs'); ?>
        <?php if ($related_programs) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">担当教科</h2>
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