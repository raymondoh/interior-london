<?php
/**
 * Reusable Site Footer Component
 *
 * @package WP_Boilerplate
 */
?>

<footer class="footer p-10 bg-neutral text-neutral-content">
    <div class="container mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <nav>
                <?php if (is_active_sidebar('footer-1')) : ?>
                <?php dynamic_sidebar('footer-1'); ?>
                <?php endif; ?>
            </nav>
            <nav>
                <?php if (is_active_sidebar('footer-2')) : ?>
                <?php dynamic_sidebar('footer-2'); ?>
                <?php endif; ?>
            </nav>
            <nav>
                <?php if (is_active_sidebar('footer-3')) : ?>
                <?php dynamic_sidebar('footer-3'); ?>
                <?php endif; ?>
            </nav>
            <nav>
                <?php if (is_active_sidebar('footer-4')) : ?>
                <?php dynamic_sidebar('footer-4'); ?>
                <?php endif; ?>
            </nav>
        </div>

        <div class="mt-10 pt-8 border-t border-base-content/10 flex flex-col md:flex-row justify-between items-center">
            <aside class="items-center grid-flow-col">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
            </aside>
            <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
                <a href="#" class="link link-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                        </path>
                    </svg>
                </a>
                <a href="#" class="link link-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616v.064c0 2.295 1.613 4.212 3.748 4.653-.76.205-1.562.262-2.385.087.62 1.921 2.413 3.313 4.543 3.352-1.787 1.4-4.043 2.238-6.493 2.238-1.12 0-2.22-.066-3.3-0.19C2.916 21.433 5.483 22.5 8.242 22.5c8.355 0 12.92-6.924 12.92-12.928 0-.197-.004-.393-.012-.588.89-.643 1.657-1.448 2.268-2.358z">
                        </path>
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</footer>