<?php
/**
 * Default template fallback.
 *
 * This theme uses templates/page-builder.php for page content.
 * This file exists because WordPress requires an index.php in every theme.
 */

get_header();
?>

<main class="container" style="padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
