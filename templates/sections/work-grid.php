<?php
/**
 * Section: Work Grid
 * Page: Our Work
 * Description: 2-column project card grid with image, type badge, title, description, and external link.
 * Fields:
 *   - work_grid_heading (text): Optional label above the grid
 *   - work_grid_items (complex): Repeater of projects
 *     - title (text): Project name
 *     - description (textarea): 1–2 sentence summary
 *     - url (text): External link URL
 *     - type (select): chrome-extension | web-app | ios-app
 *     - image (image): Screenshot or promo tile (attachment ID)
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'work_grid_heading') ?: 'Published work';
$items   = carbon_get_post_meta($post_id, 'work_grid_items');

$fallback_items = [
    [
        'title'       => 'Mt Bachelor Snow Stake Live',
        'description' => 'Live snow stake camera feed for Mt. Bachelor, right in your browser toolbar.',
        'url'         => 'https://chromewebstore.google.com/detail/mt-bachelor-snow-stake-li/pehclpbdmgfhgnfihaebdnmjpchcencc',
        'type'        => 'chrome-extension',
        'image'       => '',
    ],
    [
        'title'       => 'Bitcoin Price Badge',
        'description' => 'Live Bitcoin price displayed as a badge on your browser toolbar. No accounts, no noise.',
        'url'         => 'https://chromewebstore.google.com/detail/bitcoin-price-badge/jhhmnipbopokecfpomonnlockkgkbipo',
        'type'        => 'chrome-extension',
        'image'       => '',
    ],
    [
        'title'       => 'Course Video Auto Play',
        'description' => 'Automatically advances to the next lesson so you can stay in flow.',
        'url'         => 'https://chromewebstore.google.com/detail/course-video-auto-play/gakandenhanlineidcebgnpllgdnjhji',
        'type'        => 'chrome-extension',
        'image'       => '',
    ],
    [
        'title'       => 'PaddleFlows',
        'description' => 'Live river levels for the Pacific Northwest',
        'url'         => 'https://paddleflows.com/',
        'type'        => 'web-app',
        'image'       => '',
    ],
];

$items = $items ?: $fallback_items;

$type_labels = [
    'chrome-extension' => 'Chrome Extension',
    'web-app'          => 'Web App',
    'ios-app'          => 'iOS App',
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.work-grid {
    background: var(--color-bg);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.work-grid__container {
    max-width: var(--max-width);
    margin: 0 auto;
}

.work-grid__heading {
    font-family: var(--font-body);
    font-weight: 400;
    font-size: clamp(0.65rem, 1.2vw, 0.75rem);
    letter-spacing: 0.5em;
    text-transform: uppercase;
    color: var(--color-text-light);
    margin-bottom: var(--spacing-xl);
}

.work-grid__items {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-lg);
}

@media (min-width: 768px) {
    .work-grid__items {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* ── Card ─────────────────────────────────────────────────── */

.work-grid__card {
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease, box-shadow var(--transition-base);
}

.work-grid__card:nth-child(1) { transition-delay: 0ms; }
.work-grid__card:nth-child(2) { transition-delay: 100ms; }
.work-grid__card:nth-child(3) { transition-delay: 200ms; }
.work-grid__card:nth-child(4) { transition-delay: 300ms; }

.work-grid.is-visible .work-grid__card {
    opacity: 1;
    transform: translateY(0);
}

.work-grid__card:hover {
    box-shadow: var(--shadow-md);
}

/* ── Card image ───────────────────────────────────────────── */

.work-grid__card-image {
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: var(--color-bg-alt);
}

.work-grid__card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.work-grid__card:hover .work-grid__card-image img {
    transform: scale(1.03);
}

/* ── Card body ────────────────────────────────────────────── */

.work-grid__card-body {
    padding: var(--spacing-lg);
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
    flex: 1;
}

.work-grid__card-badge {
    display: inline-block;
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.65rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--color-text-light);
    background: var(--color-bg-alt);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
    padding: 0.2em 0.75em;
    align-self: flex-start;
}

.work-grid__card-title {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.25rem, 2vw, 1.5rem);
    color: var(--color-text);
    line-height: 1.2;
    margin-top: var(--spacing-xs);
}

.work-grid__card-description {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.9rem;
    color: var(--color-text-light);
    line-height: 1.7;
    flex: 1;
}

.work-grid__card-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35em;
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--color-km-blue);
    margin-top: var(--spacing-sm);
    transition: gap var(--transition-fast);
}

.work-grid__card-link:hover {
    gap: 0.6em;
}

.work-grid__card-link svg {
    width: 0.85em;
    height: 0.85em;
    flex-shrink: 0;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="work-grid" data-section="work-grid">
    <div class="work-grid__container">

        <?php if ($heading) : ?>
            <p class="work-grid__heading"><?php echo esc_html($heading); ?></p>
        <?php endif; ?>

        <div class="work-grid__items">
            <?php foreach ($items as $item) :
                $title       = $item['title']       ?? '';
                $description = $item['description'] ?? '';
                $url         = $item['url']         ?? '';
                $type        = $item['type']        ?? '';
                $image_id    = $item['image']       ?? '';
                $image       = $image_id ? flavor_get_image_data($image_id) : null;
                $type_label  = $type_labels[$type]  ?? '';
            ?>
                <article class="work-grid__card">

                    <?php if ($image) : ?>
                    <div class="work-grid__card-image">
                        <img
                            src="<?= esc_url($image['url']) ?>"
                            alt="<?= esc_attr($image['alt'] ?: $title) ?>"
                            width="<?= esc_attr($image['width']) ?>"
                            height="<?= esc_attr($image['height']) ?>"
                            loading="lazy"
                        >
                    </div>
                    <?php endif; ?>

                    <div class="work-grid__card-body">
                        <?php if ($type_label) : ?>
                            <span class="work-grid__card-badge"><?= esc_html($type_label) ?></span>
                        <?php endif; ?>

                        <?php if ($title) : ?>
                            <h2 class="work-grid__card-title"><?= esc_html($title) ?></h2>
                        <?php endif; ?>

                        <?php if ($description) : ?>
                            <p class="work-grid__card-description"><?= esc_html($description) ?></p>
                        <?php endif; ?>

                        <?php if ($url) : ?>
                            <a
                                class="work-grid__card-link"
                                href="<?= esc_url($url) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="View <?= esc_attr($title) ?>"
                            >
                                View
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="work-grid"]');
    if (!section) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(section);
})();
</script>
