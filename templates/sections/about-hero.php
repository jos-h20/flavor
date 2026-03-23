<?php
/**
 * Section: About Hero
 * Page: About
 * Description: Full-width hero with dark navy background, geometric SVG accent, and centered headline.
 * Fields:
 *   - about_hero_heading (text): Main headline (supports <em> for italic accent)
 *   - about_hero_subheading (textarea): 1–2 sentence personal statement
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'about_hero_heading')    ?: 'Software built for people,<br><em>not portfolios.</em>';
$subheading = carbon_get_post_meta($post_id, 'about_hero_subheading') ?: 'Kanso Media is a one-person studio. The person you talk to is the person who builds it — and I take that seriously.';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.about-hero {
    position: relative;
    width: 100%;
    min-height: 60vh;
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
    padding: var(--spacing-3xl) var(--spacing-md);
}

.about-hero__geometry {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    opacity: 0;
    animation: about-hero-geo-reveal 2.5s ease 0.6s forwards;
}

@keyframes about-hero-geo-reveal {
    from { opacity: 0; }
    to   { opacity: 1; }
}

.about-hero__content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: var(--max-width-narrow);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-lg);
}

.about-hero__eyebrow {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.65rem, 1.2vw, 0.75rem);
    letter-spacing: 0.5em;
    text-transform: uppercase;
    color: var(--color-slate-light);
    opacity: 0;
    animation: about-hero-fade-up 1s ease 0.8s forwards;
}

.about-hero__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    color: var(--color-white);
    line-height: 1.2;
    /* no animation — h1 must render in place for LCP and to avoid flicker */
}

.about-hero__heading em {
    font-style: italic;
    color: var(--color-slate-light);
}

.about-hero__subheading {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.9rem, 1.6vw, 1.05rem);
    color: var(--color-white-dim);
    line-height: 1.8;
    max-width: 520px;
    margin-bottom: 0;
    opacity: 0;
    animation: about-hero-fade-up 1s ease 1.2s forwards;
}

@keyframes about-hero-fade-up {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@media (max-width: 767px) {
    .about-hero {
        min-height: 0;
        padding: 4rem var(--spacing-md);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="about-hero" data-section="about-hero">

    <svg class="about-hero__geometry" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <!-- Horizontal baseline -->
        <line x1="150" y1="480" x2="1050" y2="480"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Left diagonal -->
        <line x1="150" y1="480" x2="480" y2="180"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Right diagonal -->
        <line x1="1050" y1="480" x2="720" y2="180"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.3"/>
        <!-- Connecting horizontal at peak -->
        <line x1="480" y1="180" x2="720" y2="180"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.2"/>
        <!-- Subtle center ellipse -->
        <ellipse cx="600" cy="420" rx="70" ry="11"
            fill="none" stroke="var(--color-km-green)" stroke-width="0.75" opacity="0.2"/>
    </svg>

    <div class="about-hero__content">
        <p class="about-hero__eyebrow">About Kanso Media</p>

        <?php if ($heading) : ?>
            <h1 class="about-hero__heading"><?php echo wp_kses($heading, ['em' => [], 'strong' => [], 'br' => []]); ?></h1>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="about-hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>
    </div>

</section>
