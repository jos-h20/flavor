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
                ->set_default_value('Privacy First'),
            Field::make('text', 'home_hero_tagline_2', 'Tagline — Item 2')
                ->set_default_value('Simple by Design'),
            Field::make('text', 'home_hero_tagline_3', 'Tagline — Item 3')
                ->set_default_value('Intelligently Crafted'),
            Field::make('rich_text', 'home_hero_headline', 'Headline')
                ->set_default_value('Privacy isn\'t a setting.<br><em>It\'s the default.</em>')
                ->set_help_text('Main headline. Use <em> tags for italic accent colour. Default: "Privacy isn\'t a setting.<br><em>It\'s the default.</em>"'),
            Field::make('textarea', 'home_hero_sub', 'Subtext')
                ->set_default_value('Kanso is a one-person studio building apps and tools where data stays on your device, features stay in their lane, and nothing ships until it\'s right.')
                ->set_rows(3)
                ->set_help_text('Supporting paragraph below the headline.'),
            Field::make('text', 'home_hero_cta_primary_url', 'Primary CTA — URL'),
            Field::make('text', 'home_hero_cta_primary_title', 'Primary CTA — Label')
                ->set_default_value('View Our Work'),
            Field::make('text', 'home_hero_cta_ghost_url', 'Ghost CTA — URL'),
            Field::make('text', 'home_hero_cta_ghost_title', 'Ghost CTA — Label')
                ->set_default_value('Get In Touch'),
        ]);

    // ── About: Hero ───────────────────────────────────────────

    Container::make('post_meta', 'About — Hero')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_hero_heading', 'Heading')
                ->set_default_value('Software built for people,<br><em>not portfolios.</em>')
                ->set_help_text('Main headline. Use <em> tags for italic accent. Supports <br> for line breaks.'),
            Field::make('textarea', 'about_hero_subheading', 'Subheading')
                ->set_default_value('Kanso Media is a one-person studio. The person you talk to is the person who builds it — and I take that seriously.')
                ->set_rows(3)
                ->set_help_text('1–2 sentence personal statement below the headline.'),
        ]);

    // ── About: Values ─────────────────────────────────────────

    Container::make('post_meta', 'About — Values')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_values_heading', 'Heading')
                ->set_default_value('What I stand for'),
            Field::make('complex', 'about_values_items', 'Value Cards')
                ->set_default_value([
                    ['title' => 'Simplicity', 'description' => 'Not minimal for aesthetic reasons. Minimal because every unnecessary feature is a cost your users pay.'],
                    ['title' => 'Privacy',    'description' => 'Your users didn\'t agree to be the product. I build as if their data is none of my business — because it isn\'t.'],
                    ['title' => 'Craft',      'description' => 'The part you can\'t see is usually what matters most. Good architecture doesn\'t announce itself.'],
                    ['title' => 'Honesty',    'description' => 'If something\'s going to take longer, I\'ll tell you before it does. If your idea has a flaw, I\'ll say that too.'],
                    ['title' => 'Ownership',  'description' => 'You own everything we build together — code, IP, all of it. No lock-in, no licensing surprises, no strings.'],
                    ['title' => 'Restraint',  'description' => 'Adding features is easy. Knowing which ones not to build is the skill that separates good software from great software.'],
                ])
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
            Field::make('text', 'about_approach_heading', 'Heading')
                ->set_default_value('How a project actually works'),
            Field::make('complex', 'about_approach_steps', 'Process Steps')
                ->set_default_value([
                    ['title' => 'Discovery', 'description' => 'We talk before I write a single line of code. I want to understand the real problem — not just the requirements document.'],
                    ['title' => 'Proposal',  'description' => 'A clear scope, timeline, and cost. You know exactly what you\'re getting before we start. No vague estimates, no hidden assumptions.'],
                    ['title' => 'Build',     'description' => 'You see progress as it happens. Regular check-ins, working software early, and a direct line to me throughout.'],
                    ['title' => 'Launch',    'description' => 'Careful deployment, thorough testing, and a handover that makes sense. I\'m still available after go-live, not just before it.'],
                    ['title' => 'After',     'description' => 'Bugs get fixed. Questions get answered. If something needs to change six months from now, I\'m a message away.'],
                ])
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
            Field::make('text',      'about_founder_name',  'Name')
                ->set_default_value('Josh Overly'),
            Field::make('text',      'about_founder_title', 'Title / Role')
                ->set_default_value('Founder & Developer'),
            Field::make('rich_text', 'about_founder_bio',   'Bio')
                ->set_default_value('<p>I\'ve been writing code since 2016. What started as a hobby became a craft, and the craft became a business when I got tired of watching software get built badly.</p><p>Kanso Media is deliberately small. I work with a handful of clients at a time, which means your project gets my full attention — not a project manager as a go-between, not a junior dev on the hard parts. The person you talk to is the person who builds it.</p><p>The name comes from a Japanese design philosophy: the idea that beauty emerges from removing everything that isn\'t essential. It turns out to be a useful principle for software.</p>')
                ->set_help_text('Full bio. Supports paragraphs, bold, italic, and links.'),
            Field::make('image',     'about_founder_image', 'Photo'),
        ]);

    // ── About: CTA ────────────────────────────────────────────

    Container::make('post_meta', 'About — CTA')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text',     'about_cta_heading',    'Heading')
                ->set_default_value('Let\'s build something worth building.'),
            Field::make('textarea', 'about_cta_subheading', 'Subheading')
                ->set_default_value('I take on a small number of projects each year — enough to do each one properly. If you have something in mind, I\'d like to hear about it.')
                ->set_rows(2),
            Field::make('text',     'about_cta_url',        'CTA URL'),
            Field::make('text',     'about_cta_title',      'CTA Label')
                ->set_default_value('Start a Conversation'),
            Field::make('select',   'about_cta_target',     'CTA Target')
                ->set_options(['_self' => 'Same Window', '_blank' => 'New Tab']),
        ]);

    // ── Contact: Hero ─────────────────────────────────────────

    Container::make('post_meta', 'Contact — Hero')
        ->where('post_template', '=', 'templates/page-contact.php')
        ->add_fields([
            Field::make('text',     'contact_hero_heading',    'Heading')
                ->set_default_value('Let\'s talk.'),
            Field::make('textarea', 'contact_hero_subheading', 'Subheading')
                ->set_default_value('Tell me what you\'re working on. I read every message and reply as quickly as I can.')
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
            Field::make('text',     'work_hero_heading',    'Heading')
                ->set_default_value('Apps &amp; extensions,<br><em>built with care.</em>'),
            Field::make('textarea', 'work_hero_subheading', 'Subheading')
                ->set_default_value('Small, focused tools that do one thing well. Each one is something I built because I wanted it to exist.')
                ->set_rows(2),
        ]);

    // ── Work: Grid ────────────────────────────────────────────

    Container::make('post_meta', 'Work — Grid')
        ->where('post_template', '=', 'templates/page-work.php')
        ->add_fields([
            Field::make('text', 'work_grid_heading', 'Section Heading')
                ->set_default_value('Published work'),
            Field::make('complex', 'work_grid_items', 'Projects')
                ->set_default_value([
                    ['title' => 'Mt Bachelor Snow Stake Live', 'description' => 'Live snow stake camera feed for Mt. Bachelor, right in your browser toolbar.', 'url' => 'https://chromewebstore.google.com/detail/mt-bachelor-snow-stake-li/pehclpbdmgfhgnfihaebdnmjpchcencc', 'type' => 'chrome-extension', 'image' => ''],
                    ['title' => 'Bitcoin Price Badge',         'description' => 'Live Bitcoin price displayed as a badge on your browser toolbar. No accounts, no noise.',                         'url' => 'https://chromewebstore.google.com/detail/bitcoin-price-badge/jhhmnipbopokecfpomonnlockkgkbipo',      'type' => 'chrome-extension', 'image' => ''],
                    ['title' => 'Course Video Auto Play',      'description' => 'Automatically advances to the next lesson so you can stay in flow.',                                              'url' => 'https://chromewebstore.google.com/detail/course-video-auto-play/gakandenhanlineidcebgnpllgdnjhji',   'type' => 'chrome-extension', 'image' => ''],
                    ['title' => 'PaddleFlows',                 'description' => 'Live river levels for the Pacific Northwest',                                                                     'url' => 'https://paddleflows.com/',                                                                          'type' => 'web-app',          'image' => ''],
                ])
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


    // ── Apps: Hero ────────────────────────────────────────────

    Container::make('post_meta', 'Apps — Hero')
        ->where('post_template', '=', 'templates/page-apps.php')
        ->add_fields([
            Field::make('text',     'apps_hero_heading',    'Heading')
                ->set_default_value('Our Apps'),
            Field::make('textarea', 'apps_hero_subheading', 'Subheading')
                ->set_default_value('Small, focused iOS apps built to do one thing well.')
                ->set_rows(2),
        ]);

    // ── Apps: Grid ────────────────────────────────────────────

    Container::make('post_meta', 'Apps — Grid')
        ->where('post_template', '=', 'templates/page-apps.php')
        ->add_fields([
            Field::make('complex', 'apps_grid_items', 'Apps')
                ->set_default_value([
                    ['icon' => '', 'name' => 'SyncFit', 'tagline' => 'Sync your Fitbit metrics — including intraday data — directly into Apple Health. No shortcuts, no gaps.', 'url' => '/syncfit'],
                ])
                ->add_fields([
                    Field::make('image',    'icon',    'App Icon'),
                    Field::make('text',     'name',    'App Name'),
                    Field::make('textarea', 'tagline', 'Tagline')
                        ->set_rows(2),
                    Field::make('text',     'url',     'Page URL')
                        ->set_help_text('Relative path to the app page, e.g. /syncfit'),
                ]),
        ]);

    // ── SyncFit: Hero ─────────────────────────────────────────

    Container::make('post_meta', 'SyncFit — Hero')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('image',    'syncfit_hero_icon',         'App Icon'),
            Field::make('text',     'syncfit_hero_heading',      'Heading')
                ->set_default_value('Bridge Your Fitbit Data to Apple Health'),
            Field::make('textarea', 'syncfit_hero_subtext',      'Subtext')
                ->set_default_value('SyncFit syncs your Fitbit metrics — including intraday data — directly into Apple Health. No shortcuts, no gaps.')
                ->set_rows(2),
            Field::make('text',     'syncfit_hero_appstore_url', 'App Store URL'),
        ]);

    // ── SyncFit: Intraday ─────────────────────────────────────

    Container::make('post_meta', 'SyncFit — Intraday')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('text',     'syncfit_intraday_heading',    'Heading')
                ->set_default_value('Intraday Data, Done Right'),
            Field::make('textarea', 'syncfit_intraday_subheading', 'Subheading')
                ->set_default_value('SyncFit pulls minute-by-minute data from Fitbit\'s API — the same detail your Fitbit app shows you — and writes it to Apple Health in the correct format.')
                ->set_rows(2),
        ]);

    // ── SyncFit: Pricing ──────────────────────────────────────

    Container::make('post_meta', 'SyncFit — Pricing')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('text', 'syncfit_pricing_appstore_url', 'App Store URL (Pro CTA)'),
        ]);

    // ── SyncFit: Metrics ──────────────────────────────────────

    Container::make('post_meta', 'SyncFit — Metrics')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('text', 'syncfit_metrics_heading', 'Heading')
                ->set_default_value('25 Health Metrics Supported'),
        ]);

    // ── SyncFit: How It Works ─────────────────────────────────

    Container::make('post_meta', 'SyncFit — How It Works')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('text', 'syncfit_hiw_heading', 'Heading')
                ->set_default_value('Up and Running in Minutes'),
        ]);

    // ── SyncFit: Privacy ──────────────────────────────────────

    Container::make('post_meta', 'SyncFit — Privacy')
        ->where('post_template', '=', 'templates/page-syncfit.php')
        ->add_fields([
            Field::make('text',     'syncfit_privacy_heading', 'Heading')
                ->set_default_value('Your Data Stays Yours'),
            Field::make('textarea', 'syncfit_privacy_body',    'Body')
                ->set_default_value('SyncFit connects directly to Fitbit\'s official API using OAuth. Your Fitbit credentials are never stored by SyncFit — authentication is handled entirely by Fitbit. Health data is written locally to Apple Health on your device and never transmitted to our servers. No ads, no data brokering, no tracking.')
                ->set_rows(3),
        ]);


    // ── Blog: Hero ────────────────────────────────────────────

    Container::make('post_meta', 'Blog — Hero')
        ->where('post_template', '=', 'templates/page-blog.php')
        ->add_fields([
            Field::make('text',     'blog_hero_heading',    'Heading')
                ->set_default_value('From the Studio'),
            Field::make('textarea', 'blog_hero_subheading', 'Subheading')
                ->set_rows(2)
                ->set_help_text('Optional deck copy shown below the heading.'),
        ]);

    // ── Blog: Single Post extras ──────────────────────────────

    Container::make('post_meta', 'Blog Post')
        ->where('post_type', '=', 'post')
        ->add_fields([
            Field::make('textarea', 'post_subtitle', 'Subtitle / Deck')
                ->set_rows(2)
                ->set_help_text('Optional subtitle shown between the post title and body. Leave blank to omit.'),
        ]);

    // ── Site Settings: Tracking & Code Injection ──────────────

    Container::make('theme_options', 'Site Settings')
        ->set_icon('dashicons-admin-generic')
        ->add_fields([
            Field::make('text', 'gtm_id', 'Google Tag Manager ID')
                ->set_help_text('e.g. GTM-XXXXXXX — leave blank to disable. The theme outputs both the <head> script and the <body> noscript automatically.'),
            Field::make('textarea', 'global_head_code', 'Global Head Code')
                ->set_rows(5)
                ->set_help_text('Injected before </head> on every page. Use for additional meta tags, font preloads, etc. GTM already handles analytics — use this for anything else.'),
            Field::make('textarea', 'global_footer_code', 'Global Footer Code')
                ->set_rows(5)
                ->set_help_text('Injected before </body> on every page.'),
        ]);

});
