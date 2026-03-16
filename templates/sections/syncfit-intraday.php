<?php
/**
 * Section: Intraday Metrics Feature Grid
 * Page: SyncFit
 * Description: 2×3 grid of glass cards showcasing intraday metric capabilities.
 * Fields:
 *   - syncfit_intraday_heading (text): Section heading
 *   - syncfit_intraday_subheading (textarea): Section subheading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'syncfit_intraday_heading') ?: 'Intraday Data, Done Right';
$subheading = carbon_get_post_meta($post_id, 'syncfit_intraday_subheading') ?: 'SyncFit pulls minute-by-minute data from Fitbit\'s API — the same detail your Fitbit app shows you — and writes it to Apple Health in the correct format.';

$cards = [
    [
        'icon'        => '👣',
        'name'        => 'Steps',
        'description' => 'Minute-level step counts synced throughout the day, not just daily totals.',
    ],
    [
        'icon'        => '❤️',
        'name'        => 'Heart Rate',
        'description' => 'Continuous BPM readings captured every few seconds and written to Apple Health.',
    ],
    [
        'icon'        => '🩸',
        'name'        => 'Blood Oxygen (SpO2)',
        'description' => 'SpO2 measurements from overnight tracking and on-demand readings.',
    ],
    [
        'icon'        => '🔥',
        'name'        => 'Active Energy',
        'description' => 'Active calorie burn segmented by time of day, not a single end-of-day estimate.',
    ],
    [
        'icon'        => '📍',
        'name'        => 'Distance',
        'description' => 'Intraday distance in kilometers or miles, perfectly matched to your step intervals.',
    ],
    [
        'icon'        => '🏢',
        'name'        => 'Flights Climbed',
        'description' => 'Floor-level elevation data pulled from Fitbit and mapped to Apple Health floors.',
    ],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-intraday {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.syncfit-intraday__header {
    text-align: center;
    max-width: 640px;
    margin: 0 auto var(--space-xxxl);
}

.syncfit-intraday__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0 0 var(--space-lg);
}

.syncfit-intraday__subheading {
    font-size: 17px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
}

.syncfit-intraday__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
    max-width: var(--sf-max-width);
    margin: 0 auto;
}

.syncfit-intraday__card {
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 16px;
    padding: var(--space-xxl);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.4s ease, transform 0.4s ease, border-color 0.2s ease;
}

.syncfit-intraday__card.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.syncfit-intraday__card:hover {
    border-color: rgba(10, 132, 255, 0.3);
}

.syncfit-intraday__card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--accent-dim);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: var(--space-lg);
    line-height: 1;
}

.syncfit-intraday__card-name {
    font-size: 17px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
}

.syncfit-intraday__card-description {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.55;
    margin: 0;
}

@media (min-width: 640px) {
    .syncfit-intraday__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 900px) {
    .syncfit-intraday {
        padding: 100px var(--space-xxl);
    }

    .syncfit-intraday__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-intraday" data-section="syncfit-intraday">
    <div class="syncfit-intraday__header">
        <h2 class="syncfit-intraday__heading"><?= esc_html($heading) ?></h2>
        <p class="syncfit-intraday__subheading"><?= esc_html($subheading) ?></p>
    </div>

    <div class="syncfit-intraday__grid">
        <?php foreach ($cards as $card): ?>
            <div class="syncfit-intraday__card">
                <div class="syncfit-intraday__card-icon" aria-hidden="true"><?= $card['icon'] ?></div>
                <h3 class="syncfit-intraday__card-name"><?= esc_html($card['name']) ?></h3>
                <p class="syncfit-intraday__card-description"><?= esc_html($card['description']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="syncfit-intraday"]');
    if (!section) return;

    const cards = section.querySelectorAll('.syncfit-intraday__card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = Array.from(cards).indexOf(entry.target);
                entry.target.style.transitionDelay = (idx * 60) + 'ms';
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => observer.observe(card));
})();
</script>
