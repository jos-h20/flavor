<?php
/**
 * Section: Blog Single Post
 * Page: Single Post (single.php)
 * Description: Full post layout — meta bar, title, optional subtitle, featured image, content, tags.
 * Fields:
 *   - post_subtitle (textarea): Optional subtitle / deck shown between title and content
 */

// ─── Data ────────────────────────────────────────────────────
$post_id      = get_the_ID();
$post_obj     = get_post($post_id);
$categories   = get_the_category($post_id);
$category     = $categories ? $categories[0] : null;
$tags         = get_the_tags($post_id);
$word_count   = str_word_count(strip_tags($post_obj->post_content));
$reading_time = max(1, (int) ceil($word_count / 200));
$thumb_id     = get_post_thumbnail_id($post_id);
$thumb        = $thumb_id ? flavor_get_image_data($thumb_id) : null;
$subtitle     = carbon_get_post_meta($post_id, 'post_subtitle');
$content      = apply_filters('the_content', get_the_content());
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.blog-single-post {
    padding: var(--spacing-xl) var(--spacing-md) var(--spacing-2xl);
    background-color: var(--color-bg);
}

.blog-single-post__container {
    max-width: var(--max-width-narrow);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}

/* ── Meta bar ── */

.blog-single-post__meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: var(--spacing-sm);
    font-family: var(--font-body);
    font-size: 0.75rem;
    font-weight: 300;
    letter-spacing: 0.04em;
    color: var(--color-text-light);
    margin-bottom: var(--spacing-lg);
}

.blog-single-post__category {
    font-weight: 500;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--color-primary-dark);
    background-color: color-mix(in srgb, var(--color-primary) 12%, transparent);
    padding: 0.2em 0.65em;
    border-radius: var(--radius-full);
}

.blog-single-post__meta-sep {
    opacity: 0.35;
}

/* ── Title ── */

.blog-single-post__title {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(2rem, 5vw, 3rem);
    line-height: 1.2;
    color: var(--color-text);
    margin-bottom: var(--spacing-md);
}

/* ── Subtitle ── */

.blog-single-post__subtitle {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: clamp(1.05rem, 1.8vw, 1.2rem);
    line-height: 1.65;
    color: var(--color-text-light);
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid var(--color-border);
}

/* ── Featured image ── */

.blog-single-post__image-wrapper {
    margin: var(--spacing-lg) 0;
    border-radius: var(--radius-lg);
    overflow: hidden;
    aspect-ratio: 16 / 9;
    background-color: var(--color-bg-alt);
}

.blog-single-post__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ── Divider (used when no subtitle) ── */

.blog-single-post__rule {
    width: 3rem;
    height: 1px;
    background: var(--color-km-brown);
    margin: var(--spacing-md) 0 var(--spacing-lg);
}

/* ── Content ── */

.blog-single-post__content {
    font-family: var(--font-body);
    font-size: 1.05rem;
    font-weight: 300;
    line-height: 1.8;
    color: var(--color-text);
}

.blog-single-post__content p {
    margin-bottom: 1.5em;
}

.blog-single-post__content h2,
.blog-single-post__content h3,
.blog-single-post__content h4 {
    font-family: var(--font-heading);
    font-weight: 400;
    margin-top: 2em;
    margin-bottom: 0.75em;
    color: var(--color-text);
}

.blog-single-post__content h2 {
    font-size: clamp(1.5rem, 3vw, 1.9rem);
}

.blog-single-post__content h3 {
    font-size: clamp(1.25rem, 2.5vw, 1.5rem);
}

.blog-single-post__content a {
    color: var(--color-primary-dark);
    text-decoration: underline;
    text-underline-offset: 0.15em;
    text-decoration-thickness: 1px;
    transition: color var(--transition-fast);
}

.blog-single-post__content a:hover {
    color: var(--color-primary);
}

.blog-single-post__content ul,
.blog-single-post__content ol {
    padding-left: 1.5em;
    margin-bottom: 1.5em;
}

