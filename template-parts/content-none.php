<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package WP_Boilerplate
 */
?>

<section class="no-results not-found bg-white rounded-lg shadow-md p-6">
    <header class="page-header mb-4">
        <h1 class="page-title text-2xl font-bold"><?php esc_html_e('Nothing Found', 'wp-boilerplate'); ?></h1>
    </header>

    <div class="page-content prose">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wp-boilerplate'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );
        elseif (is_search()) :
            ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wp-boilerplate'); ?></p>
            <?php
            get_search_form();
        else :
            ?>
            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp-boilerplate'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div>
</section>
