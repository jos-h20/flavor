<?php
/**
 * Section: Hero
 * Page: SyncFit
 * Description: Full-width hero with ambient glow, app icon, headline, App Store badge, and pricing line.
 * Fields:
 *   - syncfit_hero_icon (image): App icon image
 *   - syncfit_hero_heading (text): Main headline
 *   - syncfit_hero_subtext (textarea): Supporting subtext
 *   - syncfit_hero_appstore_url (text): App Store link URL
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$icon_id    = carbon_get_post_meta($post_id, 'syncfit_hero_icon');
$icon       = $icon_id ? flavor_get_image_data($icon_id) : null;
$heading    = carbon_get_post_meta($post_id, 'syncfit_hero_heading') ?: 'Bridge Your Fitbit Data to Apple Health';
$subtext    = carbon_get_post_meta($post_id, 'syncfit_hero_subtext') ?: 'SyncFit syncs your Fitbit metrics — including intraday data — directly into Apple Health. No shortcuts, no gaps.';
$store_url  = carbon_get_post_meta($post_id, 'syncfit_hero_appstore_url') ?: '#';
$badge_path = get_template_directory_uri() . '/assets/images/app-store-badge.svg';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-hero {
    position: relative;
    overflow: hidden;
    background: var(--bg);
    padding: 100px var(--space-xl) 80px;
    text-align: center;
    font-family: var(--sf-font);
}

.syncfit-hero__blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}

.syncfit-hero__blob--1 {
    width: 500px;
    height: 500px;
    background: rgba(10, 132, 255, 0.18);
    top: -120px;
    left: -100px;
}

.syncfit-hero__blob--2 {
    width: 400px;
    height: 400px;
    background: rgba(10, 132, 255, 0.12);
    bottom: -80px;
    right: -80px;
}

.syncfit-hero__content {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin: 0 auto;
}

.syncfit-hero__icon {
    width: 90px;
    height: 90px;
    border-radius: 22.37%;
    margin: 0 auto var(--space-xl);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--surface-2);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0s;
}

.syncfit-hero__icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.syncfit-hero__icon-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.syncfit-hero__app-name {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-secondary);
    margin-bottom: var(--space-lg);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0.08s;
}

.syncfit-hero__heading {
    font-size: clamp(2rem, 5vw, 2.75rem);
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin: 0 0 var(--space-xl);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0.16s;
}

.syncfit-hero__subtext {
    font-size: 20px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0 0 var(--space-xxl);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0.24s;
}

.syncfit-hero__badge-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: var(--space-lg);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0.32s;
}

.syncfit-hero__badge {
    display: inline-block;
    height: 52px;
}

.syncfit-hero__pricing {
    font-size: 14px;
    color: var(--text-secondary);
    opacity: 0;
    transform: translateY(20px);
    animation: sf-fadein 0.5s ease forwards;
    animation-delay: 0.4s;
}

@keyframes sf-fadein {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (min-width: 768px) {
    .syncfit-hero {
        padding: 120px var(--space-xxl) 100px;
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-hero" data-section="syncfit-hero">
    <div class="syncfit-hero__blob syncfit-hero__blob--1" aria-hidden="true"></div>
    <div class="syncfit-hero__blob syncfit-hero__blob--2" aria-hidden="true"></div>

    <div class="syncfit-hero__content">
        <div class="syncfit-hero__icon">
            <?php if ($icon): ?>
                <img
                    src="<?= esc_url($icon['url']) ?>"
                    alt="<?= esc_attr($icon['alt'] ?: 'SyncFit app icon') ?>"
                    width="<?= esc_attr($icon['width']) ?>"
                    height="<?= esc_attr($icon['height']) ?>"
                    loading="eager"
                >
            <?php else: ?>
                <div class="syncfit-hero__icon-placeholder" aria-hidden="true">
                    <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="54" height="54" rx="12" fill="#1c1c1e"/>
                        <path d="M13 27h5l4-10 6 20 4-14 3 7 4-3h6" stroke="#0a84ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <p class="syncfit-hero__app-name">SyncFit</p>

        <h1 class="syncfit-hero__heading"><?= esc_html($heading) ?></h1>

        <p class="syncfit-hero__subtext"><?= esc_html($subtext) ?></p>

        <div class="syncfit-hero__badge-wrap">
            <a href="<?= esc_url($store_url) ?>" target="_blank" rel="noopener noreferrer" aria-label="Download SyncFit on the App Store">
                <img
                    src="<?= esc_url($badge_path) ?>"
                    alt="Download on the App Store"
                    height="52"
                    class="syncfit-hero__badge"
                    loading="eager"
                >
            </a>
        </div>

        <p class="syncfit-hero__pricing">7-day free trial &middot; $2.99/mo after &middot; History Pack $4.99 one-time</p>
    </div>
</section>
