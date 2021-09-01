<?php
get_header();
?>
<div class="page-banner">
	<div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/img/library-hero.jpg') ?>);"></div>
	<div class="page-banner__content container t-center c-white">
		<h1 class="headline headline--large">教養大学</h1>
		<h2 class="headline headline--medium">社会に貢献する博識な人材へ</h2>
		<h3 class="headline headline--small">あなたにあった専攻を探しませんか？</h3>
		<a href="<?php echo site_url('/programs'); ?>" class="btn btn--large btn--blue">専攻を探す</a>
	</div>
</div>

<div class="full-width-split group">
	<div class="full-width-split__one">
		<div class="full-width-split__inner">
			<h2 class="headline headline--small-plus t-center">イベント予定</h2>

			<?php
			$posts_per_page = get_option('tkda_front_page_posts_per_page', 3);

			$query = new WP_Query(
				array(
					'post_type' => 'event',
					'posts_per_page' => $posts_per_page,
					'meta_key' => 'event_date',
					'orderby' => 'meta_value_num',
					'order' => 'ASC',
					'meta_query' => array(
						array(
							'key' => 'event_date',
							'compare' => '>=',
							'value' => date('Ymd'),
							'type' => 'numeric'
						)
					),
				)
			);
			?>

			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<?php get_template_part('template-parts/content', 'event'); ?>
			<?php endwhile;
			endif; ?>
			<?php wp_reset_postdata(); ?>

			<p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">イベント一覧</a></p>

		</div>
	</div>
	<div class="full-width-split__two">
		<div class="full-width-split__inner">
			<h2 class="headline headline--small-plus t-center">最新ブログ</h2>
			<?php
			$homepagePosts = new WP_Query(array(
				'posts_per_page' => $posts_per_page,
			));

			while ($homepagePosts->have_posts()) :
				$homepagePosts->the_post();
			?>
				<?php
				$year   = get_the_date('Y');
				$month  = get_the_date('m');
				?>
				<div class="event-summary">
					<a class="event-summary__date event-summary__date--beige t-center" href="<?php echo get_month_link($year, $month); ?>">
						<span class="event-summary__month"><?php the_time('M'); ?></span>
						<span class="event-summary__day"><?php the_time('d'); ?></span>
					</a>
					<div class="event-summary__content">
						<h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<p><?php
								if (has_excerpt()) {
									echo get_the_excerpt();
								} else {
									echo wp_trim_words(get_the_content(), 18);
								} ?><a href="<?php the_permalink(); ?>" class="nu gray">さらに見る</a>
						</p>
					</div>
				</div>
			<?php
			endwhile;
			wp_reset_postdata(); // custom query を呼ぶ前の名前空間に戻す。
			?>
			<p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">ブログ一覧</a></p>
		</div>
	</div>
</div>

<?php get_template_part('template-parts/slideshow'); ?>

<?php
get_footer();
?>