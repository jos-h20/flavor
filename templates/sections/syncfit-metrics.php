<?php
/**
 * Section: All Metrics
 * Page: SyncFit
 * Description: All 25 supported health metrics grouped into 6 categories in a 2-col grid.
 * Fields:
 *   - syncfit_metrics_heading (text): Section heading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'syncfit_metrics_heading') ?: '25 Health Metrics Supported';

$categories = [
    [
        'icon'    => '🏃',
        'name'    => 'Activity',
        'metrics' => [
            ['icon' => '👣', 'name' => 'Steps'],
            ['icon' => '📍', 'name' => 'Distance'],
            ['icon' => '🏢', 'name' => 'Flights Climbed'],
            ['icon' => '⏱️', 'name' => 'Active Minutes'],
            ['icon' => '🚶', 'name' => 'Sedentary Minutes'],
        ],
    ],
    [
        'icon'    => '🔥',
        'name'    => 'Energy',
        'metrics' => [
            ['icon' => '⚡', 'name' => 'Active Energy Burned'],
            ['icon' => '🍽️', 'name' => 'Resting Energy (BMR)'],
        ],
    ],
    [
        'icon'    => '❤️',
        'name'    => 'Vitals',
        'metrics' => [
            ['icon' => '❤️', 'name' => 'Heart Rate (Intraday)'],
            ['icon' => '💙', 'name' => 'Resting Heart Rate'],
            ['icon' => '🩸', 'name' => 'Blood Oxygen (SpO2)'],
            ['icon' => '🫁', 'name' => 'Breathing Rate'],
            ['icon' => '💓', 'name' => 'Heart Rate Variability (HRV)'],
            ['icon' => '🌡️', 'name' => 'Skin Temperature'],
        ],
    ],
    [
        'icon'    => '💪',
        'name'    => 'Workouts',
        'metrics' => [
            ['icon' => '🏋️', 'name' => 'Workout Sessions'],
            ['icon' => '⏰', 'name' => 'Workout Duration'],
            ['icon' => '🔥', 'name' => 'Workout Calories'],
            ['icon' => '📏', 'name' => 'Workout Distance'],
        ],
    ],
    [
        'icon'    => '😴',
        'name'    => 'Sleep',
        'metrics' => [
            ['icon' => '🌙', 'name' => 'Time Asleep'],
            ['icon' => '💤', 'name' => 'Sleep Stages (REM, Light, Deep)'],
            ['icon' => '🛌', 'name' => 'Time in Bed'],
            ['icon' => '⭐', 'name' => 'Sleep Score'],
        ],
    ],
    [
        'icon'    => '🥗',
        'name'    => 'Nutrition & Body',
        'metrics' => [
            ['icon' => '💧', 'name' => 'Water Intake'],
            ['icon' => '🍎', 'name' => 'Calories Consumed'],
            ['icon' => '⚖️', 'name' => 'Body Weight'],
            ['icon' => '📊', 'name' => 'Body Fat Percentage'],
            ['icon' => '📐', 'name' => 'BMI'],
        ],
    ],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.syncfit-metrics {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.syncfit-metrics__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.syncfit-metrics__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.syncfit-metrics__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
    max-width: var(--sf-max-width);
    margin: 0 auto;
}

.syncfit-metrics__category {
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 16px;
    padding: var(--space-xxl);
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.syncfit-metrics__category.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.syncfit-metrics__category-header {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    margin-bottom: var(--space-xl);
}

.syncfit-metrics__category-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--accent-dim);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.syncfit-metrics__category-name {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.syncfit-metrics__metric-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.syncfit-metrics__metric {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md) 0;
    font-size: 15px;
    color: var(--text-secondary);
}

.syncfit-metrics__metric:not(:last-child) {
    border-bottom: 1px solid var(--divider);
}

.syncfit-metrics__metric-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.syncfit-metrics__metric-name {
    color: var(--text-secondary);
    line-height: 1.3;
}

@media (min-width: 768px) {
    .syncfit-metrics {
        padding: 100px var(--space-xxl);
    }

    .syncfit-metrics__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="syncfit-metrics" data-section="syncfit-metrics">
    <div class="syncfit-metrics__header">
        <h2 class="syncfit-metrics__heading"><?= esc_html($heading) ?></h2>
    </div>

    <div class="syncfit-metrics__grid">
        <?php foreach ($categories as $category): ?>
            <div class="syncfit-metrics__category">
                <div class="syncfit-metrics__category-header">
                    <div class="syncfit-metrics__category-icon" aria-hidden="true"><?= $category['icon'] ?></div>
                    <h3 class="syncfit-metrics__category-name"><?= esc_html($category['name']) ?></h3>
                </div>
                <ul class="syncfit-metrics__metric-list">
                    <?php foreach ($category['metrics'] as $metric): ?>
                        <li class="syncfit-metrics__metric">
                            <div class="syncfit-metrics__metric-icon" aria-hidden="true"><?= $metric['icon'] ?></div>
                            <span class="syncfit-metrics__metric-name"><?= esc_html($metric['name']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="syncfit-metrics"]');
    if (!section) return;

    const categories = section.querySelectorAll('.syncfit-metrics__category');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = Array.from(categories).indexOf(entry.target);
                entry.target.style.transitionDelay = (idx * 60) + 'ms';
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    categories.forEach(cat => observer.observe(cat));
})();
</script>
