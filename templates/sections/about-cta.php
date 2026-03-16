<?php
/**
 * Section: About CTA
 * Page: About
 * Description: Closing call-to-action with dark navy background, geometric accent, and single primary button.
 * Fields:
 *   - about_cta_heading (text): CTA headline
 *   - about_cta_subheading (textarea): Supporting copy below the headline
 *   - about_cta_url (text): CTA button URL
 *   - about_cta_title (text): CTA button label
 *   - about_cta_target (select): Link target — _self or _blank
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'about_cta_heading')    ?: 'Let\'s build something worth building.';
$subheading = carbon_get_post_meta($post_id, 'about_cta_subheading') ?: 'I take on a small number of projects each year — enough to do each one properly. If you have something in mind, I\'d like to hear about it.';
$cta_url    = carbon_get_post_meta($post_id, 'about_cta_url');
$cta_title  = carbon_get_post_meta($post_id, 'about_cta_title')  ?: 'Start a Conversation';
$cta_target = carbon_get_post_meta($post_id, 'about_cta_target') ?: '_self';
$cta        = $cta_url ? ['url' => $cta_url, 'title' => $cta_title, 'target' => $cta_target] : ['url' => '#', 'title' => $cta_title, 'target' => '_self'];
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.about-cta {
    position: relative;
    overflow: hidden;
    background: linear-gradient(180deg, var(--color-navy-deep) 0%, #0d1e38 100%);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.about-cta__geometry {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.about-cta__container {
    position: relative;
    z-index: 10;
    max-width: var(--max-width-narrow);
    margin: 0 auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-lg);
}

.about-cta__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.8rem, 4vw, 3rem);
    color: var(--color-white);
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.about-cta.is-visible .about-cta__heading {
    opacity: 1;
    transform: translateY(0);
}

.about-cta__subheading {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.9rem, 1.5vw, 1rem);
    color: var(--color-white-dim);
    line-height: 1.8;
    max-width: 480px;
    margin-bottom: 0;
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease 0.15s, transform 0.7s ease 0.15s;
}

.about-cta.is-visible .about-cta__subheading {
    opacity: 1;
    transform: translateY(0);
}

.about-cta__button {
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.78rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-navy-deep);
    background: var(--color-slate-light);
    padding: 0.9rem 2.4rem;
    text-decoration: none;
    border-radius: 1px;
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease 0.3s, transform 0.7s ease 0.3s, background var(--transition-base), color var(--transition-base);
}

.about-cta.is-visible .about-cta__button {
    opacity: 1;
    transform: translateY(0);
}

.about-cta__button:hover {
    background: var(--color-white);
    color: var(--color-navy-deep);
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="about-cta" data-section="about-cta">

    <svg class="about-cta__geometry" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <line x1="100" y1="390" x2="1100" y2="390"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.25"/>
        <line x1="100" y1="390" x2="460" y2="140"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.25"/>
        <line x1="1100" y1="390" x2="740" y2="140"
            stroke="var(--color-km-blue)" stroke-width="0.75" stroke-linecap="round" opacity="0.25"/>
        <line x1="460" y1="140" x2="740" y2="140"
            stroke="var(--color-km-brown)" stroke-width="0.75" stroke-linecap="round" opacity="0.2"/>
        <ellipse cx="600" cy="345" rx="65" ry="10"
            fill="none" stroke="var(--color-km-green)" stroke-width="0.75" opacity="0.2"/>
    </svg>

    <div class="about-cta__container">
        <?php if ($heading) : ?>
            <h2 class="about-cta__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="about-cta__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if ($cta) : ?>
            <a
                href="<?php echo esc_url($cta['url']); ?>"
                class="about-cta__button"
                target="<?php echo esc_attr($cta['target']); ?>"
                <?php echo $cta['target'] === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
            >
                <?php echo esc_html($cta['title']); ?>
            </a>
        <?php endif; ?>
    </div>

</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function () {
    var section = document.querySelector('[data-section="about-cta"]');
    if (!section) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                section.classList.add('is-visible');
                observer.disconnect();
            }
        });
    }, { threshold: 0.2 });

    observer.observe(section);
})();
</script>
