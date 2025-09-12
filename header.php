<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header container py-6">
        <a class="text-2xl font-semibold no-underline hover:underline" href="<?php echo esc_url( home_url('/') ); ?>">
            <?php bloginfo('name'); ?>
        </a>
    </header>