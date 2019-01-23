<?php
/**
 * Template Name: 100% Width
 * A full-width template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header();
$style = 'style= "margin: 0% 0;"';
if ( is_user_logged_in() ) {
	$user = wp_get_current_user();
	if ((in_array( 'RRHH', (array) $user->roles ))||(in_array( 'customer', (array) $user->roles ))){
	$style = 'style= "margin: 5% 0;"';
}}?>
<section <?php echo $style; ?> id="content" class="full-width">
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo fusion_render_rich_snippets_for_pages(); // WPCS: XSS ok. ?>
			<?php avada_featured_images_for_pages(); ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>
			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( Avada()->settings->get( 'comments_pages' ) ) : ?>
					<?php wp_reset_postdata(); ?>
					<?php comments_template(); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</section>
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
