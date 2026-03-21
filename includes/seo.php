<?php
/**
 * SEO Infrastructure
 *
 * Outputs meta description, canonical, Open Graph, Twitter Card, and JSON-LD
 * schema markup. All content is driven by Carbon Fields (site settings + per-page
 * overrides). No plugin required.
 *
 * Hooks:
 *   wp_head  @1  — meta tags (description, canonical, OG, Twitter Card)
 *   wp_head  @2  — JSON-LD schema (@graph)
 *   wp_robots   — noindex for search results
 */

// ── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Returns the resolved meta description for the current request.
 * Priority: per-post/page field → post excerpt → site default.
 */
function flavor_seo_get_description(): string {
    $site_default = (string) carbon_get_theme_option('site_seo_description');

    if (is_singular('post')) {
        $custom = (string) carbon_get_post_meta(get_the_ID(), 'post_seo_description');
        if ($custom) return $custom;
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_strip_all_tags($excerpt);
        return $site_default;
    }

    if (is_page()) {
        $custom = (string) carbon_get_post_meta(get_the_ID(), 'page_seo_description');
        if ($custom) return $custom;
        return $site_default;
    }

    return $site_default;
}

/**
 * Returns the resolved OG image URL for the current request.
 * Priority: per-post/page field → featured image (posts only) → site default.
 */
function flavor_seo_get_og_image_url(): string {
    if (is_singular('post')) {
        $custom_id = carbon_get_post_meta(get_the_ID(), 'post_seo_og_image');
        if ($custom_id) {
            $img = flavor_get_image_data($custom_id);
            if ($img) return $img['url'];
        }
        $thumb_id = get_post_thumbnail_id();
        if ($thumb_id) {
            $img = flavor_get_image_data($thumb_id);
            if ($img) return $img['url'];
        }
    }

    if (is_page()) {
        $custom_id = carbon_get_post_meta(get_the_ID(), 'page_seo_og_image');
        if ($custom_id) {
            $img = flavor_get_image_data($custom_id);
            if ($img) return $img['url'];
        }
    }

    // Site default
    $default_id = carbon_get_theme_option('site_seo_og_image');
    if ($default_id) {
        $img = flavor_get_image_data($default_id);
        if ($img) return $img['url'];
    }

    return '';
}

// ── Hook 1: Meta tags ─────────────────────────────────────────────────────────

add_action('wp_head', function () {

    $title       = wp_get_document_title();
    $description = flavor_seo_get_description();
    $og_image    = flavor_seo_get_og_image_url();
    $canonical   = get_permalink() ?: home_url(add_query_arg(null, null));
    $og_type     = is_singular('post') ? 'article' : 'website';
    $site_name   = get_bloginfo('name');

    $twitter_handle = trim((string) carbon_get_theme_option('site_twitter_handle'));
    $twitter_site   = $twitter_handle ? '@' . ltrim($twitter_handle, '@') : '';

    // Meta description
    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }

    // Canonical
    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    }

    // Open Graph
    echo '<meta property="og:type"        content="' . esc_attr($og_type) . '">'   . "\n";
    echo '<meta property="og:title"       content="' . esc_attr($title) . '">'      . "\n";
    echo '<meta property="og:url"         content="' . esc_url($canonical) . '">'   . "\n";
    echo '<meta property="og:site_name"   content="' . esc_attr($site_name) . '">'  . "\n";

    if ($description) {
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    }
    if ($og_image) {
        echo '<meta property="og:image"       content="' . esc_url($og_image) . '">' . "\n";
    }

    // Twitter Card
    echo '<meta name="twitter:card"        content="summary_large_image">'          . "\n";
    echo '<meta name="twitter:title"       content="' . esc_attr($title) . '">'     . "\n";

    if ($twitter_site) {
        echo '<meta name="twitter:site"    content="' . esc_attr($twitter_site) . '">' . "\n";
    }
    if ($description) {
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    }
    if ($og_image) {
        echo '<meta name="twitter:image"   content="' . esc_url($og_image) . '">'   . "\n";
    }

}, 1);

// ── Hook 2: JSON-LD schema ────────────────────────────────────────────────────

add_action('wp_head', function () {

    $site_url  = home_url('/');
    $site_name = get_bloginfo('name');

    // Site settings
    $org_name    = (string) carbon_get_theme_option('site_org_name')    ?: $site_name;
    $org_phone   = (string) carbon_get_theme_option('site_org_phone');
    $org_email   = (string) carbon_get_theme_option('site_org_email');
    $org_address = (string) carbon_get_theme_option('site_org_address');
    $linkedin    = (string) carbon_get_theme_option('site_social_linkedin');
    $twitter     = (string) carbon_get_theme_option('site_social_twitter');
    $instagram   = (string) carbon_get_theme_option('site_social_instagram');
    $facebook    = (string) carbon_get_theme_option('site_social_facebook');

    $logo_id  = carbon_get_theme_option('site_seo_og_image');
    $logo_img = $logo_id ? flavor_get_image_data($logo_id) : null;
    $logo_url = $logo_img ? $logo_img['url'] : '';

    $same_as = array_values(array_filter([$linkedin, $twitter, $instagram, $facebook]));

    // ── Organization ──────────────────────────────────────────────────────────
    $organization = array_filter([
        '@type'     => 'Organization',
        'name'      => $org_name,
        'url'       => $site_url,
        'logo'      => $logo_url ?: null,
        'telephone' => $org_phone ?: null,
        'email'     => $org_email ?: null,
        'address'   => $org_address ? [
            '@type'         => 'PostalAddress',
            'streetAddress' => $org_address,
        ] : null,
        'sameAs'    => $same_as ?: null,
    ]);

    // ── WebSite ───────────────────────────────────────────────────────────────
    $website = [
        '@type' => 'WebSite',
        'name'  => $site_name,
        'url'   => $site_url,
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => $site_url . '?s={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    $graph = [$organization, $website];

    // ── BlogPosting (single posts) ────────────────────────────────────────────
    if (is_singular('post')) {
        $post_id     = get_the_ID();
        $description = flavor_seo_get_description();
        $og_image    = flavor_seo_get_og_image_url();

        $blog_posting = array_filter([
            '@type'           => 'BlogPosting',
            'headline'        => get_the_title(),
            'description'     => $description ?: null,
            'image'           => $og_image ?: null,
            'author'          => [
                '@type' => 'Person',
                'name'  => get_the_author_meta('display_name', (int) get_post_field('post_author', $post_id)),
            ],
            'datePublished'   => get_the_date('c', $post_id),
            'dateModified'    => get_the_modified_date('c', $post_id),
            'publisher'       => [
                '@type' => 'Organization',
                'name'  => $org_name,
            ],
            'mainEntityOfPage' => get_permalink($post_id),
        ]);

        $graph[] = $blog_posting;
    }

    // ── BreadcrumbList (all non-home pages) ───────────────────────────────────
    if (!is_front_page() && (is_page() || is_singular('post'))) {
        $graph[] = [
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'name'     => 'Home',
                    'item'     => $site_url,
                ],
                [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => get_the_title(),
                    'item'     => get_permalink(),
                ],
            ],
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => $graph,
    ];

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";

}, 2);

// ── Hook 3: robots — noindex search results ───────────────────────────────────

add_filter('wp_robots', function (array $robots): array {
    if (is_search()) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
        unset($robots['follow']);
    }
    return $robots;
});
