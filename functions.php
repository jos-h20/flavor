<?php
/**
 * Flavor Theme Functions
 */

// --- Carbon Fields Bootloader ---
$flavor_autoloader = get_template_directory() . '/vendor/autoload.php';

if (file_exists($flavor_autoloader)) {
    require_once $flavor_autoloader;
    
    add_action('after_setup_theme', function () {
        \Carbon_Fields\Carbon_Fields::boot();
    });
} else {
    // Optional: Log an error or show a notice if vendor is missing
    error_log('Flavor Theme Error: Composer vendor folder is missing.');
}

// --- Theme Setup ---

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'flavor'),
        'footer'  => __('Footer Menu', 'flavor'),
    ]);
});

// --- Enqueue Styles ---

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('flavor-style', get_stylesheet_uri(), [], '1.0.0');
});

// Inline critical CSS and async-load the full stylesheet
add_filter('style_loader_tag', function ($html, $handle) {
    if ($handle !== 'flavor-style' || is_admin()) {
        return $html;
    }

    // Extract the href from the existing tag
    preg_match('/href=[\'"]([^\'"]+)[\'"]/', $html, $matches);
    if (empty($matches[1])) return $html;
    $href = $matches[1];

    // Read and inline critical CSS (tokens, reset, base typography)
    $critical_file = get_template_directory() . '/assets/critical.css';
    if (file_exists($critical_file)) {
        $critical = file_get_contents($critical_file);
        $inline = '<style id="critical-css">' . $critical . '</style>' . "\n";
    } else {
        $inline = '';
    }

    // Load full stylesheet asynchronously
    $async = '<link rel="stylesheet" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'">' . "\n";
    $async .= '<noscript><link rel="stylesheet" href="' . esc_url($href) . '"></noscript>' . "\n";

    return $inline . $async;
}, 10, 2);

// --- Contact Form 7: Load assets on contact page only ---

add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_action('wp_enqueue_scripts', function () {
    if (is_page_template('templates/page-contact.php')) {
        wpcf7_enqueue_scripts();
        wpcf7_enqueue_styles();
    }
});

// Scope Cloudflare Turnstile to contact page only (runs after Turnstile's priority 10 hook)
add_action('wp_enqueue_scripts', function () {
    if (!is_page_template('templates/page-contact.php')) {
        wp_dequeue_script('cloudflare-turnstile');
    }
}, 11);

// Exclude Cloudflare Turnstile from LiteSpeed JS optimization
add_filter('script_loader_tag', function ($tag, $handle) {
    if ($handle === 'cloudflare-turnstile') {
        $tag = str_replace('<script ', '<script data-no-optimize="1" ', $tag);
    }
    return $tag;
}, 10, 2);

// --- Security Hardening ---

// Disable XML-RPC entirely — primary WordPress attack vector for DDoS and brute-force
add_filter('xmlrpc_enabled', '__return_false');

// Remove XML-RPC discovery link from <head>
remove_action('wp_head', 'rsd_link');

// --- Performance Cleanup ---

// Remove emoji scripts and styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove generator meta tag
remove_action('wp_head', 'wp_generator');

// Dequeue block library CSS on pages that don't use blocks
add_action('wp_enqueue_scripts', function () {
    if (is_page_template() && !is_page_template('templates/page-doc.php')) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
    }
}, 100);

// --- Carbon Fields Registration ---

require_once get_template_directory() . '/includes/fields.php';

// --- SEO ---

require_once get_template_directory() . '/includes/seo.php';

// --- Sitemap: strip users, taxonomies, and low-value pages ---

// Remove users and taxonomies sub-sitemaps entirely
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    if (in_array($name, ['users', 'taxonomies'], true)) {
        return false;
    }
    return $provider;
}, 10, 2);

// Exclude legal, support, and blog landing pages from the pages sitemap
add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
    if ($post_type === 'page') {
        $args['post__not_in'] = [
            13361, // Kanso SyncFit Support
            13320, // Kanso SyncFit Terms of Service
            13315, // Kanso SyncFit Privacy Policy
            13559, // Blog (archive handled by posts sitemap)
        ];
    }
    return $args;
}, 10, 2);

