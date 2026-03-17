<?php
/**
 * Single Post Template
 *
 * WordPress template hierarchy: handles all single post display.
 * No Template Name header needed — WordPress picks this up automatically.
 */

get_header();
?>

<main>
    <?php while (have_posts()) : the_post(); ?>
        <?php include get_template_directory() . '/templates/sections/blog-single-post.php'; ?>
        <?php include get_template_directory() . '/templates/sections/blog-single-nav.php'; ?>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
