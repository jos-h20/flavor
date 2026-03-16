<?php
/**
 * Section: About Values
 * Page: About
 * Description: Responsive grid of value cards with rotating brand-colour left-border accents.
 * Fields:
 *   - about_values_heading (text): Section heading
 *   - about_values_items (complex): Repeater of value cards
 *       - title (text): Card title
 *       - description (textarea): One-sentence card description
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'about_values_heading') ?: 'What I stand for';
$items   = carbon_get_post_meta($post_id, 'about_values_items') ?: [
    ['title' => 'Simplicity', 'description' => 'Not minimal for aesthetic reasons. Minimal because every unnecessary feature is a cost your users pay.'],
    ['title' => 'Privacy',    'description' => 'Your users didn\'t agree to be the product. I build as if their data is none of my business — because it isn\'t.'],
    ['title' => 'Craft',      'description' => 'The part you can\'t see is usually what matters most. Good architecture doesn\'t announce itself.'],
    ['title' => 'Honesty',    'description' => 'If something\'s going to take longer, I\'ll tell you before it does. If your idea has a flaw, I\'ll say that too.'],
    ['title' => 'Ownership',  'description' => 'You own everything we build together — code, IP, all of it. No lock-in, no licensing surprises, no strings.'],
    ['title' => 'Restraint',  'description' => 'Adding features is easy. Knowing which ones not to build is the skill that separates good software from great software.'],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.about-values {
    background-color: var(--color-bg-alt);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.about-values__container {
    max-width: var(--max-width);
    margin: 0 auto;
}

.about-values__header {
    text-align: center;
    margin-bottom: var(--spacing-2xl);
}

.about-values__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    color: var(--color-navy-deep);
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.about-values.is-visible .about-values__heading {
    opacity: 1;
    transform: translateY(0);
}

.about-values__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-md);
}

@media (min-width: 768px) {
    .about-values__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .about-values__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.about-values__card {
    background: var(--color-bg);
    border-left: 3px solid var(--color-km-blue);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
    border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease, box-shadow var(--transition-base);
}

.about-values__card:nth-child(3n+2) { border-left-color: var(--color-km-brown); }
.about-values__card:nth-child(3n+3) { border-left-color: var(--color-km-green); }

.about-values.is-visible .about-values__card              { opacity: 1; transform: translateY(0); }
.about-values.is-visible .about-values__card:nth-child(1) { transition-delay: 0.1s; }
.about-values.is-visible .about-values__card:nth-child(2) { transition-delay: 0.2s; }
.about-values.is-visible .about-values__card:nth-child(3) { transition-delay: 0.3s; }
.about-values.is-visible .about-values__card:nth-child(4) { transition-delay: 0.4s; }
.about-values.is-visible .about-values__card:nth-child(5) { transition-delay: 0.5s; }
.about-values.is-visible .about-values__card:nth-child(6) { transition-delay: 0.6s; }

.about-values__card:hover {
    box-shadow: var(--shadow-md);
}

.about-values__card-title {
    font-family: var(--font-heading);
    font-weight: 400;
    font-size: 1.3rem;
    color: var(--color-navy-deep);
    margin-bottom: var(--spacing-sm);
}

.about-values__card-description {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.9rem;
    color: var(--color-text);
    line-height: 1.7;
    margin-bottom: 0;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="about-values" data-section="about-values">
    <div class="about-values__container">

        <header class="about-values__header">
            <?php if ($heading) : ?>
                <h2 class="about-values__heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
        </header>

        <?php if ($items) : ?>
            <ul class="about-values__grid">
                <?php foreach ($items as $item) : ?>
                    <li class="about-values__card">
                        <?php if (!empty($item['title'])) : ?>
                            <h3 class="about-values__card-title"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['description'])) : ?>
                            <p class="about-values__card-description"><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function () {
    var section = document.querySelector('[data-section="about-values"]');
    if (!section) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                section.classList.add('is-visible');
                observer.disconnect();
            }
        });
    }, { threshold: 0.15 });

    observer.observe(section);
})();
</script>
