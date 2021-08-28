<?php

if (!is_user_logged_in()) {
  wp_redirect(esc_url(site_url('/')));
}

get_header();

while (have_posts()) {
  the_post(); ?>

  <?php page_banner(); ?>

  <div class="container container--narrow page-section">
    <div class="create-note">
      <h2 class="headline headline--medium">新しいノートを作成する</h2>
      <input type="text" class="new-note-title" placeholder="タイトルを入力してください">
      <textarea cols="30" rows="10" class="new-note-body" placeholder="コンテンツを入力してください"></textarea>
      <span class="submit-note">ノートを作成</span>
    </div>

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
      <li data-id="<?php the_ID(); ?>" data-state='cancel'>
        <input readonly type="text" value="<?php echo esc_attr(get_the_title()); ?>" class="note-title-field">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> 編集</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> 削除</span>
        <textarea readonly name="" id="" cols="30" rows="10" class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>

        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> 保存</span>
      </li>

      <?php
      }
      ?>
    </ul>
  </div>
<?php }

get_footer();
?>