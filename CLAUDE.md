# CLAUDE.md — WordPress Section Builder Theme

## Project Overview

This is a **zero-build WordPress theme** designed for rapid section-based page building. Each page section is a fully self-contained PHP file with its own inline CSS and JavaScript. There is no build step, no compiler, no bundler. You edit a file, refresh the browser, and it's live.

The theme uses **Carbon Fields** (free, bundled via Composer) for content editing. Field groups are registered **per page template** — each page template has its own scoped field registration so WP admin only shows relevant fields for that page.

**Page structure is defined in code, not in the database.** Each page is a PHP template that includes sections in a fixed order. This enables full version control of page structure via git.

---

## Architecture

```
themes/flavor/
├── CLAUDE.md                  ← You are here
├── style.css                  ← Theme declaration + design tokens + base reset
├── composer.json              ← Carbon Fields dependency
├── vendor/                    ← Composer packages (gitignored)
├── functions.php              ← Theme setup, Carbon Fields boot, utilities
├── header.php                 ← Global site header (shared across all pages)
├── footer.php                 ← Global site footer (shared across all pages)
├── includes/
│   └── fields.php             ← All Carbon Fields registration (per page template)
├── templates/
│   ├── page-home.php          ← Home page template
│   ├── page-about.php         ← About page template
│   ├── page-services.php      ← Services page template
│   └── sections/
│       ├── hero.php           ← Page-specific sections (default)
│       ├── pricing-table.php
│       ├── testimonials.php
│       └── ...
├── assets/
│   ├── fonts/                 ← Self-hosted web fonts (if any)
│   └── images/                ← Theme-level images (logo, icons, fallbacks)
└── _preview/
    ├── _template.html         ← Base wrapper for standalone preview files
    └── *.html                 ← Standalone preview versions of sections
```

---

## Page Template Format

Each page is a PHP template file that hardcodes which sections appear and in what order. Page structure is never stored in the database.

### Template

```php
<?php
/**
 * Template Name: Home
 */
get_header(); ?>

<main>
    <?php include get_template_directory() . '/templates/sections/home-hero.php'; ?>
    <?php include get_template_directory() . '/templates/sections/home-services.php'; ?>
    <?php include get_template_directory() . '/templates/sections/home-testimonials.php'; ?>
    <?php include get_template_directory() . '/templates/sections/home-contact-cta.php'; ?>
</main>

<?php get_footer();
```

### Page Template Rules

- **One template per page.** Each page (home, about, services, etc.) has its own template file at `templates/page-{name}.php`.
- **Sections are included in order.** The order in the template is the order on the page. To reorder sections, reorder the `include` lines.
- **No dispatcher loop.** There is no flexible content loop. Sections are included directly.
- **Header and footer are always global** via `get_header()` and `get_footer()`.
- **Page structure lives in git.** Changing page structure means editing the template file and committing.

---

## Section Naming Convention

Sections are **page-specific by default.** Prefix section filenames with the page name.

```
templates/sections/home-hero.php
templates/sections/home-services.php
templates/sections/about-hero.php
templates/sections/about-team.php
```

**Carbon Fields field names follow the same prefix convention:**
```
home_hero_heading
home_hero_subheading
about_hero_heading
about_hero_subheading
```

### Reusable Sections

Header and footer are always global. All other sections start as page-specific.

**Refactor to reusable only when a section is genuinely needed on multiple pages.** The trigger is being asked to build the same section concept for a second page. At that point, refactor the section to accept a field prefix parameter:

```php
<?php
// templates/sections/shared-hero.php
// Usage: include with $field_prefix set before including
// e.g. $field_prefix = 'home'; include 'shared-hero.php';

$heading = carbon_get_post_meta(get_the_ID(), $field_prefix . '_hero_heading');
?>
```

**Never duplicate a section file.** If you catch yourself creating `about-hero.php` that is nearly identical to `home-hero.php`, stop and refactor to a shared section instead.

