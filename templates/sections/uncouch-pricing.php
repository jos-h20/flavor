<?php
/**
 * Section: Pricing
 * Page: Uncouch
 * Description: Two cards — free first week and a one-time full-program unlock. No subscription.
 * Fields:
 *   - uncouch_pricing_appstore_url (text): App Store URL for the CTA (blank shows "Coming Soon")
 */

// ─── Data ────────────────────────────────────────────────────
$post_id   = get_the_ID();
$store_url = carbon_get_post_meta($post_id, 'uncouch_pricing_appstore_url');
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.uncouch-pricing {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.uncouch-pricing__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.uncouch-pricing__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.uncouch-pricing__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
    max-width: 800px;
    margin: 0 auto;
}

.uncouch-pricing__card {
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 20px;
    padding: var(--space-xxl);
    position: relative;
    overflow: hidden;
}

.uncouch-pricing__card--full {
    border-left: 3px solid var(--accent);
}

.uncouch-pricing__badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: var(--space-lg);
}

.uncouch-pricing__badge--free {
    background: var(--success-dim);
    color: var(--success);
}

.uncouch-pricing__badge--full {
    background: var(--accent-dim);
    color: var(--accent);
}

.uncouch-pricing__plan-name {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
}

.uncouch-pricing__price {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0 0 var(--space-xs);
    line-height: 1;
}

.uncouch-pricing__price-detail {
    font-size: 14px;
    color: var(--text-tertiary);
    margin: 0 0 var(--space-xxl);
}

.uncouch-pricing__divider {
    height: 1px;
    background: var(--divider);
    margin-bottom: var(--space-xxl);
}

.uncouch-pricing__features {
    list-style: none;
    margin: 0 0 var(--space-xxl);
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}

.uncouch-pricing__feature {
    display: flex;
    align-items: flex-start;
    gap: var(--space-md);
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.4;
}

.uncouch-pricing__feature-check {
    color: var(--success);
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 1px;
}

.uncouch-pricing__cta {
    display: block;
    width: 100%;
    padding: 14px var(--space-xl);
    border-radius: 12px;
    font-size: 17px;
    font-weight: 600;
    font-family: var(--sf-font);
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: opacity 0.2s ease, transform 0.1s ease;
}

.uncouch-pricing__cta:hover {
    opacity: 0.85;
}

.uncouch-pricing__cta:active {
    transform: scale(0.98);
}

.uncouch-pricing__cta--primary {
    background: var(--accent);
    color: #ffffff;
}

.uncouch-pricing__cta--secondary {
    background: var(--surface-2);
    color: var(--text-primary);
    border: 1px solid var(--divider);
}

.uncouch-pricing__cta[disabled] {
    background: var(--surface-2);
    color: var(--text-tertiary);
    border: 1px solid var(--divider);
    cursor: not-allowed;
    opacity: 0.55;
}

.uncouch-pricing__cta[disabled]:hover {
    opacity: 0.55;
}

.uncouch-pricing__cta[disabled]:active {
    transform: none;
}

.uncouch-pricing__note {
    font-size: 13px;
    color: var(--text-tertiary);
    text-align: center;
    margin: var(--space-xl) auto 0;
    max-width: 800px;
}

@media (min-width: 768px) {
    .uncouch-pricing {
        padding: 100px var(--space-xxl);
    }

    .uncouch-pricing__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="uncouch-pricing" data-section="uncouch-pricing">
    <div class="uncouch-pricing__header">
        <h2 class="uncouch-pricing__heading">Start free. Then pay once.</h2>
    </div>

    <div class="uncouch-pricing__grid">

        <!-- Free Card -->
        <div class="uncouch-pricing__card uncouch-pricing__card--free">
            <span class="uncouch-pricing__badge uncouch-pricing__badge--free">Week 1</span>
            <h3 class="uncouch-pricing__plan-name">Your First Week</h3>
            <p class="uncouch-pricing__price">Free</p>
            <p class="uncouch-pricing__price-detail">On us — no payment to get started</p>
            <div class="uncouch-pricing__divider"></div>
            <ul class="uncouch-pricing__features">
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Your entire first week of coaching, completely free</span>
                </li>
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Every feature unlocked — voice coaching, Live Activity, GPS</span>
                </li>
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>See how it feels before you decide — nothing to cancel</span>
                </li>
            </ul>
            <?php if ($store_url): ?>
            <a
                href="<?= esc_url($store_url) ?>"
                class="uncouch-pricing__cta uncouch-pricing__cta--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >Start Free</a>
            <?php else: ?>
            <button class="uncouch-pricing__cta uncouch-pricing__cta--secondary" disabled>Coming Soon</button>
            <?php endif; ?>
        </div>

        <!-- Full Program Card -->
        <div class="uncouch-pricing__card uncouch-pricing__card--full">
            <span class="uncouch-pricing__badge uncouch-pricing__badge--full">One-time</span>
            <h3 class="uncouch-pricing__plan-name">The Full Program</h3>
            <p class="uncouch-pricing__price">$9.99<span style="font-size: 18px; font-weight: 400; color: var(--text-secondary)"> one-time</span></p>
            <p class="uncouch-pricing__price-detail">Unlock everything, all the way to one hour</p>
            <div class="uncouch-pricing__divider"></div>
            <ul class="uncouch-pricing__features">
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>The complete program — from one minute of running up to a full hour</span>
                </li>
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Every coaching voice and feature, kept forever</span>
                </li>
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Pay once — no subscription, ever</span>
                </li>
                <li class="uncouch-pricing__feature">
                    <span class="uncouch-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Family Sharing supported, and easy to restore on your devices</span>
                </li>
            </ul>
            <?php if ($store_url): ?>
            <a
                href="<?= esc_url($store_url) ?>"
                class="uncouch-pricing__cta uncouch-pricing__cta--primary"
                target="_blank"
                rel="noopener noreferrer"
            >Unlock the Full Program</a>
            <?php else: ?>
            <button class="uncouch-pricing__cta uncouch-pricing__cta--primary" disabled>Coming Soon</button>
            <?php endif; ?>
        </div>

    </div>

    <p class="uncouch-pricing__note">Family Sharing supported &middot; Purchases can be restored on your other devices &middot; No subscription, ever.</p>
</section>