// --- Redirects: bare post slugs → correct permalink ---
// If the permalink structure uses a /blog/ base and someone hits /{slug}/
// directly, WordPress returns a 404. Detect it and 301 to the real URL.

add_action('template_redirect', function () {
    if (!is_404()) return;

    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Only handle single-segment paths (e.g. "my-post-slug")
    if (empty($path) || strpos($path, '/') !== false) return;

    $post = get_page_by_path($path, OBJECT, 'post');
    if ($post && $post->post_status === 'publish') {
        wp_redirect(get_permalink($post->ID), 301);
        exit;
    }
});

// --- Admin: Available Sections Notice ---

add_action('admin_notices', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }

    $sections_dir = get_template_directory() . '/templates/sections/';
    if (!is_dir($sections_dir)) {
        return;
    }

    $files = glob($sections_dir . '*.php');
    if (empty($files)) {
        return;
    }

    $names = array_map(function ($file) {
        return basename($file, '.php');
    }, $files);

    sort($names);

    echo '<div class="notice notice-info is-dismissible">';
    echo '<p><strong>Available sections:</strong> ' . esc_html(implode(', ', $names)) . '</p>';
    echo '</div>';
});

// --- Helpers ---

/**
 * Returns the full URL to a file in the theme's assets/ directory.
 */
function flavor_section_asset($filename) {
    return get_template_directory_uri() . '/assets/' . $filename;
}

/**
 * Converts an attachment ID to an image data array.
 * Returns ['url', 'alt', 'width', 'height'] or null if invalid.
 */
function flavor_get_image_data($attachment_id) {
    if (!$attachment_id) {
        return null;
    }

    $src = wp_get_attachment_image_src($attachment_id, 'full');
    if (!$src) {
        return null;
    }

    return [
        'url'    => $src[0],
        'alt'    => get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: '',
        'width'  => $src[1],
        'height' => $src[2],
    ];
}

// --- Tracking & Code Injection ---

add_action('wp_head', function () {
    // ── Google Tag Manager ────────────────────────────────
    $gtm_id = trim(carbon_get_theme_option('gtm_id'));
    if ($gtm_id) : ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= esc_js($gtm_id) ?>');</script>
<!-- End Google Tag Manager -->
<?php endif;

    // ── Global head code ──────────────────────────────────
    $head_code = carbon_get_theme_option('global_head_code');
    if ($head_code) {
        echo $head_code . "\n"; // intentionally unescaped — admin-only field
    }
}, 1); // priority 1 = before other wp_head output so GTM loads first

// --- Featured Image Preload ---

add_action('wp_head', function () {
    if (!is_singular('post')) return;
    $thumb_id = get_post_thumbnail_id();
    if (!$thumb_id) return;
    $image = flavor_get_image_data($thumb_id);
    if (!$image || empty($image['url'])) return;
    echo '<link rel="preload" as="image" href="' . esc_url($image['url']) . '">' . "\n";
}, 1);

add_action('wp_body_open', function () {
    $gtm_id = trim(carbon_get_theme_option('gtm_id'));
    if (!$gtm_id) return;
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= esc_attr($gtm_id) ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
});

// Include the Posts page (blog index) in the XML sitemap — WordPress excludes it by default.
add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
    if ($post_type === 'page') {
        $page_for_posts = (int) get_option('page_for_posts');
        if ($page_for_posts && isset($args['post__not_in'])) {
            $args['post__not_in'] = array_diff($args['post__not_in'], [$page_for_posts]);
        }
    }
    return $args;
}, 10, 2);

add_action('wp_footer', function () {
    $footer_code = carbon_get_theme_option('global_footer_code');
    if ($footer_code) {
        echo $footer_code . "\n"; // intentionally unescaped — admin-only field
    }
}, 999); // priority 999 = after all other footer output