---

## When Building a New Page — Always Do All Three

When asked to build a new page, always create all of the following in one shot:

1. **The page template** at `templates/page-{name}.php` with sections included in order.
2. **Each section file** at `templates/sections/{page}-{section}.php`.
3. **Carbon Fields registration** in `includes/fields.php` scoped to that page template.

Example prompt: *"Build a home page with hero, services grid, testimonials, and contact CTA"* should produce:
- `templates/page-home.php`
- `templates/sections/home-hero.php`
- `templates/sections/home-services.php`
- `templates/sections/home-testimonials.php`
- `templates/sections/home-contact-cta.php`
- Field registration in `includes/fields.php` for each section, scoped to `templates/page-home.php`

---

## Carbon Fields Registration

All fields are registered in `includes/fields.php`. Field groups are scoped **per page template** so WP admin only shows relevant fields on the right pages.

### Per-Template Registration Pattern

```php
// includes/fields.php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    // ── Home Page ─────────────────────────────────────────────
    Container::make('post_meta', 'Home — Hero')
        ->where('post_template', '=', 'templates/page-home.php')
        ->add_fields([
            Field::make('text', 'home_hero_heading', 'Heading'),
            Field::make('textarea', 'home_hero_subheading', 'Subheading'),
            Field::make('image', 'home_hero_background_image', 'Background Image'),
            Field::make('text', 'home_hero_cta_url', 'CTA URL'),
            Field::make('text', 'home_hero_cta_title', 'CTA Text'),
            Field::make('select', 'home_hero_cta_target', 'CTA Target')
                ->set_options(['_self' => 'Same Window', '_blank' => 'New Tab']),
        ]);

    Container::make('post_meta', 'Home — Services')
        ->where('post_template', '=', 'templates/page-home.php')
        ->add_fields([
            Field::make('text', 'home_services_heading', 'Heading'),
            Field::make('complex', 'home_services_items', 'Services')
                ->add_fields([
                    Field::make('text', 'title', 'Title'),
                    Field::make('textarea', 'description', 'Description'),
                    Field::make('image', 'icon', 'Icon'),
                ]),
        ]);

    // ── About Page ────────────────────────────────────────────
    Container::make('post_meta', 'About — Hero')
        ->where('post_template', '=', 'templates/page-about.php')
        ->add_fields([
            Field::make('text', 'about_hero_heading', 'Heading'),
            Field::make('textarea', 'about_hero_subheading', 'Subheading'),
        ]);

});
```

### Carbon Fields Conventions
- **Field names are always prefixed** with `{page}_{section}_` e.g. `home_hero_heading`.
- **Image fields** return an attachment ID. Use `flavor_get_image_data($id)` to get `['url', 'alt', 'width', 'height']`.
- **Link/CTA fields:** Use 3 flat fields: `{prefix}_cta_url` (text), `{prefix}_cta_title` (text), `{prefix}_cta_target` (select).
- **Complex (repeater) fields:** Return arrays of associative arrays. Loop with `foreach`.
- **WYSIWYG fields:** Output with `wp_kses_post()` for safety.

### Common Field Access Patterns
```php
// Direct post meta (no flexible content loop)
$heading = carbon_get_post_meta(get_the_ID(), 'home_hero_heading');

// Image (returns attachment ID — convert with helper)
$image = flavor_get_image_data(carbon_get_post_meta(get_the_ID(), 'home_hero_background_image'));
// Use: $image['url'], $image['alt'], $image['width'], $image['height']

// CTA
$cta_url = carbon_get_post_meta(get_the_ID(), 'home_hero_cta_url');
$cta = $cta_url ? [
    'url'    => $cta_url,
    'title'  => carbon_get_post_meta(get_the_ID(), 'home_hero_cta_title'),
    'target' => carbon_get_post_meta(get_the_ID(), 'home_hero_cta_target') ?: '_self',
] : null;

// Complex (repeater)
$items = carbon_get_post_meta(get_the_ID(), 'home_services_items');
// Loop: foreach ($items as $item) { echo $item['title']; }

// WYSIWYG
$content = carbon_get_post_meta(get_the_ID(), 'home_about_content');
// Use: echo wp_kses_post($content);

// True/False (checkbox)
$show_bg = carbon_get_post_meta(get_the_ID(), 'home_hero_show_background');

// Select / Radio
$style = carbon_get_post_meta(get_the_ID(), 'home_hero_style') ?: 'default';
// Use as modifier class: class="hero hero--<?= esc_attr($style) ?>"
```

