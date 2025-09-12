<?php
/**
 * Reusable Navbar Component
 *
 * Uses wp_nav_menu() for the links and Alpine.js for interactivity.
 *
 * @package WordPress
 * @subpackage your-theme-name
 */
?>

<div x-data="{ open: false, dropdownOpen: false }" class="bg-base-100 shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">

            <div class="text-xl font-bold">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="text-base-content no-underline hover:opacity-80">My Site</a>
            </div>

            <nav class="hidden md:flex items-center space-x-4">
                <?php
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'walker'         => new Your_Theme_Name_Walker_Nav_Menu(),
        ));
        ?>
            </nav>

            <div class="md:hidden">
                <button @click="open = !open" class="text-base-content">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="md:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <?php
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
          'container'      => false,
          'menu_class'     => 'mobile-menu-list',
        ));
        ?>
        </div>
    </div>
</div>