<?php
get_header();
?>
<?php page_banner(array(
    'title' => get_the_archive_title(),
    'subtitle' => '開催予定の楽しいイベントを確認しよう',
)) ?>
<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('template-parts/content', 'event'); ?>
    <?php
    endwhile;
    echo paginate_links();
    ?>

    <hr class="section-break">
    <p>過去のイベントをお探しですか？<a href="<?php echo site_url('/past-events') ?>">過去のイベントの一覧はこちら</a></p>
</div>
<?php
get_footer();
?>