---

## Section File Format

Every section is a single PHP file. The file contains everything that section needs — PHP data logic, CSS, HTML, and JavaScript — in that exact order.

### Template

```php
<?php
/**
 * Section: {Section Name}
 * Page: {Page Name}
 * Description: {Brief description of what this section does}
 * Fields:
 *   - {field_name} ({field_type}): {description}
 *   - {field_name} ({field_type}): {description}
 */

// ─── Data ────────────────────────────────────────────────────
$post_id = get_the_ID();
$heading = carbon_get_post_meta($post_id, 'home_hero_heading');
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.{section-name} {
    /* styles here */
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="{section-name}" data-section="{section-name}">
    <!-- HTML here -->
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function() {
    const section = document.querySelector('[data-section="{section-name}"]');
    if (!section) return;
    // JavaScript here
})();
</script>
```

### Important Rules

- **One file, one section.** Everything the section needs lives in this file.
- **Order matters:** PHP variables → `<style>` → `<section>` → `<script>`.
- **No external stylesheets or script files.** All CSS and JS is inline in the section file.
- **PHP variables are declared at the top** before any HTML output.
- **No `$section_data` array.** Fields are fetched directly with `carbon_get_post_meta()`.

---

## CSS Rules

### Scoping and Naming
- **Every selector must be scoped** to the section's root class. No bare element selectors. No global styles.
- **Use BEM naming** with the section name as the block: `.hero__title`, `.hero__cta--primary`, `.pricing-table__card`.
- **Never use `!important`.**
- **Never use `*` selectors** or global resets inside a section.
- **Never use ID selectors.**

### Methodology
- **Vanilla CSS only.** No Tailwind, no Bootstrap, no preprocessors.
- **Mobile-first.** Write base styles for mobile, then use `min-width` media queries to enhance for larger screens.
- **Use CSS custom properties** from `style.css` for all colors, fonts, spacing, and sizing. Never hardcode hex colors or font stacks in a section file.
- **Modern CSS features are encouraged:** Grid, Flexbox, `clamp()`, container queries, `:has()`, CSS nesting, `color-mix()`, custom properties, logical properties.

### Standard Breakpoints
```css
/* Tablet */
@media (min-width: 768px) { }

/* Desktop */
@media (min-width: 1024px) { }

/* Wide */
@media (min-width: 1280px) { }
```

### Spacing and Sizing
- Use `rem` for spacing and font sizes.
- Use `clamp()` for fluid typography and spacing where appropriate.
- Sections should have vertical padding using the theme's spacing scale.

---

## JavaScript Rules

### Scoping and Safety
- **Always wrap in an IIFE:** `(function() { ... })();`
- **Never pollute the global scope.** No global variables, no `window.` assignments.
- **Query elements from the section root**, not from `document` globally:
  ```javascript
  const section = document.querySelector('[data-section="hero"]');
  const button = section.querySelector('.hero__cta');
  ```
- **Use `data-` attributes** for state management and JS hooks. Never select by class names used for styling if avoidable.

