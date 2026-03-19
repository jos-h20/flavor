<?php
/**
 * Section: About Founder
 * Page: About
 * Description: Two-column founder profile — photo on one side, name/title/bio on the other.
 * Fields:
 *   - about_founder_name (text): Founder name
 *   - about_founder_title (text): Founder title/role
 *   - about_founder_bio (rich_text): Bio content — allows paragraphs, bold, links
 *   - about_founder_image (image): Founder photo (attachment ID)
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$name    = carbon_get_post_meta($post_id, 'about_founder_name')  ?: 'Josh Overly';
$title   = carbon_get_post_meta($post_id, 'about_founder_title') ?: 'Founder & Developer';
$bio     = carbon_get_post_meta($post_id, 'about_founder_bio')   ?: '<p>I\'ve been writing code since 2016. What started as a hobby became a craft, and the craft became a business when I got tired of watching software get built badly.</p><p>Kanso Media is deliberately small. I work with a handful of clients at a time, which means your project gets my full attention — not a project manager as a go-between, not a junior dev on the hard parts. The person you talk to is the person who builds it.</p><p>The name comes from a Japanese design philosophy: the idea that beauty emerges from removing everything that isn\'t essential. It turns out to be a useful principle for software.</p>';
$image   = flavor_get_image_data(carbon_get_post_meta($post_id, 'about_founder_image'));
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.about-founder {
    background-color: var(--color-bg);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.about-founder__container {
    max-width: var(--max-width);
    margin: 0 auto;
}

.about-founder__inner {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-2xl);
    align-items: center;
}

@media (min-width: 768px) {
    .about-founder__inner {
        grid-template-columns: 220px 1fr;
        gap: var(--spacing-3xl);
    }
}

@media (min-width: 1024px) {
    .about-founder__inner {
        grid-template-columns: 260px 1fr;
    }
}

.about-founder__photo-wrap {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.about-founder.is-visible .about-founder__photo-wrap {
    opacity: 1;
    transform: translateY(0);
}

.about-founder__photo {
    width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    display: block;
}

.about-founder__photo-placeholder {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: var(--color-bg-alt);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
}

.about-founder__photo-placeholder svg {
    width: 64px;
    height: 64px;
    opacity: 0.2;
    color: var(--color-navy-deep);
}

.about-founder__bio-wrap {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.7s ease 0.15s, transform 0.7s ease 0.15s;
}

.about-founder.is-visible .about-founder__bio-wrap {
    opacity: 1;
    transform: translateY(0);
}

.about-founder__name {
    font-family: var(--font-heading);
    font-weight: 400;
    font-size: clamp(1.8rem, 3.5vw, 2.5rem);
    color: var(--color-navy-deep);
    margin-bottom: var(--spacing-xs);
}

.about-founder__title {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.8rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--color-slate);
    margin-bottom: 0;
}

.about-founder__divider {
    width: 36px;
    height: 1px;
    background: var(--color-km-brown);
    margin: var(--spacing-lg) 0;
    opacity: 0.45;
}

.about-founder__bio {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 1rem;
    color: var(--color-text);
    line-height: 1.85;
}

.about-founder__bio p {
    margin-bottom: var(--spacing-md);
}

.about-founder__bio p:last-child {
    margin-bottom: 0;
}

.about-founder__bio a {
    color: var(--color-km-blue);
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color var(--transition-fast);
}

.about-founder__bio a:hover {
    color: var(--color-navy-deep);
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="about-founder" data-section="about-founder">
    <div class="about-founder__container">
        <div class="about-founder__inner">

            <div class="about-founder__photo-wrap">
                <?php if ($image && !empty($image['url'])) : ?>
                    <img
                        class="about-founder__photo"
                        src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt'] ?: $name); ?>"
                        width="<?php echo esc_attr($image['width']); ?>"
                        height="<?php echo esc_attr($image['height']); ?>"
                        loading="lazy"
                    >
                <?php else : ?>
                    <div class="about-founder__photo-placeholder" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <div class="about-founder__bio-wrap">
                <?php if ($name) : ?>
                    <h2 class="about-founder__name"><?php echo esc_html($name); ?></h2>
                <?php endif; ?>
                <?php if ($title) : ?>
                    <p class="about-founder__title"><?php echo esc_html($title); ?></p>
                <?php endif; ?>
                <div class="about-founder__divider" aria-hidden="true"></div>
                <?php if ($bio) : ?>
                    <div class="about-founder__bio"><?php echo wp_kses_post($bio); ?></div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function () {
    var section = document.querySelector('[data-section="about-founder"]');
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
