<?php
/**
 * Reusable Hero Component - Now with ACF!
 *
 * This component uses get_field() to pull content from custom fields.
 *
 * @package WordPress
 * @subpackage your-theme-name
 */

// Get the content from ACF and provide default fallback text
$heading      = get_field('hero_heading') ?: 'Hello There'; // The ?: is a shorthand way to set a default
$subheading   = get_field('hero_subheading') ?: 'Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi.';
$button_text  = get_field('hero_button_text') ?: 'Get Started';

?>

<div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center">
        <div class="max-w-md">

            <h1 class="text-5xl font-bold text-neutral-content"><?php echo esc_html($heading); ?></h1>

            <p class="py-6 text-neutral-content"><?php echo esc_html($subheading); ?></p>

            <?php if ($button_text) : ?>
            <button class="btn btn-primary rounded-full"><?php echo esc_html($button_text); ?></button>
            <?php endif; ?>

        </div>
    </div>
</div>