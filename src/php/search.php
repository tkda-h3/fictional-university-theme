<?php
get_header();
?>

<?php page_banner(array(
  'title' => '「' . esc_html(get_search_query()) . '」の検索結果',
)) ?>

<div class="container container--narrow page-section">
  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post(); ?>
      <?php get_template_part('template-parts/content', get_post_type()); ?>

    <?php
    endwhile;
    ?>
    <div class="pagination">
      <?php echo paginate_links(); ?>
    </div>
  <?php else : ?>
    <h2 class="haedline haedline--medium">合致する検索結果は見つかりませんでした。</h2>
    <?php get_search_form(); ?>
  <?php endif; ?>
</div>
<?php
get_footer();
?>