<?php
/**
 * Section: Apps Grid
 * Page: Apps
 * Description: Card grid of app listings. Each card shows icon, name, tagline, and a link to the app page.
 * Fields:
 *   - apps_grid_items (complex): Repeater of app entries
 *     - icon (image): App icon (attachment ID)
 *     - name (text): App name
 *     - tagline (textarea): One-line description
 *     - url (text): Link to the app's page
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$items   = carbon_get_post_meta($post_id, 'apps_grid_items');

$fallback_items = [
    [
        'icon'    => '',
        'name'    => 'SyncFit',
        'tagline' => 'Sync your Fitbit metrics — including intraday data — directly into Apple Health. No shortcuts, no gaps.',
        'url'     => '/syncfit',
    ],
];

$items = $items ?: $fallback_items;
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.apps-grid {
    background: var(--color-bg-alt);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.apps-grid__container {
    max-width: var(--max-width);
    margin: 0 auto;
}

.apps-grid__items {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-lg);
}

@media (min-width: 640px) {
    .apps-grid__items {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .apps-grid__items {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* ── Card ─────────────────────────────────────────────────── */

.apps-grid__card {
    background: var(--color-navy-mid);
    border: 1px solid rgba(168, 205, 232, 0.1);
    border-radius: var(--radius-md);
    padding: var(--spacing-lg);
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
    text-decoration: none;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease, box-shadow var(--transition-base), border-color var(--transition-base);
}

.apps-grid__card:nth-child(1) { transition-delay: 0ms; }
.apps-grid__card:nth-child(2) { transition-delay: 80ms; }
.apps-grid__card:nth-child(3) { transition-delay: 160ms; }
.apps-grid__card:nth-child(4) { transition-delay: 240ms; }
.apps-grid__card:nth-child(5) { transition-delay: 320ms; }
.apps-grid__card:nth-child(6) { transition-delay: 400ms; }

.apps-grid.is-visible .apps-grid__card {
    opacity: 1;
    transform: translateY(0);
}

.apps-grid__card:hover {
    box-shadow: var(--shadow-md);
    border-color: rgba(168, 205, 232, 0.25);
}

/* ── Icon ─────────────────────────────────────────────────── */

.apps-grid__card-icon {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--color-navy-light);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.apps-grid__card-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.apps-grid__card-icon-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-slate);
}

/* ── Body ─────────────────────────────────────────────────── */

.apps-grid__card-body {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xs);
    flex: 1;
}

.apps-grid__card-name {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.25rem, 2vw, 1.5rem);
    color: var(--color-white);
    line-height: 1.2;
}

.apps-grid__card-tagline {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: 0.9rem;
    color: var(--color-white-dim);
    line-height: 1.6;
    flex: 1;
}

/* ── Link ─────────────────────────────────────────────────── */

.apps-grid__card-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.35em;
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--color-slate-light);
    margin-top: var(--spacing-sm);
    transition: gap var(--transition-fast), color var(--transition-fast);
}

.apps-grid__card:hover .apps-grid__card-cta {
    gap: 0.6em;
    color: var(--color-white);
}

.apps-grid__card-cta svg {
    width: 0.85em;
    height: 0.85em;
    flex-shrink: 0;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="apps-grid" data-section="apps-grid">
    <div class="apps-grid__container">
        <div class="apps-grid__items">
            <?php foreach ($items as $item) :
                $icon_id = $item['icon'] ?? '';
                $icon    = $icon_id ? flavor_get_image_data($icon_id) : null;
                $name    = $item['name']    ?? '';
                $tagline = $item['tagline'] ?? '';
                $url     = $item['url']     ?? '';
            ?>
                <a
                    class="apps-grid__card"
                    href="<?= esc_url($url) ?>"
                    aria-label="View <?= esc_attr($name) ?>"
                >
                    <div class="apps-grid__card-icon">
                        <?php if ($icon) : ?>
                            <img
                                src="<?= esc_url($icon['url']) ?>"
                                alt="<?= esc_attr($icon['alt'] ?: $name . ' icon') ?>"
                                width="<?= esc_attr($icon['width']) ?>"
                                height="<?= esc_attr($icon['height']) ?>"
                                loading="lazy"
                            >
                        <?php else : ?>
                            <div class="apps-grid__card-icon-placeholder" aria-hidden="true">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="5" y="2" width="14" height="20" rx="2"/>
                                    <line x1="12" y1="18" x2="12" y2="18.01"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="apps-grid__card-body">
                        <?php if ($name) : ?>
                            <h2 class="apps-grid__card-name"><?= esc_html($name) ?></h2>
                        <?php endif; ?>

                        <?php if ($tagline) : ?>
                            <p class="apps-grid__card-tagline"><?= esc_html($tagline) ?></p>
                        <?php endif; ?>

                        <span class="apps-grid__card-cta" aria-hidden="true">
                            View App
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="apps-grid"]');
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
