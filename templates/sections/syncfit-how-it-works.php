<?php
/**
 * Section: How It Works
 * Page: SyncFit
 * Description: 4-step horizontal stepper (vertical on mobile) explaining setup flow.
 * Fields:
 *   - syncfit_hiw_heading (text): Section heading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'syncfit_hiw_heading') ?: 'Up and Running in Minutes';

$steps = [
    [
        'title'       => 'Download SyncFit',
        'description' => 'Get SyncFit from the App Store and start your 7-day free trial.',
    ],
    [
        'title'       => 'Connect Fitbit',
        'description' => 'Sign in with your Fitbit account. SyncFit will request read access to your health data.',
    ],
    [
        'title'       => 'Grant Apple Health Access',
        'description' => 'Choose which metrics SyncFit can write to Apple Health. You stay in full control.',
    ],
    [
        'title'       => 'Sync Starts Automatically',
        'description' => 'SyncFit syncs in the background daily. Your data appears in Apple Health and any connected app.',
    ],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-hiw {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.syncfit-hiw__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.syncfit-hiw__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.syncfit-hiw__steps {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-xxl);
    max-width: var(--sf-max-width);
    margin: 0 auto;
    position: relative;
}

.syncfit-hiw__step {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: var(--space-lg);
}

.syncfit-hiw__step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--accent);
    color: #ffffff;
    font-size: 17px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.syncfit-hiw__step-content {
    flex: 1;
}

.syncfit-hiw__step-title {
    font-size: 17px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
}

.syncfit-hiw__step-description {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.55;
    margin: 0;
}

@media (min-width: 768px) {
    .syncfit-hiw {
        padding: 100px var(--space-xxl);
    }

    .syncfit-hiw__steps {
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        align-items: start;
    }

    .syncfit-hiw__step {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 var(--space-lg);
        position: relative;
    }

    .syncfit-hiw__step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 20px;
        left: calc(50% + 24px);
        right: calc(-50% + 24px);
        height: 1px;
        background: var(--divider);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-hiw" data-section="syncfit-hiw">
    <div class="syncfit-hiw__header">
        <h2 class="syncfit-hiw__heading"><?= esc_html($heading) ?></h2>
    </div>

    <div class="syncfit-hiw__steps">
        <?php foreach ($steps as $i => $step): ?>
            <div class="syncfit-hiw__step">
                <div class="syncfit-hiw__step-number" aria-hidden="true"><?= $i + 1 ?></div>
                <div class="syncfit-hiw__step-content">
                    <h3 class="syncfit-hiw__step-title"><?= esc_html($step['title']) ?></h3>
                    <p class="syncfit-hiw__step-description"><?= esc_html($step['description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
