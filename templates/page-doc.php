<?php
/**
 * Template Name: Document
 *
 * Generic Flavor-themed document template for long-form text pages
 * (Privacy Policy, Terms of Service, Support, etc.)
 *
 * No Carbon Fields — content is entered via standard WordPress editor.
 */

get_header(); ?>

<style>
.doc {
    background: var(--color-bg);
    padding: var(--spacing-xl) var(--spacing-md);
    min-height: 60vh;
}

.doc__inner {
    max-width: var(--max-width-narrow);
    margin: 0 auto;
}

.doc__title {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 300;
    color: var(--color-text);
    line-height: 1.2;
    margin-bottom: var(--spacing-sm);
}

.doc__divider {
    border: none;
    border-top: 1px solid var(--color-border);
    margin-bottom: var(--spacing-lg);
}

/* ── Prose styles ─────────────────────────────────────────── */

.doc__content p {
    font-family: var(--font-body);
    font-size: 1.1rem;
    color: var(--color-text);
    line-height: 1.75;
    margin-bottom: var(--spacing-md);
}

.doc__content h2 {
    font-family: var(--font-heading);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-text);
    line-height: 1.25;
    margin-top: var(--spacing-lg);
    margin-bottom: var(--spacing-sm);
}

.doc__content h3 {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--color-text);
    line-height: 1.3;
    margin-top: var(--spacing-md);
    margin-bottom: var(--spacing-sm);
}

.doc__content h4 {
    font-family: var(--font-heading);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--color-text);
    margin-top: var(--spacing-md);
    margin-bottom: var(--spacing-sm);
}

.doc__content a {
    color: var(--color-primary);
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color var(--transition-fast);
}

.doc__content a:hover {
    color: var(--color-primary-dark);
}

.doc__content ul {
    list-style: disc;
    padding-left: 1.5em;
    margin-bottom: var(--spacing-md);
}

.doc__content ol {
    list-style: decimal;
    padding-left: 1.5em;
    margin-bottom: var(--spacing-md);
}

.doc__content li {
    font-family: var(--font-body);
    font-size: 1.1rem;
    color: var(--color-text);
    line-height: 1.6;
    margin-bottom: 0.4em;
}

.doc__content strong {
    font-weight: 700;
}

.doc__content em {
    font-style: italic;
}

.doc__content hr {
    border: none;
    border-top: 1px solid var(--color-border);
    margin: var(--spacing-lg) 0;
}

.doc__content blockquote {
    border-left: 3px solid var(--color-primary);
    padding-left: var(--spacing-md);
    margin: var(--spacing-md) 0;
    font-style: italic;
    color: var(--color-text-light);
}

.doc__content blockquote p {
    color: var(--color-text-light);
}

.doc__content code {
    font-family: var(--font-mono);
    font-size: 0.875em;
    background: var(--color-bg-alt);
    color: var(--color-text);
    padding: 0.1em 0.35em;
    border-radius: var(--radius-sm);
}

.doc__content pre {
    background: var(--color-bg-alt);
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
    overflow-x: auto;
    margin-bottom: var(--spacing-md);
}

.doc__content pre code {
    background: none;
    padding: 0;
    font-size: 0.9rem;
}
</style>

<main class="doc">
    <div class="doc__inner">

        <h1 class="doc__title"><?= esc_html(get_the_title()) ?></h1>
        <hr class="doc__divider">

        <div class="doc__content">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

    </div>
</main>

<?php get_footer();
