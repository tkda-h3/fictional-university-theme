<?php
get_header();
?>
<?php page_banner(array(
    'title' => '講義一覧',
    'subtitle' => '最先端の技術を習得しよう',
)) ?>

<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php while (have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php
        endwhile;
        ?>
    </ul>
    <div class="pagination">
        <?php echo paginate_links(); ?>
    </div>
</div>
<?php
get_footer();
?>