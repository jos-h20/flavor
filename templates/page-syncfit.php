<?php
/**
 * Template Name: SyncFit
 */
get_header(); ?>

<style>
:root {
    --bg: #000000;
    --surface: #1c1c1e;
    --surface-2: #262626;
    --accent: #0a84ff;
    --accent-dim: rgba(10, 132, 255, 0.15);
    --success: #30d158;
    --success-dim: rgba(48, 209, 88, 0.15);
    --warning: #ff9f0a;
    --warning-dim: rgba(255, 159, 10, 0.15);
    --error: #ff453a;
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 255, 255, 0.6);
    --text-tertiary: rgba(255, 255, 255, 0.4);
    --divider: rgba(255, 255, 255, 0.08);
    --space-xs: 4px;
    --space-sm: 8px;
    --space-md: 12px;
    --space-lg: 16px;
    --space-xl: 24px;
    --space-xxl: 32px;
    --space-xxxl: 48px;
    --sf-font: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Inter", system-ui, sans-serif;
    --sf-max-width: 1100px;
}

body {
    background: var(--bg);
}
</style>

<main>
    <?php include get_template_directory() . '/templates/sections/syncfit-hero.php'; ?>
    <?php include get_template_directory() . '/templates/sections/syncfit-intraday.php'; ?>
    <?php include get_template_directory() . '/templates/sections/syncfit-pricing.php'; ?>
    <?php include get_template_directory() . '/templates/sections/syncfit-metrics.php'; ?>
    <?php include get_template_directory() . '/templates/sections/syncfit-how-it-works.php'; ?>
    <?php include get_template_directory() . '/templates/sections/syncfit-privacy.php'; ?>
</main>

<?php get_footer();
