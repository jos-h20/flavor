<?php
/**
 * Section: Privacy
 * Page: SyncFit
 * Description: Single glass card communicating privacy commitment and data handling.
 * Fields:
 *   - syncfit_privacy_heading (text): Heading
 *   - syncfit_privacy_body (textarea): Body copy
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'syncfit_privacy_heading') ?: 'Your Data Stays Yours';
$body    = carbon_get_post_meta($post_id, 'syncfit_privacy_body') ?: 'SyncFit connects directly to Fitbit\'s official API using OAuth. Your Fitbit credentials are never stored by SyncFit — authentication is handled entirely by Fitbit. Health data is written locally to Apple Health on your device and never transmitted to our servers. No ads, no data brokering, no tracking.';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-privacy {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.syncfit-privacy__card {
    max-width: 700px;
    margin: 0 auto;
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 20px;
    padding: var(--space-xxxl) var(--space-xxl);
    text-align: center;
}

.syncfit-privacy__icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: var(--success-dim);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto var(--space-xl);
    line-height: 1;
}

.syncfit-privacy__heading {
    font-size: 22px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-lg);
    letter-spacing: -0.01em;
}

.syncfit-privacy__body {
    font-size: 16px;
    color: var(--text-secondary);
    line-height: 1.65;
    margin: 0 0 var(--space-xxl);
}

.syncfit-privacy__chip {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    padding: 6px 14px;
    border-radius: 99px;
    background: var(--success-dim);
    color: var(--success);
    font-size: 13px;
    font-weight: 600;
}

@media (min-width: 768px) {
    .syncfit-privacy {
        padding: 100px var(--space-xxl);
    }

    .syncfit-privacy__card {
        padding: var(--space-xxxl) 56px;
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-privacy" data-section="syncfit-privacy">
    <div class="syncfit-privacy__card">
        <div class="syncfit-privacy__icon" aria-hidden="true">🔒</div>
        <h2 class="syncfit-privacy__heading"><?= esc_html($heading) ?></h2>
        <p class="syncfit-privacy__body"><?= esc_html($body) ?></p>
        <span class="syncfit-privacy__chip">
            <span aria-hidden="true">✓</span>
            Requires Fitbit account &amp; Apple Health access
        </span>
    </div>
</section>
