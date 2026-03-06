<?php
/**
 * Carbon Fields Registration
 *
 * All fields are registered in code so they're version-controlled.
 * Each layout in the complex field corresponds to a section
 * file at templates/sections/{layout-name}.php.
 *
 * --- How to Add a New Section Layout ---
 *
 * 1. Add a new ->add_fields() call inside the 'sections' complex field below.
 * 2. Use this structure:
 *
 *    ->add_fields('my_section', 'My Section', [
 *        Field::make('text', 'heading', 'Heading'),
 *        // ... more fields
 *    ])
 *
 * 3. Create the matching file: templates/sections/my_section.php
 * 4. Create a preview: _preview/my_section.html
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    Container::make('post_meta', 'Page Sections')
        ->where('post_template', '=', 'templates/page-builder.php')
        ->add_fields([
            Field::make('complex', 'sections', 'Sections')
                ->set_layout('tabbed-vertical')

                // --- Hero ---
                ->add_fields('hero', 'Hero', [
                    Field::make('text', 'heading', 'Heading'),
                    Field::make('textarea', 'subheading', 'Subheading')
                        ->set_rows(3),
                    Field::make('image', 'background_image', 'Background Image'),
                    Field::make('text', 'cta_url', 'CTA URL'),
                    Field::make('text', 'cta_title', 'CTA Text'),
                    Field::make('select', 'cta_target', 'CTA Target')
                        ->set_options([
                            '_self' => 'Same Window',
                            '_blank' => 'New Tab',
                        ]),
                    Field::make('select', 'style', 'Style')
                        ->set_options([
                            'default' => 'Default',
                            'dark'    => 'Dark',
                            'minimal' => 'Minimal',
                        ]),
                ]),

        ]);
});
