<?php
/**
 * Template Name: Contact
 * Description: Contact page with hero, form, info, and CTA.
 */

get_header();

// Theme Settings fallbacks
$phone   = interior_get_option('site_phone_number') ?: '(555) 123-4567';
$email   = interior_get_option('site_email_address') ?: 'info@interiorlondon.com';
$address = interior_get_option('site_address') ?: "96 Woodgrange Road\nLondon E7 0EW";
$business_hours = interior_get_option('business_hours') ?: "Mon - Fri: 8am - 6pm\nSat: 9am - 4pm\nSun: Closed";

// Flash messages
$sent     = isset($_GET['sent']) ? (int) $_GET['sent'] : 0;
$error    = isset($_GET['error']) ? sanitize_text_field($_GET['error']) : '';
$success_msg = 'Thanks! Your message has been sent.';
$error_msg   = $error ? $error : 'Sorry, something went wrong. Please try again.';
?>

<main id="primary" class="site-main" role="main">
    <!-- Hero -->
    <section class="section bg-white">
        <div class="container text-center">
            <span class="badge badge-muted mb-8 font-light tracking-wide">Get In Touch</span>
            <h1 class="heading-xl text-gray-900 tracking-tight">
                Start Your <span class="font-normal">Project</span>
            </h1>
            <p class="body-lg text-gray-600 mt-6 max-w-3xl mx-auto">
                Ready to transform your space with exceptional plastering? Contact our master craftsmen for a
                consultation and discover how we can bring your vision to life.
            </p>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="grid lg:grid-cols-2 gap-20">
                <!-- Form card -->
                <div class="bg-white p-8 sm:p-12 shadow-sm border border-black/5 rounded-2xl">
                    <h2 class="heading-lg text-gray-900 mb-8 tracking-tight">Request a Consultation</h2>

                    <?php if ($sent === 1): ?>
                    <div class="mb-8 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-900">
                        <?php echo esc_html($success_msg); ?>
                    </div>
                    <?php elseif ($sent === -1): ?>
                    <div class="mb-8 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                        <?php echo esc_html($error_msg); ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-8"
                        novalidate>
                        <input type="hidden" name="action" value="interior_contact">
                        <?php wp_nonce_field('interior_contact_nonce', 'interior_contact_nonce_field'); ?>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-light text-gray-700 mb-3 tracking-wide">Full
                                    Name *</label>
                                <input id="name" name="name" type="text" required autocomplete="name"
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-gray-400 focus:ring-0 font-light transition-colors duration-300 rounded-md"
                                    placeholder="Your full name"
                                    value="<?php echo isset($_GET['name']) ? esc_attr($_GET['name']) : ''; ?>">
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-sm font-light text-gray-700 mb-3 tracking-wide">Email Address
                                    *</label>
                                <input id="email" name="email" type="email" required autocomplete="email"
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-gray-400 focus:ring-0 font-light transition-colors duration-300 rounded-md"
                                    placeholder="your@email.com"
                                    value="<?php echo isset($_GET['email']) ? esc_attr($_GET['email']) : ''; ?>">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone"
                                    class="block text-sm font-light text-gray-700 mb-3 tracking-wide">Phone
                                    Number</label>
                                <input id="phone" name="phone" type="tel" autocomplete="tel"
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-gray-400 focus:ring-0 font-light transition-colors duration-300 rounded-md"
                                    placeholder="(555) 123-4567"
                                    value="<?php echo isset($_GET['phone']) ? esc_attr($_GET['phone']) : ''; ?>">
                            </div>
                            <div>
                                <label for="projectType"
                                    class="block text-sm font-light text-gray-700 mb-3 tracking-wide">Project
                                    Type</label>
                                <select id="projectType" name="projectType"
                                    class="w-full px-4 py-3 border border-gray-200 focus:border-gray-400 focus:ring-0 font-light transition-colors duration-300 bg-white rounded-md">
                                    <?php
                    $selected = isset($_GET['projectType']) ? sanitize_text_field($_GET['projectType']) : '';
                    $options = [
                      '' => 'Select project type',
                      'venetian-plaster'    => 'Venetian Plaster',
                      'heritage-restoration'=> 'Heritage Restoration',
                      'decorative-moldings' => 'Decorative Moldings',
                      'lime-plastering'     => 'Lime Plastering',
                      'consultation'        => 'Consultation Only',
                      'other'               => 'Other',
                    ];
                    foreach ($options as $val => $label) {
                      printf(
                        '<option value="%s"%s>%s</option>',
                        esc_attr($val),
                        selected($selected, $val, false),
                        esc_html($label)
                      );
                    }
                  ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="message"
                                class="block text-sm font-light text-gray-700 mb-3 tracking-wide">Project Details
                                *</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 border border-gray-200 focus:border-gray-400 focus:ring-0 font-light transition-colors duration-300 rounded-md resize-none"
                                placeholder="Tell us about your project, timeline, and any specific requirements..."><?php echo isset($_GET['message']) ? esc_textarea($_GET['message']) : ''; ?></textarea>
                        </div>

                        <button type="submit"
                            class="btn-primary btn-anim w-full inline-flex items-center justify-center">
                            Send Message
                            <span class="ml-3" aria-hidden="true">➝</span>
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-12">
                    <div>
                        <h2 class="heading-lg text-gray-900 mb-8 tracking-tight">Get In Touch</h2>
                        <p class="body-lg text-gray-600 font-light leading-relaxed mb-12">
                            We're here to help bring your vision to life. Reach out to discuss your project, schedule a
                            consultation, or get answers to your questions.
                        </p>
                    </div>

                    <div class="space-y-8">
                        <!-- Uniform Icon Item -->
                        <div class="flex items-start gap-4">
                            <div class="rounded-md bg-gray-100 border border-black/5 p-3 mt-1">
                                <span class="sr-only">Phone</span>
                                <!-- phone icon -->
                                <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2A19.77 19.77 0 0 1 11.19 19a19.5 19.5 0 0 1-6-6A19.77 19.77 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.12.88.33 1.73.62 2.54a2 2 0 0 1-.45 2.11L8 9a16 16 0 0 0 7 7l.63-1.17a2 2 0 0 1 2.11-.45c.81.29 1.66.5 2.54.62A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-light text-gray-900 mb-2">Phone</h3>
                                <p class="text-gray-600 font-light">
                                    <a href="tel:<?php echo esc_attr(preg_replace('~\D+~','',$phone)); ?>"
                                        class="underline decoration-transparent hover:decoration-gray-400">
                                        <?php echo esc_html($phone); ?>
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 font-light mt-1">Available 8 AM – 6 PM, Monday –
                                    Saturday</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="rounded-md bg-gray-100 border border-black/5 p-3 mt-1">
                                <span class="sr-only">Email</span>
                                <!-- mail icon -->
                                <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 4h16v16H4z" />
                                    <path d="m22 6-10 7L2 6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-light text-gray-900 mb-2">Email</h3>
                                <p class="text-gray-600 font-light">
                                    <a href="mailto:<?php echo antispambot($email); ?>"
                                        class="underline decoration-transparent hover:decoration-gray-400">
                                        <?php echo esc_html($email); ?>
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 font-light mt-1">We respond within 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="rounded-md bg-gray-100 border border-black/5 p-3 mt-1">
                                <span class="sr-only">Service Area</span>
                                <!-- pin icon -->
                                <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 22s8-4.5 8-12a8 8 0 1 0-16 0c0 7.5 8 12 8 12z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-light text-gray-900 mb-2">Service Area</h3>
                                <p class="text-gray-600 font-light">Greater London &amp; Home Counties</p>
                                <p class="text-sm text-gray-500 font-light mt-1">Covering a 50-mile radius from Central
                                    London</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="rounded-md bg-gray-100 border border-black/5 p-3 mt-1">
                                <span class="sr-only">Business Hours</span>
                                <!-- clock icon -->
                                <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 3" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-light text-gray-900 mb-2">Business Hours</h3>
                                <div class="text-gray-600 font-light space-y-1">
                                    <?php if ($business_hours) : ?>
                                    <?php echo nl2br(esc_html($business_hours)); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What to Expect -->
                    <div class="bg-gray-50 p-8 border border-black/5 rounded-2xl">
                        <h3 class="heading-md text-gray-900 mb-6">What to Expect</h3>
                        <ul class="space-y-3 text-gray-600 font-light">
                            <li>• Initial consultation within 48 hours</li>
                            <li>• Detailed project assessment and quote</li>
                            <li>• Material samples and finish options</li>
                            <li>• Timeline and project planning</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section bg-white">
        <div class="container text-center">
            <h2 class="heading-lg text-gray-900 mb-6 tracking-tight">Emergency Repairs &amp; Urgent Projects</h2>
            <p class="body-lg text-gray-600 mb-12 max-w-3xl mx-auto">
                Need immediate assistance? We offer emergency repair services for heritage properties and urgent project
                completion for time-sensitive renovations.
            </p>
            <a href="tel:<?php echo esc_attr(preg_replace('~\D+~','',$phone)); ?>"
                class="btn-primary btn-anim inline-flex items-center justify-center">
                <span class="mr-3"><svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2A19.77 19.77 0 0 1 11.19 19a19.5 19.5 0 0 1-6-6A19.77 19.77 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.12.88.33 1.73.62 2.54a2 2 0 0 1-.45 2.11L8 9a16 16 0 0 0 7 7l.63-1.17a2 2 0 0 1 2.11-.45c.81.29 1.66.5 2.54.62A2 2 0 0 1 22 16.92z" />
                    </svg></span>
                Emergency Hotline: <?php echo esc_html($phone); ?>
            </a>
        </div>



    </section>
</main>

<?php get_footer(); ?>