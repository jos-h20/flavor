<?php
/**
 * Section: About Approach
 * Page: About
 * Description: Dark navy numbered process steps showing how a client engagement works.
 * Fields:
 *   - about_approach_heading (text): Section heading
 *   - about_approach_steps (complex): Repeater of process steps
 *       - title (text): Step title
 *       - description (textarea): Step description
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'about_approach_heading') ?: 'How a project actually works';
$steps   = carbon_get_post_meta($post_id, 'about_approach_steps') ?: [
    ['title' => 'Discovery', 'description' => 'We talk before I write a single line of code. I want to understand the real problem — not just the requirements document.'],
    ['title' => 'Proposal',  'description' => 'A clear scope, timeline, and cost. You know exactly what you\'re getting before we start. No vague estimates, no hidden assumptions.'],
    ['title' => 'Build',     'description' => 'You see progress as it happens. Regular check-ins, working software early, and a direct line to me throughout.'],
    ['title' => 'Launch',    'description' => 'Careful deployment, thorough testing, and a handover that makes sense. I\'m still available after go-live, not just before it.'],
    ['title' => 'After',     'description' => 'Bugs get fixed. Questions get answered. If something needs to change six months from now, I\'m a message away.'],
];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.about-approach {
    background: linear-gradient(180deg, #0e1c30 0%, var(--color-navy-deep) 100%);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.about-approach__container {
    max-width: 720px;
    margin: 0 auto;
}

.about-approach__header {
    text-align: center;
    margin-bottom: var(--spacing-2xl);
}

.about-approach__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    color: var(--color-white);
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.about-approach.is-visible .about-approach__heading {
    opacity: 1;
    transform: translateY(0);
}

.about-approach__steps {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xl);
}

.about-approach__step {
    display: grid;
    grid-template-columns: 3.5rem 1fr;
    gap: var(--spacing-lg);
    align-items: start;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.about-approach.is-visible .about-approach__step              { opacity: 1; transform: translateY(0); }
.about-approach.is-visible .about-approach__step:nth-child(1) { transition-delay: 0.1s; }
.about-approach.is-visible .about-approach__step:nth-child(2) { transition-delay: 0.2s; }
.about-approach.is-visible .about-approach__step:nth-child(3) { transition-delay: 0.3s; }
.about-approach.is-visible .about-approach__step:nth-child(4) { transition-delay: 0.4s; }
.about-approach.is-visible .about-approach__step:nth-child(5) { transition-delay: 0.5s; }

.about-approach__step-number {
    font-family: var(--font-heading);
    font-weight: 200;
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    color: var(--color-slate-light);
    line-height: 1;
    text-align: right;
    opacity: 0.45;
    padding-top: 0.1rem;
}

.about-approach__step-body {
    padding-top: 0.5rem;
    border-top: 1px solid rgba(232, 240, 248, 0.1);
}

.about-approach__step-title {
    font-family: var(--font-heading);
    font-weight: 400;
    font-size: clamp(1.2rem, 2.5vw, 1.6rem);
    color: var(--color-white);
    margin-bottom: var(--spacing-sm);
}

.about-approach__step-description {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.95rem;
    color: var(--color-white-dim);
    line-height: 1.8;
    margin-bottom: 0;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="about-approach" data-section="about-approach">
    <div class="about-approach__container">

        <header class="about-approach__header">
            <?php if ($heading) : ?>
                <h2 class="about-approach__heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
        </header>

        <?php if ($steps) : ?>
            <ol class="about-approach__steps">
                <?php foreach ($steps as $i => $step) : ?>
                    <li class="about-approach__step">
                        <span class="about-approach__step-number" aria-hidden="true">
                            <?php echo esc_html(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?>
                        </span>
                        <div class="about-approach__step-body">
                            <?php if (!empty($step['title'])) : ?>
                                <h3 class="about-approach__step-title"><?php echo esc_html($step['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($step['description'])) : ?>
                                <p class="about-approach__step-description"><?php echo esc_html($step['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>

    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function () {
    var section = document.querySelector('[data-section="about-approach"]');
    if (!section) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                section.classList.add('is-visible');
                observer.disconnect();
            }
        });
    }, { threshold: 0.1 });

    observer.observe(section);
})();
</script>
