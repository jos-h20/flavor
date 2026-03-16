<?php
/**
 * Section: Pricing
 * Page: SyncFit
 * Description: Two pricing cards — Pro subscription and History Pack one-time purchase.
 * Fields:
 *   - syncfit_pricing_appstore_url (text): App Store URL for Pro CTA button
 */

// ─── Data ────────────────────────────────────────────────────
$post_id   = get_the_ID();
$store_url = carbon_get_post_meta($post_id, 'syncfit_pricing_appstore_url') ?: '#';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-pricing {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.syncfit-pricing__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.syncfit-pricing__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.syncfit-pricing__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
    max-width: 800px;
    margin: 0 auto;
}

.syncfit-pricing__card {
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 20px;
    padding: var(--space-xxl);
    position: relative;
    overflow: hidden;
}

.syncfit-pricing__card--pro {
    border-left: 3px solid var(--accent);
}

.syncfit-pricing__badge {
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

.syncfit-pricing__badge--pro {
    background: var(--accent-dim);
    color: var(--accent);
}

.syncfit-pricing__badge--history {
    background: var(--warning-dim);
    color: var(--warning);
}

.syncfit-pricing__plan-name {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
}

.syncfit-pricing__price {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0 0 var(--space-xs);
    line-height: 1;
}

.syncfit-pricing__price-detail {
    font-size: 14px;
    color: var(--text-tertiary);
    margin: 0 0 var(--space-xxl);
}

.syncfit-pricing__divider {
    height: 1px;
    background: var(--divider);
    margin-bottom: var(--space-xxl);
}

.syncfit-pricing__features {
    list-style: none;
    margin: 0 0 var(--space-xxl);
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}

.syncfit-pricing__feature {
    display: flex;
    align-items: flex-start;
    gap: var(--space-md);
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.4;
}

.syncfit-pricing__feature-check {
    color: var(--success);
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 1px;
}

.syncfit-pricing__cta {
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

.syncfit-pricing__cta:hover {
    opacity: 0.85;
}

.syncfit-pricing__cta:active {
    transform: scale(0.98);
}

.syncfit-pricing__cta--primary {
    background: var(--accent);
    color: #ffffff;
}

.syncfit-pricing__cta--secondary {
    background: var(--surface-2);
    color: var(--text-primary);
    border: 1px solid var(--divider);
}

.syncfit-pricing__note {
    font-size: 13px;
    color: var(--text-tertiary);
    text-align: center;
    margin-top: var(--space-md);
}

@media (min-width: 768px) {
    .syncfit-pricing {
        padding: 100px var(--space-xxl);
    }

    .syncfit-pricing__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-pricing" data-section="syncfit-pricing">
    <div class="syncfit-pricing__header">
        <h2 class="syncfit-pricing__heading">Simple, Transparent Pricing</h2>
    </div>

    <div class="syncfit-pricing__grid">

        <!-- Pro Card -->
        <div class="syncfit-pricing__card syncfit-pricing__card--pro">
            <span class="syncfit-pricing__badge syncfit-pricing__badge--pro">Pro</span>
            <h3 class="syncfit-pricing__plan-name">SyncFit Pro</h3>
            <p class="syncfit-pricing__price">$2.99<span style="font-size: 18px; font-weight: 400; color: var(--text-secondary)">/mo</span></p>
            <p class="syncfit-pricing__price-detail">7-day free trial included</p>
            <div class="syncfit-pricing__divider"></div>
            <ul class="syncfit-pricing__features">
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Automatic background sync — runs daily without opening the app</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Intraday data: steps, heart rate, SpO2, active energy, distance, floors</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>25 health metrics written to Apple Health</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Sleep stages, workouts, and nutrition data</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Cancel anytime — no commitment</span>
                </li>
            </ul>
            <a
                href="<?= esc_url($store_url) ?>"
                class="syncfit-pricing__cta syncfit-pricing__cta--primary"
                target="_blank"
                rel="noopener noreferrer"
            >Start Free Trial</a>
        </div>

        <!-- History Pack Card -->
        <div class="syncfit-pricing__card syncfit-pricing__card--history">
            <span class="syncfit-pricing__badge syncfit-pricing__badge--history">Add-on</span>
            <h3 class="syncfit-pricing__plan-name">History Pack</h3>
            <p class="syncfit-pricing__price">$4.99<span style="font-size: 18px; font-weight: 400; color: var(--text-secondary)"> one-time</span></p>
            <p class="syncfit-pricing__price-detail">Unlock your full Fitbit history</p>
            <div class="syncfit-pricing__divider"></div>
            <ul class="syncfit-pricing__features">
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Backfill up to 1 year of historical Fitbit data</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>All 25 metrics synced historically, not just recent data</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>One-time purchase — yours forever, no subscription</span>
                </li>
                <li class="syncfit-pricing__feature">
                    <span class="syncfit-pricing__feature-check" aria-hidden="true">✓</span>
                    <span>Populates trends in Apple Health, Fitness, and third-party apps</span>
                </li>
            </ul>
            <a
                href="<?= esc_url($store_url) ?>"
                class="syncfit-pricing__cta syncfit-pricing__cta--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >Get History Pack</a>
            <p class="syncfit-pricing__note">Requires active Pro subscription</p>
        </div>

    </div>
</section>
