<?php
/**
 * Section: How It Works
 * Page: Uncouch
 * Description: 4-step horizontal stepper (vertical on mobile) explaining setup flow.
 * Fields:
 *   - uncouch_hiw_heading (text): Section heading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'uncouch_hiw_heading') ?: 'Up and running in minutes';

$steps = [
    [
        'title'       => 'Download Uncouch',
        'description' => 'Get Uncouch from the App Store — your first week of coaching is free.',
    ],
    [
        'title'       => 'Pick your days and voice',
        'description' => 'Choose the days you want to run and the coaching voice that sounds right to you.',
    ],
    [
        'title'       => 'Allow access when asked',
        'description' => 'Say yes to location and notifications so the coach can measure your distance and remind you on run days.',
    ],
    [
        'title'       => 'Start Week 1',
        'description' => 'Head out the door and let the coach do the rest — one jog and walk interval at a time.',
    ],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.uncouch-hiw {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.uncouch-hiw__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.uncouch-hiw__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.uncouch-hiw__steps {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-xxl);
    max-width: var(--sf-max-width);
    margin: 0 auto;
    position: relative;
}

.uncouch-hiw__step {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: var(--space-lg);
}

.uncouch-hiw__step-number {
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

.uncouch-hiw__step-content {
    flex: 1;
}

.uncouch-hiw__step-title {
    font-size: 17px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
}

.uncouch-hiw__step-description {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.55;
    margin: 0;
}

@media (min-width: 768px) {
    .uncouch-hiw {
        padding: 100px var(--space-xxl);
    }

    .uncouch-hiw__steps {
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        align-items: start;
    }

    .uncouch-hiw__step {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 var(--space-lg);
        position: relative;
    }

    .uncouch-hiw__step:not(:last-child)::after {
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
<section class="uncouch-hiw" data-section="uncouch-hiw">
    <div class="uncouch-hiw__header">
        <h2 class="uncouch-hiw__heading"><?= esc_html($heading) ?></h2>
    </div>

    <div class="uncouch-hiw__steps">
        <?php foreach ($steps as $i => $step): ?>
            <div class="uncouch-hiw__step">
                <div class="uncouch-hiw__step-number" aria-hidden="true"><?= $i + 1 ?></div>
                <div class="uncouch-hiw__step-content">
                    <h3 class="uncouch-hiw__step-title"><?= esc_html($step['title']) ?></h3>
                    <p class="uncouch-hiw__step-description"><?= esc_html($step['description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
