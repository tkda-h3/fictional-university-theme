<?php

if (!is_user_logged_in()) {
  wp_redirect(esc_url(site_url('/')));
}

get_header();

while (have_posts()) {
  the_post(); ?>

  <?php page_banner(); ?>

  <div class="container container--narrow page-section">
    <ul class="min-list link-list" id="my-notes">
      <?php
      $query = new WP_Query(array(
        'post_type' => 'note',
        'posts_per_page' => -1,
        'author' => get_current_user_id(),
      ));

      while ($query->have_posts()){
        $query->the_post();
      ?>
      <li data-id="<?php the_ID(); ?>">
        <input type="text" value="<?php echo esc_attr(get_the_title()); ?>" class="note-title-field">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> 編集</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> 削除</span>
        <textarea name="" id="" cols="30" rows="10" class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
      </li>

      <?php
      }
      ?>
    </ul>
  </div>
<?php }

get_footer();
?>