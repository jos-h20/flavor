<?php
/**
 * Section: Work Hero
 * Page: Our Work
 * Description: Dark navy hero with geometric SVG accent, eyebrow label, heading, and subheading.
 * Fields:
 *   - work_hero_heading (text): Main headline
 *   - work_hero_subheading (textarea): Supporting copy below the headline
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'work_hero_heading')    ?: 'Apps &amp; extensions,<br><em>built with care.</em>';
$subheading = carbon_get_post_meta($post_id, 'work_hero_subheading') ?: 'Small, focused tools that do one thing well. Each one is something I built because I wanted it to exist.';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.work-hero {
    position: relative;
    width: 100%;
    min-height: 45vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(
        180deg,
        var(--color-navy-deep) 0%,
        #0d1e38 60%,
        #0e1c30 100%
    );
    padding: var(--spacing-2xl) var(--spacing-md);
}

.work-hero__geometry {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    opacity: 0;
    animation: work-hero-geo-reveal 2.5s ease 0.6s forwards;
}

@keyframes work-hero-geo-reveal {
    from { opacity: 0; }
    to   { opacity: 1; }
}

.work-hero__content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: var(--max-width-narrow);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-lg);
}

.work-hero__eyebrow {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.65rem, 1.2vw, 0.75rem);
    letter-spacing: 0.5em;
    text-transform: uppercase;
    color: var(--color-slate-light);
    opacity: 0;
    animation: work-hero-fade-up 1s ease 0.8s forwards;
}

.work-hero__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    color: var(--color-white);
    line-height: 1.2;
    /* opacity: 0 removed — h1 must be visible at first paint for LCP */
    animation: work-hero-slide-up 0.8s ease 0.15s both;
}

@keyframes work-hero-slide-up {
    from { transform: translateY(14px); }
    to   { transform: translateY(0); }
}

.work-hero__heading em {
    font-style: italic;
    color: var(--color-slate-light);
}

.work-hero__subheading {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.9rem, 1.6vw, 1.05rem);
    color: var(--color-white-dim);
    line-height: 1.8;
    max-width: 520px;
    margin-bottom: 0;
    opacity: 0;
    animation: work-hero-fade-up 1s ease 1.2s forwards;
}

@keyframes work-hero-fade-up {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="work-hero" data-section="work-hero">

    <svg class="work-hero__geometry" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <!-- Horizontal baseline -->
        <line x1="150" y1="400" x2="1050" y2="400"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Left diagonal -->
        <line x1="150" y1="400" x2="460" y2="130"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Right diagonal -->
        <line x1="1050" y1="400" x2="740" y2="130"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Connecting horizontal at peak -->
        <line x1="460" y1="130" x2="740" y2="130"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.2"/>
        <!-- Subtle center ellipse -->
        <ellipse cx="600" cy="358" rx="65" ry="10"
            fill="none" stroke="var(--color-km-green)" stroke-width="0.75" opacity="0.2"/>
    </svg>

    <div class="work-hero__content">
        <p class="work-hero__eyebrow">Selected Work</p>

        <?php if ($heading) : ?>
            <h1 class="work-hero__heading"><?php echo wp_kses($heading, ['em' => [], 'strong' => [], 'br' => []]); ?></h1>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="work-hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>
    </div>

</section>
