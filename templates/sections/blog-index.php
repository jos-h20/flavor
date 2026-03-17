<?php
/**
 * Section: Blog Index
 * Page: Blog
 * Description: WP_Query-powered post card grid — 6 posts per page with pagination.
 *              No Carbon Fields. All data comes directly from post objects.
 */

// ─── Data ────────────────────────────────────────────────────
$paged = get_query_var('paged') ?: 1;

$query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
]);
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.blog-index {
    padding: var(--spacing-2xl) var(--spacing-md);
    background-color: var(--color-bg);
}

.blog-index__container {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}

/* ── Empty state ── */

.blog-index__empty {
    text-align: center;
    padding: var(--spacing-2xl) 0;
    color: var(--color-text-light);
}

.blog-index__empty-icon {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-md);
    opacity: 0.35;
}

.blog-index__empty-heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: 1.75rem;
    color: var(--color-text);
    margin-bottom: var(--spacing-sm);
}

.blog-index__empty-text {
    font-size: 0.95rem;
    color: var(--color-text-light);
    margin-bottom: 0;
}

/* ── Grid ── */

.blog-index__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-lg);
}

@media (min-width: 640px) {
    .blog-index__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .blog-index__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* ── Card ── */

.blog-index__card {
    display: flex;
    flex-direction: column;
    background-color: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: transform var(--transition-base), box-shadow var(--transition-base);
}

.blog-index__card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.blog-index__card-image-link {
    display: block;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background-color: var(--color-bg-alt);
}

.blog-index__card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.blog-index__card:hover .blog-index__card-image {
    transform: scale(1.04);
}

.blog-index__card-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-navy-deep) 0%, var(--color-navy-mid) 100%);
}

.blog-index__card-image-placeholder svg {
    opacity: 0.2;
}

.blog-index__card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: var(--spacing-lg);
    gap: var(--spacing-sm);
}

.blog-index__card-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
    font-family: var(--font-body);
    font-size: 0.72rem;
    font-weight: 300;
    letter-spacing: 0.05em;
    color: var(--color-text-light);
}

.blog-index__card-category {
    font-weight: 500;
    color: var(--color-primary);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-size: 0.68rem;
}

.blog-index__card-meta-sep {
    opacity: 0.4;
}

.blog-index__card-title {
    font-family: var(--font-heading);
    font-weight: 400;
    font-size: clamp(1.15rem, 2vw, 1.35rem);
    line-height: 1.3;
    color: var(--color-text);
    margin-bottom: 0;
}

.blog-index__card-title-link {
    color: inherit;
    transition: color var(--transition-fast);
}

.blog-index__card-title-link:hover {
    color: var(--color-primary-dark);
}

.blog-index__card-excerpt {
    font-size: 0.9rem;
    font-weight: 300;
    line-height: 1.7;
    color: var(--color-text-light);
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-index__card-read-more {
    margin-top: auto;
    padding-top: var(--spacing-sm);
    font-size: 0.82rem;
    font-weight: 500;
    letter-spacing: 0.04em;
    color: var(--color-primary-dark);
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: gap var(--transition-fast), color var(--transition-fast);
}

.blog-index__card-read-more:hover {
    gap: 0.55rem;
    color: var(--color-primary);
}

/* ── Pagination ── */

.blog-index__pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: var(--spacing-sm);
    margin-top: var(--spacing-2xl);
    flex-wrap: wrap;
    font-family: var(--font-body);
    font-size: 0.875rem;
}

.blog-index__pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.25rem;
    height: 2.25rem;
    padding: 0 0.75rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--color-border);
    color: var(--color-text);
    font-weight: 400;
    transition: background-color var(--transition-fast), border-color var(--transition-fast), color var(--transition-fast);
}

.blog-index__pagination .page-numbers:hover {
    background-color: var(--color-bg-alt);
    border-color: var(--color-primary);
    color: var(--color-primary-dark);
}

.blog-index__pagination .page-numbers.current {
    background-color: var(--color-navy-deep);
    border-color: var(--color-navy-deep);
    color: var(--color-white);
    font-weight: 500;
}

.blog-index__pagination .page-numbers.dots {
    border-color: transparent;
    background: none;
    pointer-events: none;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="blog-index" data-section="blog-index">
    <div class="blog-index__container">

        <?php if ($query->have_posts()) : ?>

            <div class="blog-index__grid">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php
                    $post_id      = get_the_ID();
                    $post_obj     = get_post($post_id);
                    $categories   = get_the_category($post_id);
                    $category     = $categories ? $categories[0] : null;
                    $word_count   = str_word_count(strip_tags($post_obj->post_content));
                    $reading_time = max(1, (int) ceil($word_count / 200));
                    $thumb_id     = get_post_thumbnail_id($post_id);
                    $thumb        = $thumb_id ? flavor_get_image_data($thumb_id) : null;
                    ?>
                    <article class="blog-index__card">

                        <?php if ($thumb) : ?>
                            <a class="blog-index__card-image-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <img
                                    class="blog-index__card-image"
                                    src="<?php echo esc_url($thumb['url']); ?>"
                                    alt="<?php echo esc_attr($thumb['alt'] ?: get_the_title()); ?>"
                                    width="<?php echo esc_attr($thumb['width']); ?>"
                                    height="<?php echo esc_attr($thumb['height']); ?>"
                                    loading="lazy"
                                >
                            </a>
                        <?php else : ?>
                            <a class="blog-index__card-image-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <div class="blog-index__card-image-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-white)" stroke-width="1" aria-hidden="true">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="blog-index__card-body">
                            <div class="blog-index__card-meta">
                                <?php if ($category) : ?>
                                    <span class="blog-index__card-category"><?php echo esc_html($category->name); ?></span>
                                    <span class="blog-index__card-meta-sep" aria-hidden="true">·</span>
                                <?php endif; ?>
                                <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                                </time>
                                <span class="blog-index__card-meta-sep" aria-hidden="true">·</span>
                                <span><?php echo esc_html(get_the_author()); ?></span>
                                <span class="blog-index__card-meta-sep" aria-hidden="true">·</span>
                                <span><?php echo esc_html($reading_time); ?> min read</span>
                            </div>

                            <h2 class="blog-index__card-title">
                                <a class="blog-index__card-title-link" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <p class="blog-index__card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>

                            <a class="blog-index__card-read-more" href="<?php the_permalink(); ?>">
                                Read more
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>

                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            $pagination = paginate_links([
                'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                'format'    => '?paged=%#%',
                'current'   => $paged,
                'total'     => $query->max_num_pages,
                'type'      => 'list',
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ]);
            ?>
            <?php if ($pagination) : ?>
                <nav class="blog-index__pagination" aria-label="Blog pagination">
                    <?php echo $pagination; // Already sanitized by WordPress ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <div class="blog-index__empty">
                <div class="blog-index__empty-icon" aria-hidden="true">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <h2 class="blog-index__empty-heading">Nothing here yet</h2>
                <p class="blog-index__empty-text">Posts will appear here once published.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</section>
