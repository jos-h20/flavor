<?php
/**
 * Section: Home Hero
 * Page: Home
 * Description: Full-viewport hero with animated starfield, KM geometry background, and CTA buttons.
 * Fields:
 *   - home_hero_tagline_1 (text): First tagline item (e.g. "iOS Apps")
 *   - home_hero_tagline_2 (text): Second tagline item (e.g. "AI-Powered")
 *   - home_hero_tagline_3 (text): Third tagline item (e.g. "Contract Work")
 *   - home_hero_headline (text): Main hero headline (supports <em> via rich text — output raw)
 *   - home_hero_sub (textarea): Supporting paragraph below the headline
 *   - home_hero_cta_primary_url (text): Primary CTA button URL
 *   - home_hero_cta_primary_title (text): Primary CTA button label
 *   - home_hero_cta_ghost_url (text): Ghost CTA button URL
 *   - home_hero_cta_ghost_title (text): Ghost CTA button label
 */

// --- Data ---
$post_id      = get_the_ID();
$tagline_1    = carbon_get_post_meta($post_id, 'home_hero_tagline_1') ?: 'Privacy First';
$tagline_2    = carbon_get_post_meta($post_id, 'home_hero_tagline_2') ?: 'Simple by Design';
$tagline_3    = carbon_get_post_meta($post_id, 'home_hero_tagline_3') ?: 'Built with AI';
$headline     = carbon_get_post_meta($post_id, 'home_hero_headline') ?: 'Software that does exactly what you need — <em>nothing more.</em>';
$sub          = carbon_get_post_meta($post_id, 'home_hero_sub') ?: 'We build apps grounded in simplicity and privacy, using the best AI tools available.';
$cta1_url     = carbon_get_post_meta($post_id, 'home_hero_cta_primary_url') ?: '#';
$cta1_title   = carbon_get_post_meta($post_id, 'home_hero_cta_primary_title') ?: 'Our Apps';
$cta2_url     = carbon_get_post_meta($post_id, 'home_hero_cta_ghost_url') ?: '#';
$cta2_title   = carbon_get_post_meta($post_id, 'home_hero_cta_ghost_title') ?: 'Get In Touch';
?>

<!-- --- Styles --- -->
<style>
.home-hero {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 700px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(
        180deg,
        var(--color-navy-deep) 0%,
        #0d1e38 40%,
        #101f35 70%,
        #0e1c30 100%
    );
}

.home-hero__stars {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.home-hero__star {
    position: absolute;
    background: var(--color-white);
    border-radius: 50%;
    opacity: 0;
    animation: home-hero-twinkle var(--duration) ease-in-out var(--delay) infinite;
}

@keyframes home-hero-twinkle {
    0%, 100% { opacity: 0; }
    50%       { opacity: var(--max-opacity); }
}

.home-hero__geometry {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    opacity: 0;
    animation: home-hero-geo-reveal 3s ease 0.8s forwards;
}

@keyframes home-hero-geo-reveal {
    from { opacity: 0; }
    to   { opacity: 1; }
}

.home-hero__content {
    position: relative;
    z-index: 10;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    padding: 0 2rem;
    margin-top: -80px;
}

.home-hero__tagline {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.7rem, 1.5vw, 0.85rem);
    letter-spacing: 0.5em;
    text-transform: uppercase;
    color: var(--color-white);
    opacity: 0;
    animation: home-hero-fade-up 1s ease 0.9s forwards;
}

.home-hero__headline {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(2rem, 5vw, 3.2rem);
    color: var(--color-white);
    line-height: 1.2;
    max-width: 700px;
    opacity: 0;
    animation: home-hero-fade-up 1s ease 1.1s forwards;
}

.home-hero__headline em {
    font-style: italic;
    color: var(--color-slate-light);
}

.home-hero__sub {
    font-family: var(--font-body);
    font-weight: 200;
    font-size: clamp(0.85rem, 1.5vw, 1rem);
    color: var(--color-white);
    line-height: 1.8;
    max-width: 500px;
    opacity: 0;
    animation: home-hero-fade-up 1s ease 1.3s forwards;
}

.home-hero__ctas {
    display: flex;
    gap: 1.2rem;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
    opacity: 0;
    animation: home-hero-fade-up 1s ease 1.5s forwards;
    margin-top: 0.5rem;
}

.home-hero__cta--primary {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.78rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-navy-deep);
    background: var(--color-slate-light);
    padding: 0.85rem 2rem;
    text-decoration: none;
    transition: background var(--transition-base);
    border-radius: 1px;
}

.home-hero__cta--primary:hover {
    background: var(--color-white);
    color: var(--color-navy-deep);
}

.home-hero__cta--ghost {
    font-family: var(--font-body);
    font-weight: 300;
    font-size: 0.78rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-white);
    background: none;
    border: 1px solid rgba(232, 240, 248, 0.5);
    padding: 0.85rem 2rem;
    text-decoration: none;
    transition: border-color var(--transition-base), color var(--transition-base);
    border-radius: 1px;
}

.home-hero__cta--ghost:hover {
    border-color: var(--color-slate-light);
    color: var(--color-slate-light);
}

