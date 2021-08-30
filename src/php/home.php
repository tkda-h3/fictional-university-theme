<?php
get_header();
?>

<?php page_banner(array(
	'title' => 'ブログ',
	'subtitle' => '本校の最新のニュースをお届けします',
)) ?>

<div class="container container--narrow page-section">
	<?php
	while (have_posts()) :
		the_post(); ?>

		<div class="post-item">
			<h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<div class="metabox">
				<p><?php echo get_the_category_list(', '); ?></p>
			</div>
			<div class="generic-content">
				<?php the_excerpt(); ?>
				<p><a href="<?php the_permalink(); ?>">続きを読む &raquo;</a></p>
			</div>
		</div>

	<?php
	endwhile;
	echo paginate_links();
	?>
</div>
<?php
get_footer();
?>