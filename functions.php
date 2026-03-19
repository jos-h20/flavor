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

// --- Performance Cleanup ---

// Remove emoji scripts and styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove generator meta tag
remove_action('wp_head', 'wp_generator');

// --- Carbon Fields Registration ---

require_once get_template_directory() . '/includes/fields.php';

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
