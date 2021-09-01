<?php
$query = new WP_Query(
  array(
    'post_type' => 'slide',
    'posts_per_page' => $posts_per_page,
    'orderby' => 'title',
    'order' => 'ASC',
  )
);
?>


<?php if ($query->have_posts()) : ?>
  <div class="hero-slider">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <?php
      $slide_image = get_field('slide_image')['sizes']['slideshow'];
      $slide_headline = get_field('slide_headline');
      $slide_text = get_field('slide_text');
      $slide_link = get_field('slide_link');
      ?>
      <div class="hero-slider__slide" style="background-image: url(<?php echo $slide_image; ?>);">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center"><?php echo $slide_headline; ?></h2>
            <?php if ($slide_text) : ?>
              <p class="t-center"><?php echo $slide_text; ?></p>
            <?php endif; ?>
            <?php if ($slide_link) : ?>
              <p class="t-center no-margin"><a href="<?php echo $slide_link; ?>" class="btn btn--blue">詳しく見る</a></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>