.blog-single-post__content ul {
    list-style: disc;
}

.blog-single-post__content ol {
    list-style: decimal;
}

.blog-single-post__content li {
    margin-bottom: 0.4em;
}

.blog-single-post__content blockquote {
    margin: 2em 0;
    padding: var(--spacing-md) var(--spacing-lg);
    border-left: 3px solid var(--color-km-brown);
    background-color: var(--color-bg-alt);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    font-style: italic;
    color: var(--color-text-light);
}

.blog-single-post__content img {
    border-radius: var(--radius-md);
    margin: 1.5em 0;
}

.blog-single-post__content pre,
.blog-single-post__content code {
    font-family: var(--font-mono);
    font-size: 0.9em;
    background-color: var(--color-bg-alt);
    border-radius: var(--radius-sm);
}

.blog-single-post__content code {
    padding: 0.15em 0.35em;
}

.blog-single-post__content pre {
    padding: var(--spacing-md);
    overflow-x: auto;
    margin-bottom: 1.5em;
}

.blog-single-post__content pre code {
    background: none;
    padding: 0;
}

/* ── Tags ── */

.blog-single-post__tags {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
    margin-top: var(--spacing-xl);
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--color-border);
}

.blog-single-post__tags-label {
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--color-text-light);
    align-self: center;
    margin-right: var(--spacing-xs);
}

.blog-single-post__tag {
    font-size: 0.8rem;
    font-weight: 300;
    color: var(--color-text-light);
    background-color: var(--color-bg-alt);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
    padding: 0.2em 0.75em;
    transition: background-color var(--transition-fast), color var(--transition-fast), border-color var(--transition-fast);
}

.blog-single-post__tag:hover {
    background-color: var(--color-navy-deep);
    color: var(--color-white);
    border-color: var(--color-navy-deep);
}

@media (min-width: 768px) {
    .blog-single-post {
        padding: var(--spacing-2xl) var(--spacing-lg) var(--spacing-3xl);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="blog-single-post" data-section="blog-single-post">
    <article class="blog-single-post__container">

        <!-- Meta bar -->
        <div class="blog-single-post__meta">
            <?php if ($category) : ?>
                <span class="blog-single-post__category"><?php echo esc_html($category->name); ?></span>
                <span class="blog-single-post__meta-sep" aria-hidden="true">·</span>
            <?php endif; ?>
            <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                <?php echo esc_html(get_the_date('M j, Y')); ?>
            </time>
            <span class="blog-single-post__meta-sep" aria-hidden="true">·</span>
            <span><?php echo esc_html(get_the_author()); ?></span>
            <span class="blog-single-post__meta-sep" aria-hidden="true">·</span>
            <span><?php echo esc_html($reading_time); ?> min read</span>
        </div>

        <!-- Title -->
        <h1 class="blog-single-post__title"><?php the_title(); ?></h1>

        <!-- Subtitle -->
        <?php if ($subtitle) : ?>
            <p class="blog-single-post__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php else : ?>
            <div class="blog-single-post__rule" aria-hidden="true"></div>
        <?php endif; ?>

        <!-- Featured image -->
        <?php if ($thumb) : ?>
            <figure class="blog-single-post__image-wrapper">
                <img
                    class="blog-single-post__image"
                    src="<?php echo esc_url($thumb['url']); ?>"
                    alt="<?php echo esc_attr($thumb['alt'] ?: get_the_title()); ?>"
                    width="<?php echo esc_attr($thumb['width']); ?>"
                    height="<?php echo esc_attr($thumb['height']); ?>"
                    loading="lazy"
                >
            </figure>
        <?php endif; ?>

        <!-- Post body -->
        <div class="blog-single-post__content">
            <?php echo wp_kses_post($content); ?>
        </div>

        <!-- Tags -->
        <?php if ($tags) : ?>
            <div class="blog-single-post__tags">
                <span class="blog-single-post__tags-label">Tags</span>
                <?php foreach ($tags as $tag) : ?>
                    <a class="blog-single-post__tag" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </article>
</section>
