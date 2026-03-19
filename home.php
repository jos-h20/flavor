<?php
/**
 * Blog listing page (Posts page).
 *
 * WordPress uses home.php when a page is set as the "Posts page"
 * in Settings > Reading. The custom page template (templates/page-blog.php)
 * is ignored by WordPress in that context — this file bridges the gap.
 *
 * Page: Blog (/blog/)
 * Sections: blog-hero, blog-index
 */
get_header(); ?>

<main>
    <?php include get_template_directory() . '/templates/sections/blog-hero.php'; ?>
    <?php include get_template_directory() . '/templates/sections/blog-index.php'; ?>
</main>

<?php get_footer();
