<?php
/**
 * Section: Hero
 * Description: Full-width hero banner with background image, heading, subheading, and CTA.
 * Fields:
 *   - heading (text): Main hero headline
 *   - subheading (textarea): Supporting text below the heading
 *   - background_image (image): Full-width background image
 *   - cta_url (text): CTA button URL
 *   - cta_title (text): CTA button text
 *   - cta_target (select): Link target — _self or _blank
 *   - style (select): Visual variant — default, dark, or minimal
 */

// --- Data ---
$heading    = $section_data['heading'] ?? '';
$subheading = $section_data['subheading'] ?? '';
$bg_image   = flavor_get_image_data($section_data['background_image'] ?? 0);
$style      = $section_data['style'] ?: 'default';

$cta_url    = $section_data['cta_url'] ?? '';
$cta_title  = $section_data['cta_title'] ?? '';
$cta_target = $section_data['cta_target'] ?? '_self';
$cta        = $cta_url ? ['url' => $cta_url, 'title' => $cta_title, 'target' => $cta_target] : null;

$bg_style = $bg_image ? 'background-image: url(' . esc_url($bg_image['url']) . ')' : '';
?>

<!-- --- Styles --- -->
<style>
.hero {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    padding: var(--spacing-3xl) var(--spacing-md);
    background-color: var(--color-bg-dark);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    z-index: 1;
}

.hero__content {
    position: relative;
    z-index: 2;
    max-width: var(--max-width-narrow);
    text-align: center;
}

.hero__heading {
    font-family: var(--font-heading);
    font-size: clamp(2.25rem, 6vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    color: var(--color-text-inverted);
    margin-bottom: var(--spacing-md);
}

.hero__subheading {
    font-size: clamp(1rem, 2vw, 1.25rem);
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: var(--spacing-lg);
}

.hero__cta {
    display: inline-block;
    padding: 0.875rem 2rem;
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-text-inverted);
    background-color: var(--color-primary);
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: background-color var(--transition-fast), transform var(--transition-fast);
}

.hero__cta:hover {
    background-color: var(--color-primary-dark);
    transform: translateY(-1px);
    color: var(--color-text-inverted);
}

/* --- Style: Dark --- */

.hero--dark {
    background-color: var(--color-bg-dark);
}

.hero--dark::before {
    background: rgba(0, 0, 0, 0.65);
}

/* --- Style: Minimal --- */

.hero--minimal {
    min-height: 60vh;
    background-color: var(--color-bg);
}

.hero--minimal::before {
    display: none;
}

.hero--minimal .hero__heading {
    color: var(--color-text);
}

.hero--minimal .hero__subheading {
    color: var(--color-text-light);
}

.hero--minimal .hero__cta {
    color: var(--color-primary);
    background-color: transparent;
    border: 2px solid var(--color-primary);
}

.hero--minimal .hero__cta:hover {
    background-color: var(--color-primary);
    color: var(--color-text-inverted);
}

/* --- Responsive --- */

@media (min-width: 768px) {
    .hero {
        min-height: 85vh;
        padding: var(--spacing-3xl) var(--spacing-lg);
    }
}

@media (min-width: 1024px) {
    .hero {
        min-height: 90vh;
        padding: var(--spacing-3xl) var(--spacing-xl);
    }

    .hero__subheading {
        max-width: 36rem;
        margin-left: auto;
        margin-right: auto;
    }
}
</style>

<!-- --- Markup --- -->
<section class="hero hero--<?php echo esc_attr($style); ?>" data-section="hero" style="<?php echo esc_attr($bg_style); ?>">
    <div class="hero__content">
        <?php if ($heading) : ?>
            <h1 class="hero__heading"><?php echo esc_html($heading); ?></h1>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if ($cta) : ?>
            <a
                class="hero__cta"
                href="<?php echo esc_url($cta['url']); ?>"
                <?php echo $cta['target'] === '_blank' ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
            >
                <?php echo esc_html($cta['title']); ?>
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- --- Script --- -->
<script>
(function () {
    var section = document.querySelector('[data-section="hero"]');
    if (!section) return;

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    var ticking = false;

    function updateParallax() {
        var rect = section.getBoundingClientRect();
        var scrolled = -rect.top;
        var rate = scrolled * 0.3;
        section.style.backgroundPositionY = rate + 'px';
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }, { passive: true });
})();
</script>
