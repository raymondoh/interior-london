<?php get_header(); ?>

<main id="main" class="site-main container section" role="main">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article <?php post_class('prose'); ?>>
        <h1 class="mb-6"><?php the_title(); ?></h1>
        <div class="entry-content"><?php the_content(); ?></div>
    </article>
    <?php endwhile; else : ?>
    <p><?php esc_html_e('No posts found.', 'art-portfolio-theme'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>