### Methodology
- **Vanilla JavaScript only.** No jQuery, no Alpine.js, no frameworks.
- **Modern JS is encouraged:** `async/await`, optional chaining, `IntersectionObserver`, `ResizeObserver`, template literals, destructuring, `AbortController`.
- **Event delegation** when handling multiple similar elements:
  ```javascript
  section.addEventListener('click', (e) => {
      const card = e.target.closest('.pricing-table__card');
      if (!card) return;
      // handle card click
  });
  ```

### External Libraries (CDN)
If a section genuinely needs a library (carousel, animation, maps), load it inline via CDN within that section's `<script>` area. Do not add global dependencies.

**Approved CDN libraries:**
- **Swiper** (carousels/sliders): `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js`
- **GSAP** (animation): `https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js`
- **Lottie** (animations): `https://cdn.jsdelivr.net/npm/lottie-web@5/build/player/lottie.min.js`
- **Leaflet** (maps): `https://unpkg.com/leaflet@1/dist/leaflet.js`
- **GLightbox** (lightboxes): `https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js`
- **CountUp.js** (number animations): `https://cdn.jsdelivr.net/npm/countup.js@2/dist/countUp.umd.js`

When using a CDN library:
1. Load the CSS (if any) via a `<link>` tag before the `<style>` block.
2. Load the JS via `<script src="..."></script>` immediately before the section's inline `<script>` block.
3. Always use a specific version number, never `@latest`.

---

## Design Tokens (CSS Custom Properties)

All sections must reference these variables from `style.css`. Never hardcode values.

```css
/* Colors */
--color-primary
--color-primary-light
--color-primary-dark
--color-secondary
--color-accent
--color-text
--color-text-light
--color-text-inverted
--color-bg
--color-bg-alt
--color-bg-dark
--color-border
--color-success
--color-warning
--color-error

/* Typography */
--font-heading
--font-body
--font-mono

/* Spacing */
--spacing-xs     /* 0.25rem */
--spacing-sm     /* 0.5rem */
--spacing-md     /* 1rem */
--spacing-lg     /* 2rem */
--spacing-xl     /* 4rem */
--spacing-2xl    /* 6rem */
--spacing-3xl    /* 8rem */

/* Layout */
--max-width          /* 1200px */
--max-width-narrow   /* 800px */
--max-width-wide     /* 1400px */

/* Borders & Radius */
--radius-sm
--radius-md
--radius-lg
--radius-full    /* 9999px */

/* Shadows */
--shadow-sm
--shadow-md
--shadow-lg

/* Transitions */
--transition-fast     /* 150ms ease */
--transition-base     /* 300ms ease */
--transition-slow     /* 500ms ease */
```

---

## HTML Rules

- **Semantic elements:** Use `<section>`, `<article>`, `<nav>`, `<header>`, `<footer>`, `<figure>`, `<figcaption>`, etc.
- **Root element is always `<section>`** with the section name as both class and `data-section` attribute.
- **Accessibility:** All images must have `alt` attributes. Interactive elements must be focusable. Use `aria-` attributes where appropriate. Maintain logical heading hierarchy.
- **Escape all dynamic output:**
  - Text: `<?= esc_html($var) ?>`
  - Attributes: `<?= esc_attr($var) ?>`
  - URLs: `<?= esc_url($var) ?>`
  - Rich text: `<?= wp_kses_post($var) ?>`
- **Images:** Always include `width`, `height`, `loading="lazy"`, and `alt`.
  ```php
  <img
      src="<?= esc_url($image['url']) ?>"
      alt="<?= esc_attr($image['alt']) ?>"
      width="<?= esc_attr($image['width']) ?>"
      height="<?= esc_attr($image['height']) ?>"
      loading="lazy"
  >
  ```

---

## Preview Files

For standalone browser testing without WordPress, create a preview version at `_preview/{section-name}.html`. This is an identical copy of the section but with hardcoded dummy data instead of PHP calls.

### Preview Template
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{Section Name} Preview</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Paste the section's <style>, <section>, and <script> blocks here -->
<!-- Replace all PHP calls with hardcoded sample data -->

