<?php
/**
 * Template part for displaying post summaries on the blog page.
 *
 * @package WP_Boilerplate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card bg-base-100 shadow-xl overflow-hidden'); ?>>
    <?php if (has_post_thumbnail()) : ?>
    <figure class="aspect-video">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>"
                class="w-full h-full object-cover">
        </a>
    </figure>
    <?php endif; ?>

    <div class="card-body">
        <header class="entry-header mb-4">
            <?php the_title(sprintf('<h2 class="card-title text-2xl font-bold"><a href="%s" rel="bookmark" class="link link-hover">', esc_url(get_permalink())), '</a></h2>'); ?>
            <div class="text-sm text-base-content/60 mt-1">
                <span><?php echo get_the_date(); ?></span>
            </div>
        </header>

        <div class="entry-summary prose">
            <?php the_excerpt(); ?>
        </div>

        <div class="card-actions justify-start mt-4">
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Continue Reading</a>
        </div>
    </div>
</article>