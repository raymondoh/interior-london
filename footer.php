<?php
/**
 * The template for displaying the footer
 *
 * @package InteriorTheme
 */
?>
<?php
$phone_number = interior_get_option('site_phone_number');
$email_address = interior_get_option('site_email_address');
$address = interior_get_option('site_address');
$company_reg = interior_get_option('company_registration_number');
?>
<footer class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid md:grid-cols-3 gap-16">
            <!-- Brand -->
            <div>
                <h3 class="text-2xl font-light text-gray-900 mb-6 tracking-wide">
                    <?php echo esc_html(get_bloginfo('name')); ?></h3>
                <p class="text-gray-600 font-light leading-relaxed">
                    <?php echo esc_html(get_bloginfo('description')); ?>
                </p>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-light text-gray-900 mb-6 tracking-wide">Services</h4>
                <ul class="space-y-3 text-gray-600 font-light">
                    <li>Venetian Plaster</li>
                    <li>Heritage Restoration</li>
                    <li>Decorative Moldings</li>
                    <li>Lime Plastering</li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-lg font-light text-gray-900 mb-6 tracking-wide">Contact</h4>
                <div class="space-y-3 text-gray-600 font-light">
                    <?php if ($address) : ?>
                    <p><?php echo nl2br(esc_html($address)); ?></p>
                    <?php endif; ?>
                    <?php if ($phone_number) : ?>
                    <p>Phone: <?php echo esc_html($phone_number); ?></p>
                    <?php endif; ?>
                    <?php if ($email_address) : ?>
                    <p>Email: <a href="mailto:<?php echo esc_attr($email_address); ?>"
                            class="hover:underline"><?php echo esc_html($email_address); ?></a></p>
                    <?php endif; ?>
                    <?php if ($company_reg) : ?>
                    <p>Company No: <?php echo nl2br(esc_html($company_reg)); ?></p>
                    <?php endif; ?>
                    <p>Licensed &amp; Insured</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-16 pt-12 text-center">
            <p class="text-gray-500 font-light tracking-wide">
                &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>