@keyframes home-hero-fade-up {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<!-- --- Markup --- -->
<section class="home-hero" data-section="home-hero">

    <div class="home-hero__stars" id="home-hero-stars"></div>

    <svg class="home-hero__geometry" id="home-hero-geometry" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1400 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <path id="home-hero-m-peaks" fill="none" stroke="var(--color-km-blue)" stroke-width="1"
            stroke-linecap="round" stroke-linejoin="round" opacity="0.35"
            d="M 100,660 L 420,140 L 700,420 L 980,140 L 1300,660"/>
        <line x1="100" y1="660" x2="1300" y2="660"
            stroke="var(--color-km-brown)" stroke-width="1" stroke-linecap="round" opacity="0.25"/>
        <line x1="700" y1="660" x2="100" y2="420"
            stroke="var(--color-km-green)" stroke-width="1" stroke-linecap="round" opacity="0.25"/>
        <line x1="700" y1="660" x2="1300" y2="420"
            stroke="var(--color-km-green)" stroke-width="1" stroke-linecap="round" opacity="0.25"/>
        <ellipse cx="700" cy="580" rx="90" ry="14"
            fill="none" stroke="var(--color-km-blue)" stroke-width="0.75" opacity="0.2"/>
    </svg>

    <div class="home-hero__content">
        <?php if ($tagline_1 || $tagline_2 || $tagline_3) : ?>
            <p class="home-hero__tagline">
                <?php echo esc_html($tagline_1); ?>
                <?php if ($tagline_2) : ?>&nbsp;·&nbsp; <?php echo esc_html($tagline_2); ?><?php endif; ?>
                <?php if ($tagline_3) : ?>&nbsp;·&nbsp; <?php echo esc_html($tagline_3); ?><?php endif; ?>
            </p>
        <?php endif; ?>

        <?php if ($headline) : ?>
            <h1 class="home-hero__headline"><?php echo wp_kses($headline, ['em' => [], 'strong' => [], 'br' => []]); ?></h1>
        <?php endif; ?>

        <?php if ($sub) : ?>
            <p class="home-hero__sub"><?php echo esc_html($sub); ?></p>
        <?php endif; ?>

        <?php if ($cta1_url || $cta2_url) : ?>
            <div class="home-hero__ctas">
                <?php if ($cta1_url) : ?>
                    <a href="<?php echo esc_url($cta1_url); ?>" class="home-hero__cta--primary">
                        <?php echo esc_html($cta1_title); ?>
                    </a>
                <?php endif; ?>
                <?php if ($cta2_url) : ?>
                    <a href="<?php echo esc_url($cta2_url); ?>" class="home-hero__cta--ghost">
                        <?php echo esc_html($cta2_title); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</section>

<!-- --- Script --- -->
<script>
(function () {
    var section  = document.querySelector('[data-section="home-hero"]');
    var container = document.getElementById('home-hero-stars');
    var mPath    = document.getElementById('home-hero-m-peaks');
    var h1El     = section.querySelector('.home-hero__headline');

    if (!section || !container || !mPath || !h1El) return;

    var heroRect  = section.getBoundingClientRect();
    var totalLen  = mPath.getTotalLength();
    var svgEl     = mPath.ownerSVGElement;
    var widthPx   = Math.ceil(heroRect.width);

    // Build boundary map: for each x-pixel, track the lowest y of the M path
    var boundaryMap = new Float32Array(widthPx).fill(heroRect.height);

    for (var i = 0; i <= 600; i++) {
        var pt       = mPath.getPointAtLength((i / 600) * totalLen);
        var svgPt    = svgEl.createSVGPoint();
        svgPt.x = pt.x;
        svgPt.y = pt.y;
        var ctm      = mPath.getScreenCTM();
        var screenPt = svgPt.matrixTransform(ctm);
        var px       = Math.round(screenPt.x - heroRect.left);
        var py       = screenPt.y - heroRect.top;

        if (px >= 0 && px < widthPx) {
            boundaryMap[px] = Math.min(boundaryMap[px], py);
        }
    }

    // Fill gaps via linear interpolation
    var lastValid = -1;
    for (var x = 0; x < widthPx; x++) {
        if (boundaryMap[x] < heroRect.height) {
            if (lastValid >= 0 && x - lastValid > 1) {
                var yStart = boundaryMap[lastValid];
                var yEnd   = boundaryMap[x];
                for (var fill = lastValid + 1; fill < x; fill++) {
                    var t = (fill - lastValid) / (x - lastValid);
                    boundaryMap[fill] = yStart + t * (yEnd - yStart);
                }
            }
            lastValid = x;
        }
    }

    var h1Bottom = h1El.getBoundingClientRect().bottom - heroRect.top;
    var placed   = 0;
    var attempts = 0;
    var margin   = 8;

    while (placed < 120 && attempts < 1200) {
        attempts++;
        var xPx = Math.random() * heroRect.width;
        var yPx = Math.random() * heroRect.height;

        if (yPx >= h1Bottom) continue;

        var idx      = Math.round(xPx);
        var boundary = (idx >= 0 && idx < boundaryMap.length) ? boundaryMap[idx] : heroRect.height;
        if (yPx >= boundary - margin) continue;

        var star = document.createElement('div');
        star.className = 'home-hero__star';
        var size = Math.random() * 2 + 0.5;
        star.style.cssText = [
            'width:'       + size + 'px',
            'height:'      + size + 'px',
            'top:'         + ((yPx / heroRect.height) * 100) + '%',
            'left:'        + ((xPx / heroRect.width) * 100) + '%',
            '--duration:'  + (Math.random() * 4 + 3) + 's',
            '--delay:'     + (Math.random() * 6) + 's',
            '--max-opacity:' + (Math.random() * 0.6 + 0.2),
        ].join(';');

        container.appendChild(star);
        placed++;
    }
})();
</script>
