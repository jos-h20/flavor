<?php
/**
 * Section: Features
 * Page: Uncouch
 * Description: "Everything you need to keep running" — emoji feature grid (1/2/3 col) with staggered reveal.
 * Fields:
 *   - uncouch_features_heading (text): Section heading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'uncouch_features_heading') ?: 'Everything you need to keep running';

$features = [
    [
        'icon'        => '🗣️',
        'title'       => 'A coach who talks you through it',
        'description' => 'Real voice narration calls out every interval — jog now, walk now, halfway, last one — so your eyes and hands stay free. Pick the coaching voice that keeps you moving.',
    ],
    [
        'icon'        => '📅',
        'title'       => 'Runs on your schedule',
        'description' => 'Choose your run days (say Mon / Wed / Fri). Miss one? The plan quietly adapts so you never lose progress or fall behind.',
    ],
    [
        'icon'        => '📱',
        'title'       => 'Keeps going with your phone locked',
        'description' => 'A lock-screen Live Activity shows your current interval and a pause button. Slip your phone in your pocket and just keep running.',
    ],
    [
        'icon'        => '🎧',
        'title'       => 'Your podcasts keep playing',
        'description' => 'Coaching cues duck gently over your music or podcast instead of stopping it. Stay in your show the whole way.',
    ],
    [
        'icon'        => '📍',
        'title'       => 'Distance by GPS',
        'description' => 'See how far you actually went, measured by GPS during your run — no guessing, no extra gear.',
    ],
    [
        'icon'        => '🔔',
        'title'       => 'Gentle reminders',
        'description' => 'A friendly local notification nudges you on your run days, so the next workout never slips your mind.',
    ],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.uncouch-features {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.uncouch-features__header {
    text-align: center;
    margin-bottom: var(--space-xxxl);
}

.uncouch-features__heading {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0;
}

.uncouch-features__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
    max-width: var(--sf-max-width);
    margin: 0 auto;
}

.uncouch-features__card {
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 16px;
    padding: var(--space-xxl);
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.uncouch-features__card.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.uncouch-features__icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--accent-dim);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: var(--space-lg);
    line-height: 1;
}

.uncouch-features__title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-sm);
    line-height: 1.3;
}

.uncouch-features__text {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
}

@media (min-width: 640px) {
    .uncouch-features__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .uncouch-features {
        padding: 100px var(--space-xxl);
    }

    .uncouch-features__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="uncouch-features" data-section="uncouch-features">
    <div class="uncouch-features__header">
        <h2 class="uncouch-features__heading"><?= esc_html($heading) ?></h2>
    </div>

    <div class="uncouch-features__grid">
        <?php foreach ($features as $feature): ?>
            <div class="uncouch-features__card">
                <div class="uncouch-features__icon" aria-hidden="true"><?= $feature['icon'] ?></div>
                <h3 class="uncouch-features__title"><?= esc_html($feature['title']) ?></h3>
                <p class="uncouch-features__text"><?= esc_html($feature['description']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="uncouch-features"]');
    if (!section) return;

    const cards = section.querySelectorAll('.uncouch-features__card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = Array.from(cards).indexOf(entry.target);
                entry.target.style.transitionDelay = (idx * 60) + 'ms';
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    cards.forEach(card => observer.observe(card));
})();
</script>
