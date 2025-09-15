<?php error_log('navigation-mobile.php is being executed'); ?>
<!-- NAV MOBILE TEMPLATE START -->

<div id="mobile-shell"
    class="fixed inset-0 z-40 md:hidden opacity-0 invisible transition-opacity duration-500 ease-in-out pointer-events-none">
    <!-- Backdrop -->
    <div id="mobile-backdrop"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-500"></div>

    <!-- Drawer -->
    <aside id="mobile-nav"
        class="absolute top-0 right-0 h-full w-80 max-w-[85%] bg-white shadow-2xl translate-x-full transition-transform duration-500 ease-in-out z-50">
        <div class="flex flex-col h-full">
            <!-- Drawer header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h2 class="text-xl font-light tracking-wide text-gray-900">Menu</h2>
                <button id="mobile-close" class="p-2 text-gray-600 hover:text-gray-900 transition-colors duration-300"
                    aria-label="<?php esc_attr_e('Close navigation','interior'); ?>">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 6l12 12M18 6l-12 12" />
                    </svg>
                </button>
            </div>

            <!-- Links -->
            <nav class="flex-1 px-6 py-10">
                <?php
        // We'll add a class to <li> for stagger effect, and style active state via current-menu-item
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'fallback_cb'    => false,
          'items_wrap'     => '<ul class="%2$s space-y-6">%3$s</ul>',
          'walker'         => new class extends Walker_Nav_Menu {
            function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
              $is_active = in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes);
              $link_classes = 'block text-2xl font-light tracking-wide transition-colors duration-300 py-2 px-4 rounded-lg';
              $link_classes .= $is_active ? ' text-gray-900 bg-gray-100' : ' text-gray-700 hover:text-gray-900 hover:bg-gray-50';
              $output .= '<li class="transform transition-all duration-500 translate-x-8 opacity-0 mobile-stagger">'
                      . '<a class="'. esc_attr($link_classes) .'" href="'. esc_url($item->url) .'">'. esc_html($item->title) .'</a>'
                      . '</li>';
            }
          }
        ]);
        ?>
            </nav>

            <!-- Drawer CTA -->
            <div class="p-6 border-t border-gray-100">
                <a href="tel:+" class="btn-primary btn-large btn-anim w-full flex items-center justify-center group">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.77 19.77 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.77 19.77 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.12.88.33 1.73.62 2.54a2 2 0 0 1-.45 2.11L8 9a16 16 0 0 0 7 7l.63-1.17a2 2 0 0 1 2.11-.45c.81.29 1.66.5 2.54.62A2 2 0 0 1 22 16.92z" />
                    </svg>
                    Call Now
                </a>

            </div>
        </div>
    </aside>
</div>
<!-- NAV MOBILE TEMPLATE END -->
<?php error_log('navigation-mobile.php finished rendering'); ?>