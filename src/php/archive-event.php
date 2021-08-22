<?php
get_header();
?>
<?php page_banner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.',
)) ?>
<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('template-parts/content', 'event'); ?>
    <?php
    endwhile;
    echo paginate_links();
    ?>

    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our paset events archive.</a></p>
</div>
<?php
get_footer();
?>