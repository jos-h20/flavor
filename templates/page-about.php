<?php
/**
 * Template Name: About
 */

get_header();
?>

<main>
    <?php include get_template_directory() . '/templates/sections/about-hero.php'; ?>
    <?php include get_template_directory() . '/templates/sections/about-values.php'; ?>
    <?php include get_template_directory() . '/templates/sections/about-approach.php'; ?>
    <?php include get_template_directory() . '/templates/sections/about-founder.php'; ?>
    <?php include get_template_directory() . '/templates/sections/about-cta.php'; ?>
</main>

<?php get_footer(); ?>
