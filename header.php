<?php
/**
 * Header
 * @package Interior_Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('min-h-screen bg-white'); ?>>
    <a class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:top-2 focus:left-2 focus:p-3 focus:bg-white focus:shadow-md"
        href="#primary">
        <?php esc_html_e('Skip to content', 'your-theme-text-domain'); ?>
    </a>
    <?php wp_body_open(); ?>

    <!-- <header class="bg-white border-b border-gray-100 relative z-50 sticky top-0"> -->

    <header id="site-header" class="sticky top-0 z-50
         bg-white border-b border-gray-100 shadow-sm">


        <!-- Tailwind safelist (prevents purge of classes toggled only via JS) -->
        <div class="hidden">
            <span
                class="translate-x-0 translate-x-full opacity-100 opacity-0 visible invisible pointer-events-auto pointer-events-none"></span>
        </div>


        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex justify-between items-center h-20">
                <!-- Brand -->
                <div class="flex items-center">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="cursor-pointer">
                        <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
                        <h1 class="text-2xl font-light tracking-wide text-gray-900"><?php bloginfo('name'); ?></h1>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-12">
                    <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'fallback_cb'    => false,
          'items_wrap'     => '<ul id="%1$s" class="%2$s flex items-center space-x-8">%3$s</ul>',
          'link_before'    => '<span class="font-light tracking-wide transition-colors duration-300 nav-link">',
          'link_after'     => '</span>',
        ]);
        ?>
                </nav>

                <!-- Desktop CTA -->
                <?php
$phone_number = interior_get_option('site_phone_number');
if ($phone_number) :
?>
                <a href="<?php echo esc_url('tel:' . preg_replace('/\s+/', '', $phone_number)); ?>"
                    class="hidden md:flex btn-primary btn-compact btn-anim items-center group">
                    <svg class="w-4 h-4 mr-3 group-hover:rotate-12 transition-transform duration-300"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.77 19.77 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.77 19.77 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.12.88.33 1.73.62 2.54a2 2 0 0 1-.45 2.11L8 9a16 16 0 0 0 7 7l.63-1.17a2 2 0 0 1 2.11-.45c.81.29 1.66.5 2.54.62A2 2 0 0 1 22 16.92z" />
                    </svg>
                    Call Now
                </a>

                <?php endif; ?>

                <!-- Mobile Menu Button -->
                <button id="mobile-nav-toggle"
                    class="md:hidden p-2 text-gray-600 hover:text-gray-900 transition-colors duration-300 relative z-50"
                    aria-controls="mobile-nav" aria-expanded="false"
                    aria-label="<?php esc_attr_e('Toggle navigation','interior'); ?>">
                    <!-- menu -->
                    <svg id="icon-open" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <!-- close -->
                    <svg id="icon-close" class="w-6 h-6 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 6l12 12M18 6l-12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- BEGIN mobile nav include -->
    <?php 
  error_log('Loading navigation-mobile.php from header.php'); 
  get_template_part('template-parts/components/navigation-mobile'); 
?>
    <!-- END mobile nav include -->