</body>
</html>
```

---

## Creating a New Page — Checklist

When asked to create a new page, always do all of the following in one shot:

1. **Create the page template** at `templates/page-{name}.php` with sections hardcoded in order.
2. **Create each section file** at `templates/sections/{page}-{section}.php`.
3. **Register Carbon Fields** in `includes/fields.php` with a separate `Container::make()` per section, scoped to that page template.
4. **Create preview files** at `_preview/{page}-{section}.html` for each section.
5. **Document each section** in its file header comment: list all fields with types and descriptions.

---

## Editing an Existing Page — Checklist

When asked to edit a page:

1. Read the existing template and section files first.
2. To reorder sections: edit the `include` order in the page template.
3. To add a section: create the section file, add the `include` to the template, register new fields in `includes/fields.php`.
4. To remove a section: remove the `include` line (keep the file unless explicitly told to delete it).
5. Maintain all existing conventions (BEM naming, scoping, IIFE, field prefix).
6. Update the preview file if it exists.

---

## Common Patterns

### Section with Style Variants
```php
$variant = carbon_get_post_meta(get_the_ID(), 'home_hero_style') ?: 'default';
?>
<section class="home-hero home-hero--<?= esc_attr($variant) ?>" data-section="home-hero">
```

### Conditional Background Image
```php
$bg = flavor_get_image_data(carbon_get_post_meta(get_the_ID(), 'home_hero_background_image'));
$style = $bg ? 'background-image: url(' . esc_url($bg['url']) . ')' : '';
?>
<section class="home-hero" data-section="home-hero" style="<?= esc_attr($style) ?>">
```

### Container Pattern
```php
<section class="home-testimonials" data-section="home-testimonials">
    <div class="home-testimonials__container">
        <!-- content constrained to max-width -->
    </div>
</section>
```
```css
.home-testimonials__container {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}
```

### Responsive Grid
```css
.home-services__items {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-lg);
}

@media (min-width: 768px) {
    .home-services__items {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .home-services__items {
        grid-template-columns: repeat(3, 1fr);
    }
}
```

### Scroll-triggered Animations
```javascript
(function() {
    const section = document.querySelector('[data-section="home-stats"]');
    if (!section) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    section.querySelectorAll('.home-stats__item').forEach(el => observer.observe(el));
})();
```

---

## Deployment

**Code changes are deployed through GitHub.** Push to the repository and the deployment pipeline handles the rest. Never SCP theme files directly to the live server.

**SSH/WP-CLI is for data operations only:** setting post meta, updating options, importing media, listing posts, etc. These are database operations, not file deployments.

## Git Workflow

Page structure is version controlled. Use descriptive commit messages:

```
git commit -m "home: initial page build"
git commit -m "home: add testimonials section"
git commit -m "home: reorder services above hero"
git commit -m "home-hero: add video background option"
git commit -m "about: initial page build"
```

---

## Things to Never Do

- Never use a flexible content loop to assemble pages. Page structure is hardcoded in template files.
- Never store page section order in the database.
- Never create a section file without a matching field registration in `includes/fields.php`.
- Never duplicate a section file across pages — refactor to a shared section with a field prefix parameter instead.
- Never add anything to `style.css` from a section file. That file is theme-level only.
- Never register `wp_enqueue_script` or `wp_enqueue_style` for section-specific assets.
- Never use inline `onclick`, `onmouseover`, or other HTML event attributes.
- Never use `document.write()`.
- Never assume jQuery is loaded.
- Never add global CSS resets or normalizers inside a section.
- Never use `@import` inside a section's `<style>` block.
- Never hardcode colors, font families, or spacing values — always use custom properties.
- Never use `position: fixed` or `position: sticky` without confirming it won't conflict with the site header/footer.
- Never output unescaped user data. Always use `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_kses_post()`.
- Never hardcode image paths except for theme assets in `/assets/images/`. Always use Carbon Fields image fields.