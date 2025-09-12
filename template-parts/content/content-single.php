<?php
/**
 * Template part for displaying a single post's content.
 *
 * @package WP_Boilerplate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-base-100 shadow-lg rounded-lg overflow-hidden'); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
    <figure class="aspect-video">
        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
            class="w-full h-full object-cover">
    </figure>
    <?php endif; ?>

    <div class="p-6 md:p-8">
        <header class="entry-header mb-6">
            <?php the_title( '<h1 class="entry-title text-4xl font-bold">', '</h1>' ); ?>

            <div class="entry-meta text-sm text-base-content/60 mt-2">
                <span>Posted on <?php echo get_the_date(); ?></span>
                <span>by <?php the_author_posts_link(); ?></span>
            </div>
        </header>

        <div class="entry-content prose lg:prose-xl max-w-none">
            <?php
            the_content();

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-boilerplate' ),
                'after'  => '</div>',
            ) );
            ?>
        </div>
    </div>
</article>