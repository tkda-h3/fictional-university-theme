<?php

class TkdaOption
{
  protected $section_name = 'tkda_first_section';
  protected $slug = 'tkda-setting';
  protected $settings_group_name = 'tkda_first_group';

  function __construct()
  {
    add_action('admin_menu', array($this, 'adminPage'));
    add_action('admin_init', array($this, 'settings'));
    // add_filter('the_content', array($this, 'ifWrap'));
  }

  function adminPage()
  {
    add_options_page(
      'tkda-h3テーマのオプション', // title
      'Tkda setting', // メニューのアンカーテキスト
      'manage_options',  // 権限(capability)
      $this->slug, // slug
      array($this, 'admin_html') // 中身
    );
  }

  function admin_html(){
    ?>
    <div class="wrap">
			<h1>Word Count Settings</h1>
			<form action="options.php" method="POST"><!-- options.phpにPOSTするのは規定 -->
				<?php
				settings_fields($this->settings_group_name); // group名。セキュリティやロールなどをよしなにやってくれる
				do_settings_sections($this->slug); // slug name
				submit_button();
				?>
			</form>
		</div>
    <?php 
  }

  function settings()
  {
    add_settings_section(
      $this->section_name, // section name
      null, // 挿入したい subtitle
      null, // 挿入したい content
      $this->slug // page slug name
    );

    add_settings_field(
      'tkda_front_page_posts_per_page', // option name
      'フロントページに表示するイベントとブログの件数', // display name
      array($this, 'input_number'), // function outputting html
      $this->slug, // page slug
      $this->section_name, // section
      array(
        'name' => 'tkda_front_page_posts_per_page',
        'attrs' => array(
          'min' => 1,
          'max' => 10,
        )
      ),
    );
    register_setting(
      $this->settings_group_name, // group belonging to
      'tkda_front_page_posts_per_page', // option name
      array(
        'sanitize_callback' => function($input){ 
          return $this->sanitize_input_number($input, array(
            'name' => 'tkda_front_page_posts_per_page',
            'min' => 1,
            'max' => 10,
          ));
        },
        'default' => 1,
      )
    );
  }

  function input_number($args)
  {
    $attr_str = '';
    foreach((isset($args['attrs']) ? $args['attrs'] : array()) as $k => $v){
      $attr_str .= $k . '="' . $v . '" ';
    }
?>
    <input type="number" name="<?php echo $args['name'] ?>" value="<?php echo get_option($args['name'], 1); ?>" <?php echo $attr_str; ?>>
<?php
  }

  function sanitize_input_number($input, $args){
    $min = isset($args['min']) ? $args['min'] : 1;
    $max = isset($args['max']) ? $args['max'] : 10;
    if(isset($args['min']) and $input < $args['min']){
      add_settings_error($args['name'], $args['name'] . '_error', '1 - 10で指定してください');
      return get_option($args['name']);
    }
    if(isset($args['max']) and $input > $args['max']){
      add_settings_error($args['name'], $args['name'] . '_error', '1 - 10で指定してください');
      return get_option($args['name']);
    }
    return $input;
  }
}

$tkda_option = new TkdaOption();

?>