<?php
/**
 * Template Name: Blog
 */

get_header();
?>

<main>
    <?php include get_template_directory() . '/templates/sections/blog-hero.php'; ?>
    <?php include get_template_directory() . '/templates/sections/blog-index.php'; ?>
</main>

<?php get_footer(); ?>
