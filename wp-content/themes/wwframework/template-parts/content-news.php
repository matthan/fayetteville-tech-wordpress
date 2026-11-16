<?php
/**
 * The template for displaying the news teasers.
 *
 * @package WordPress
 * @subpackage O3_Framework
 * @since O3_Framework 2.0
 */

global $options;
global $meta;
?>

<div class="news-item">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			<span class="post-date"><?php the_time('n/j/y'); ?></span>
		</div>
		<div class="col-sm-9 col-md-10">
			<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php if( is_single() ) : ?>
				<span class="post-excerpt"><?php the_content(); ?></span>
				<?php o3_share(); ?>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>"><span class="post-excerpt"><?php the_excerpt(); ?></span></a>
<!-- 				<div class="btn-div"><a href="<?php the_permalink(); ?>">Read More</a></div> -->
			<?php endif; ?>
		</div>
	</div>
</div>