<?php
/**
 * Carbon Fields Registration
 *
 * Field groups are scoped per page template. Each Container maps to one section.
 * Field names follow the pattern: {page}_{section}_{field}
 *
 * --- How to Add Fields for a New Page/Section ---
 *
 * Container::make('post_meta', 'Page — Section')
 *     ->where('post_template', '=', 'templates/page-{name}.php')
 *     ->add_fields([
 *         Field::make('text', '{page}_{section}_{field}', 'Label'),
 *     ]);
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    // ── Home: Hero ────────────────────────────────────────────

    Container::make('post_meta', 'Home — Hero')
        ->where('post_template', '=', 'templates/page-home.php')
        ->add_fields([
            Field::make('text', 'home_hero_tagline_1', 'Tagline — Item 1')
                ->set_default_value('iOS Apps'),
            Field::make('text', 'home_hero_tagline_2', 'Tagline — Item 2')
                ->set_default_value('AI-Powered'),
            Field::make('text', 'home_hero_tagline_3', 'Tagline — Item 3')
                ->set_default_value('Contract Work'),
            Field::make('rich_text', 'home_hero_headline', 'Headline')
                ->set_help_text('Main headline. Use <em> tags for italic accent colour. Default: "Software that does exactly what you need — <em>nothing more.</em>"'),
            Field::make('textarea', 'home_hero_sub', 'Subtext')
                ->set_rows(3)
                ->set_help_text('Supporting paragraph below the headline.'),
            Field::make('text', 'home_hero_cta_primary_url', 'Primary CTA — URL'),
            Field::make('text', 'home_hero_cta_primary_title', 'Primary CTA — Label')
                ->set_default_value('Our Apps'),
            Field::make('text', 'home_hero_cta_ghost_url', 'Ghost CTA — URL'),
            Field::make('text', 'home_hero_cta_ghost_title', 'Ghost CTA — Label')
                ->set_default_value('Get In Touch'),
        ]);

    // ── About: Hero ───────────────────────────────────────────

    Container::make('post_meta', 'About — Hero')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_hero_heading', 'Heading')
                ->set_help_text('Main headline. Use <em> tags for italic accent. Supports <br> for line breaks.'),
            Field::make('textarea', 'about_hero_subheading', 'Subheading')
                ->set_rows(3)
                ->set_help_text('1–2 sentence personal statement below the headline.'),
        ]);

    // ── About: Values ─────────────────────────────────────────

    Container::make('post_meta', 'About — Values')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_values_heading', 'Heading'),
            Field::make('complex', 'about_values_items', 'Value Cards')
                ->add_fields([
                    Field::make('text',     'title',       'Title'),
                    Field::make('textarea', 'description', 'Description')
                        ->set_rows(2),
                ]),
        ]);

    // ── About: Approach ───────────────────────────────────────

    Container::make('post_meta', 'About — Approach')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_approach_heading', 'Heading'),
            Field::make('complex', 'about_approach_steps', 'Process Steps')
                ->add_fields([
                    Field::make('text',     'title',       'Step Title'),
                    Field::make('textarea', 'description', 'Step Description')
                        ->set_rows(3),
                ]),
        ]);

    // ── About: Founder ────────────────────────────────────────

    Container::make('post_meta', 'About — Founder')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text',      'about_founder_name',  'Name'),
            Field::make('text',      'about_founder_title', 'Title / Role'),
            Field::make('rich_text', 'about_founder_bio',   'Bio')
                ->set_help_text('Full bio. Supports paragraphs, bold, italic, and links.'),
            Field::make('image',     'about_founder_image', 'Photo'),
        ]);

    // ── About: CTA ────────────────────────────────────────────

    Container::make('post_meta', 'About — CTA')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text',     'about_cta_heading',    'Heading'),
            Field::make('textarea', 'about_cta_subheading', 'Subheading')
                ->set_rows(2),
            Field::make('text',     'about_cta_url',        'CTA URL'),
            Field::make('text',     'about_cta_title',      'CTA Label')
                ->set_default_value('Get In Touch'),
            Field::make('select',   'about_cta_target',     'CTA Target')
                ->set_options(['_self' => 'Same Window', '_blank' => 'New Tab']),
        ]);

    // ── Contact: Hero ─────────────────────────────────────────

    Container::make('post_meta', 'Contact — Hero')
        ->where('post_template', '=', 'templates/page-contact.php')
        ->add_fields([
            Field::make('text',     'contact_hero_heading',    'Heading'),
            Field::make('textarea', 'contact_hero_subheading', 'Subheading')
                ->set_rows(2),
        ]);

    // ── Contact: Form ─────────────────────────────────────────

    Container::make('post_meta', 'Contact — Form')
        ->where('post_template', '=', 'templates/page-contact.php')
        ->add_fields([
            Field::make('text', 'contact_form_heading',   'Section Heading')
                ->set_default_value('Send a message'),
            Field::make('text', 'contact_form_shortcode', 'CF7 Shortcode')
                ->set_help_text('Paste the full [contact-form-7 id="…" title="…"] shortcode here.'),
        ]);

    // ── Work: Hero ────────────────────────────────────────────

    Container::make('post_meta', 'Work — Hero')
        ->where('post_template', '=', 'templates/page-work.php')
        ->add_fields([
            Field::make('text',     'work_hero_heading',    'Heading'),
            Field::make('textarea', 'work_hero_subheading', 'Subheading')
                ->set_rows(2),
        ]);

    // ── Work: Grid ────────────────────────────────────────────

    Container::make('post_meta', 'Work — Grid')
        ->where('post_template', '=', 'templates/page-work.php')
        ->add_fields([
            Field::make('text', 'work_grid_heading', 'Section Heading')
                ->set_default_value('Published work'),
            Field::make('complex', 'work_grid_items', 'Projects')
                ->add_fields([
                    Field::make('text',     'title',       'Project Name'),
                    Field::make('textarea', 'description', 'Description')
                        ->set_rows(2),
                    Field::make('text',     'url',         'URL'),
                    Field::make('select',   'type',        'Type')
                        ->set_options([
                            'chrome-extension' => 'Chrome Extension',
                            'web-app'          => 'Web App',
                            'ios-app'          => 'iOS App',
                        ]),
                    Field::make('image',    'image',       'Screenshot / Icon'),
                ]),
        ]);

});
