<?php
/**
 * Section: Hero
 * Page: Uncouch
 * Description: Full-width hero with ambient glow, app icon, headline, tagline, App Store call-to-action, and pricing line.
 * Fields:
 *   - uncouch_hero_icon (image): App icon image
 *   - uncouch_hero_heading (text): Tagline / main headline
 *   - uncouch_hero_subtext (textarea): Supporting intro copy
 *   - uncouch_hero_appstore_url (text): App Store link URL (blank shows "Coming Soon")
 */

// ─── Data ────────────────────────────────────────────────────
$post_id   = get_the_ID();
$icon_id   = carbon_get_post_meta($post_id, 'uncouch_hero_icon');
$icon      = $icon_id ? flavor_get_image_data($icon_id) : null;
$heading   = carbon_get_post_meta($post_id, 'uncouch_hero_heading') ?: 'From one minute to one hour — a running coach in your pocket.';
$subtext   = carbon_get_post_meta($post_id, 'uncouch_hero_subtext') ?: 'A real-sounding coach talks you through every jog and walk interval, so you never have to wonder what to do next — just lace up and go.';
$store_url = carbon_get_post_meta($post_id, 'uncouch_hero_appstore_url');
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.uncouch-hero {
    position: relative;
    overflow: hidden;
    background: var(--bg);
    padding: 5rem var(--space-xl) 4rem;
    text-align: center;
    font-family: var(--sf-font);
}

.uncouch-hero__blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}

.uncouch-hero__blob--1 {
    width: 500px;
    height: 500px;
    background: rgba(255, 107, 84, 0.18);
    top: -120px;
    left: -100px;
}

.uncouch-hero__blob--2 {
    width: 400px;
    height: 400px;
    background: rgba(255, 107, 84, 0.12);
    bottom: -80px;
    right: -80px;
}

.uncouch-hero__content {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin: 0 auto;
}

.uncouch-hero__icon {
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
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0s;
}

.uncouch-hero__icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.uncouch-hero__icon-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.uncouch-hero__app-name {
    font-size: clamp(2rem, 5vw, 2.75rem);
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin: 0 0 var(--space-lg);
    /* no animation — h1 must render in place for LCP and to avoid flicker */
}

.uncouch-hero__heading {
    font-size: clamp(1.25rem, 3vw, 1.5rem);
    font-weight: 600;
    color: var(--text-secondary);
    line-height: 1.3;
    margin: 0 0 var(--space-xl);
    opacity: 0;
    transform: translateY(20px);
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0.08s;
}

.uncouch-hero__subtext {
    font-size: 20px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0 0 var(--space-xxl);
    opacity: 0;
    transform: translateY(20px);
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0.16s;
}

.uncouch-hero__badge-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: var(--space-lg);
    opacity: 0;
    transform: translateY(20px);
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0.24s;
}

.uncouch-hero__badge {
    display: inline-block;
    height: 52px;
}

.uncouch-hero__pricing {
    font-size: 14px;
    color: var(--text-secondary);
    opacity: 0;
    transform: translateY(20px);
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0.32s;
}

.uncouch-hero__requirements {
    font-size: 13px;
    color: var(--text-tertiary);
    margin: var(--space-sm) 0 0;
    opacity: 0;
    transform: translateY(20px);
    animation: uncouch-fadein 0.5s ease forwards;
    animation-delay: 0.4s;
}

.uncouch-hero__coming-soon {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 99px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    font-size: 15px;
    font-weight: 500;
    color: var(--text-secondary);
    font-family: ui-monospace, 'SF Mono', Menlo, monospace;
    letter-spacing: 0.02em;
}

@keyframes uncouch-fadein {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (min-width: 768px) {
    .uncouch-hero {
        padding: 120px var(--space-xxl) 100px;
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="uncouch-hero" data-section="uncouch-hero">
    <div class="uncouch-hero__blob uncouch-hero__blob--1" aria-hidden="true"></div>
    <div class="uncouch-hero__blob uncouch-hero__blob--2" aria-hidden="true"></div>

    <div class="uncouch-hero__content">
        <div class="uncouch-hero__icon">
            <?php if ($icon): ?>
                <img
                    src="<?= esc_url($icon['url']) ?>"
                    alt="<?= esc_attr($icon['alt'] ?: 'Uncouch app icon') ?>"
                    width="<?= esc_attr($icon['width']) ?>"
                    height="<?= esc_attr($icon['height']) ?>"
                    loading="eager"
                >
            <?php else: ?>
                <div class="uncouch-hero__icon-placeholder" aria-hidden="true">
                    <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="54" height="54" rx="12" fill="#1c1c1e"/>
                        <circle cx="33" cy="15" r="3.5" fill="#ff6b54"/>
                        <path d="M15 40l7-8 5 4 4-9 5 5 4-1" stroke="#ff6b54" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <h1 class="uncouch-hero__app-name">Uncouch</h1>

        <p class="uncouch-hero__heading"><?= esc_html($heading) ?></p>

        <p class="uncouch-hero__subtext"><?= esc_html($subtext) ?></p>

        <div class="uncouch-hero__badge-wrap">
            <?php if ($store_url): ?>
                <a href="<?= esc_url($store_url) ?>" target="_blank" rel="noopener noreferrer" aria-label="Download Uncouch on the App Store" class="uncouch-hero__badge">
                    <svg width="156" height="52" viewBox="0 0 156 52" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Download on the App Store">
                        <rect width="156" height="52" rx="10" fill="#000"/>
                        <rect x="0.5" y="0.5" width="155" height="51" rx="9.5" stroke="#fff" stroke-opacity="0.4"/>
                        <text x="50" y="19" font-family="-apple-system, 'SF Pro Text', sans-serif" font-size="10" fill="#fff" opacity="0.85" letter-spacing="0.3">Download on the</text>
                        <text x="50" y="37" font-family="-apple-system, 'SF Pro Display', sans-serif" font-size="20" font-weight="600" fill="#fff" letter-spacing="-0.3">App Store</text>
                        <path d="M26 16.5c2.5-3.1 6.2-3.5 6.2-3.5s.6 3.5-1.9 6.3c-2.7 3-5.7 2.5-5.7 2.5s-.6-3.1 1.4-5.3zm-1.2 6.5c1.4 0 4-.8 5.8-.8 1.9 0 4.9 1 4.9 1S33 26.9 31 29.5c-2 2.7-4.1 5.5-6.6 5.5-2.4 0-3-.9-4.5-.9-1.5 0-3.2.9-4.5.9-2.3 0-5.8-5.4-5.8-5.4S12 26 14.5 24.3c2.5-1.6 4.7-1.3 5.8-1.3z" fill="#fff"/>
                    </svg>
                </a>
            <?php else: ?>
                <span class="uncouch-hero__coming-soon">Coming Soon to the App Store</span>
            <?php endif; ?>
        </div>

        <p class="uncouch-hero__pricing">Your first week is free &middot; then a one-time $9.99 &middot; no subscription, ever</p>

        <p class="uncouch-hero__requirements">Requires iPhone &middot; iOS 17 or later</p>
    </div>
</section>
