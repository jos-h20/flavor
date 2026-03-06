<?php
/**
 * Template Name: Page Builder
 */

get_header();
?>

<main>
    <?php
    $sections = carbon_get_the_post_meta('sections');

    if (!empty($sections)) :
        foreach ($sections as $section_data) :
            $layout = $section_data['_type'];
            $section_file = get_template_directory() . '/templates/sections/' . $layout . '.php';

            if (file_exists($section_file)) {
                include $section_file;
            }
        endforeach;
    endif;
    ?>
</main>

<?php
get_footer();
