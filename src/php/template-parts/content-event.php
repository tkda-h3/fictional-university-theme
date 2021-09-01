<?php
$event_date = new DateTime(get_field('event_date'));
$year = $event_date->format('Y');
$month = $event_date->format('m');
?>
<div class="event-summary">
  <a class="event-summary__date t-center" href="<?php echo site_url("/{$year}/{$month}/?post_type=event");  ?>">
    <span class="event-summary__month">
      <?php echo $event_date->format('n'); ?>月
    </span>
    <span class="event-summary__day">
      <?php echo $event_date->format('j'); ?>
    </span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">さらに見る</a></p>
  </div>
</div>