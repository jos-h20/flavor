<?php
/**
 * Section: Blog Hero
 * Page: Blog
 * Description: Compact hero with editable heading and optional subheading deck copy.
 * Fields:
 *   - blog_hero_heading (text): Main heading, e.g. "From the Studio"
 *   - blog_hero_subheading (textarea): Optional deck copy below the heading
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'blog_hero_heading')    ?: 'From the Studio';
$subheading = carbon_get_post_meta($post_id, 'blog_hero_subheading') ?: '';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.blog-hero {
    position: relative;
    width: 100%;
    overflow: hidden;
    background: linear-gradient(
        180deg,
        var(--color-navy-deep) 0%,
        #0d1e38 70%,
        #0e1c30 100%
    );
    padding: var(--spacing-2xl) var(--spacing-md) var(--spacing-xl);
}

.blog-hero__geometry {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    opacity: 0;
    animation: blog-hero-geo-reveal 2s ease 0.4s forwards;
}

@keyframes blog-hero-geo-reveal {
    from { opacity: 0; }
    to   { opacity: 1; }
}

.blog-hero__container {
    position: relative;
    z-index: 10;
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}

.blog-hero__eyebrow {
    display: block;
    font-family: var(--font-body);
    font-weight: 200;
    font-size: 0.7rem;
    letter-spacing: 0.45em;
    text-transform: uppercase;
    color: var(--color-slate-light);
    margin-bottom: var(--spacing-md);
    opacity: 0;
    animation: blog-hero-fade-up 0.9s ease 0.6s forwards;
}

.blog-hero__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(2.4rem, 5.5vw, 4rem);
    color: var(--color-white);
    line-height: 1.15;
    margin-bottom: 0;
    /* opacity: 0 removed — h1 must be visible at first paint for LCP */
    animation: blog-hero-slide-up 0.8s ease 0.15s both;
}

@keyframes blog-hero-slide-up {
    from { transform: translateY(12px); }
    to   { transform: translateY(0); }
}

.blog-hero__subheading {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.9rem, 1.5vw, 1.05rem);
    color: var(--color-white-dim);
    line-height: 1.75;
    max-width: 560px;
    margin-top: var(--spacing-md);
    opacity: 0;
    animation: blog-hero-fade-up 0.9s ease 1s forwards;
}

.blog-hero__rule {
    width: 3rem;
    height: 1px;
    background: var(--color-km-brown);
    margin-top: var(--spacing-lg);
    opacity: 0;
    animation: blog-hero-fade-up 0.9s ease 1.1s forwards;
}

@keyframes blog-hero-fade-up {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (min-width: 768px) {
    .blog-hero {
        padding: var(--spacing-3xl) var(--spacing-lg) var(--spacing-2xl);
    }
}

@media (min-width: 1024px) {
    .blog-hero {
        padding: var(--spacing-3xl) var(--spacing-xl) var(--spacing-2xl);
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="blog-hero" data-section="blog-hero">

    <svg class="blog-hero__geometry" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <line x1="0"    y1="240" x2="1200" y2="240" stroke="var(--color-km-brown)" stroke-width="0.5" opacity="0.2"/>
        <line x1="0"    y1="260" x2="400"  y2="100" stroke="var(--color-km-blue)"  stroke-width="0.5" opacity="0.15"/>
        <line x1="1200" y1="260" x2="800"  y2="100" stroke="var(--color-km-blue)"  stroke-width="0.5" opacity="0.15"/>
        <line x1="400"  y1="100" x2="800"  y2="100" stroke="var(--color-km-brown)" stroke-width="0.5" opacity="0.15"/>
        <ellipse cx="600" cy="220" rx="50" ry="8" fill="none" stroke="var(--color-km-green)" stroke-width="0.5" opacity="0.18"/>
    </svg>

    <div class="blog-hero__container">
        <span class="blog-hero__eyebrow">Journal</span>

        <?php if ($heading) : ?>
            <h1 class="blog-hero__heading"><?php echo esc_html($heading); ?></h1>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="blog-hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <div class="blog-hero__rule" aria-hidden="true"></div>
    </div>

</section>
