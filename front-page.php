<?php
/**
 * Template Name: Front Page
 * Description: Home template for Interior Theme.
 */

get_header();
?>

<main id="primary" class="site-main" role="main" aria-label="<?php esc_attr_e( 'Homepage', 'interior' ); ?>">

    <?php
  // Hero
  get_template_part( 'template-parts/front-page/hero' );
  // Stats
  get_template_part( 'template-parts/front-page/stats' );

 

  // Featured Projects
  if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    echo "<!-- featured-projects:start -->";
  }
  get_template_part( 'template-parts/front-page/featured-projects' );

  if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    echo "<!-- featured-projects:end -->";
  }
    // Heritage
  get_template_part( 'template-parts/front-page/heritage' );

  

  // CTA
  get_template_part( 'template-parts/components/cta' );
  ?>

</main>

<?php
get_footer();