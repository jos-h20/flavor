# CLAUDE.md — WordPress Section Builder Theme

## Project Overview

This is a **zero-build WordPress theme** designed for rapid section-based page building. Each page section is a fully self-contained PHP file with its own inline CSS and JavaScript. There is no build step, no compiler, no bundler. You edit a file, refresh the browser, and it's live.

The theme uses **ACF Flexible Content** as the layout engine. Each layout maps to a PHP file in `templates/sections/`. The dispatcher loads the matching file automatically.

---

## Architecture

```
themes/flavor/
├── CLAUDE.md                  ← You are here
├── style.css                  ← Theme declaration + design tokens + base reset
├── functions.php              ← Theme setup, ACF field registration, utilities
├── header.php                 ← Global site header
├── footer.php                 ← Global site footer
├── templates/
│   ├── page-builder.php       ← Page template with flexible content loop
│   └── sections/
│       ├── hero.php
│       ├── pricing-table.php
│       ├── testimonials.php
│       └── ...                ← Each section is one self-contained file
├── acf-json/                  ← ACF local JSON sync (auto-managed by ACF)
├── assets/
│   ├── fonts/                 ← Self-hosted web fonts (if any)
│   └── images/                ← Theme-level images (logo, icons, fallbacks)
└── _preview/
    ├── _template.html         ← Base wrapper for standalone preview files
    └── *.html                 ← Standalone preview versions of sections
```

---

## Section File Format

Every section is a single PHP file located at `templates/sections/{section-name}.php`. The file contains everything that section needs — PHP data logic, CSS, HTML, and JavaScript — in that exact order.

### Template

```php
<?php
/**
 * Section: {Section Name}
 * Description: {Brief description of what this section does}
 * Fields:
 *   - {field_name} ({field_type}): {description}
 *   - {field_name} ({field_type}): {description}
 */

// ─── Data ────────────────────────────────────────────────────
$field = get_sub_field('field_name');
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
1. Load the CSS (if any) via a `<link>` tag inside the `<style>` area or as a separate tag before the `<style>` block.
2. Load the JS via `<script src="..."></script>` immediately before the section's `<script>` block.
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

## ACF Field Registration

All ACF fields are registered in code (not through the admin UI) so they're version-controlled. Fields are registered in `functions.php` or in a dedicated `includes/fields.php`.

When creating a new section, also register its ACF fields using `acf_add_local_field_group()`. The layout name in the flexible content field **must exactly match** the section's PHP filename (without the `.php` extension).

### Field Registration Pattern

```php
// In functions.php or includes/fields.php
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_page_sections',
        'title' => 'Page Sections',
        'fields' => [
            [
                'key' => 'field_sections',
                'label' => 'Sections',
                'name' => 'sections',
                'type' => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts' => [
                    'hero' => [
                        'key' => 'layout_hero',
                        'name' => 'hero',
                        'label' => 'Hero',
                        'sub_fields' => [
                            ['key' => 'field_hero_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'],
                            ['key' => 'field_hero_subheading', 'label' => 'Subheading', 'name' => 'subheading', 'type' => 'textarea'],
                            ['key' => 'field_hero_image', 'label' => 'Background Image', 'name' => 'background_image', 'type' => 'image', 'return_format' => 'array'],
                        ],
                    ],
                    // ... more layouts
                ],
            ],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-builder.php']],
        ],
    ]);
});
```

### ACF Field Conventions
- **Keys are globally unique.** Use prefix pattern: `field_{section}_{fieldname}` and `layout_{section}`.
- **Image fields:** Always use `'return_format' => 'array'` so you get `url`, `alt`, `width`, `height`.
- **Repeater fields:** Return arrays of sub-field values. Loop with `foreach`.
- **WYSIWYG fields:** Output with `wp_kses_post()` for safety.
- **Link fields:** Return arrays with `url`, `title`, `target`.

### Common ACF Field Access Patterns
```php
// Text / Textarea
$heading = get_sub_field('heading');

// Image (array format)
$image = get_sub_field('image');
// Use: $image['url'], $image['alt'], $image['width'], $image['height']

// Link
$link = get_sub_field('cta_link');
// Use: $link['url'], $link['title'], $link['target']

// Repeater
$items = get_sub_field('features');
// Loop: foreach ($items as $item) { echo $item['title']; }

// WYSIWYG
$content = get_sub_field('content');
// Use: echo wp_kses_post($content);

// True/False
$show_bg = get_sub_field('show_background');
// Use: if ($show_bg) { ... }

// Select / Radio
$style = get_sub_field('style_variant');
// Use as modifier class: class="hero hero--<?= esc_attr($style) ?>"

// Gallery
$images = get_sub_field('gallery');
// Returns array of image arrays
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

For standalone browser testing without WordPress, create a preview version at `_preview/{section-name}.html`. This is an identical copy of the section but with hardcoded dummy data instead of ACF calls.

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
<!-- Replace all PHP/ACF calls with hardcoded sample data -->

</body>
</html>
```

---

## Creating a New Section — Checklist

When asked to create a new section, always do all of the following:

1. **Create the section file** at `templates/sections/{name}.php` following the template format above.
2. **Register the ACF fields** by adding a new layout to the flexible content group in `functions.php` (or `includes/fields.php`).
3. **Create a preview file** at `_preview/{name}.html` with dummy data.
4. **Document the section** in the file header comment block: list all ACF fields with types and descriptions.

---

## Editing an Existing Section

When asked to edit a section:

1. Read the existing file first.
2. Maintain all existing conventions (BEM naming, scoping, IIFE).
3. If adding new ACF fields, also update the field registration.
4. Update the preview file if it exists.

---

## Common Patterns

### Section with Style Variants
```php
$variant = get_sub_field('style') ?: 'default';
?>
<section class="feature-grid feature-grid--<?= esc_attr($variant) ?>" data-section="feature-grid">
```

### Conditional Background Image
```php
$bg = get_sub_field('background_image');
$style = $bg ? 'background-image: url(' . esc_url($bg['url']) . ')' : '';
?>
<section class="hero" data-section="hero" style="<?= esc_attr($style) ?>">
```

### Container Pattern
```php
<section class="testimonials" data-section="testimonials">
    <div class="testimonials__container">
        <!-- content constrained to max-width -->
    </div>
</section>
```
```css
.testimonials__container {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}
```

### Responsive Grid
```css
.feature-grid__items {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-lg);
}

@media (min-width: 768px) {
    .feature-grid__items {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .feature-grid__items {
        grid-template-columns: repeat(3, 1fr);
    }
}
```

### Scroll-triggered Animations
```javascript
(function() {
    const section = document.querySelector('[data-section="stats"]');
    if (!section) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    section.querySelectorAll('.stats__item').forEach(el => observer.observe(el));
})();
```

---

## Things to Never Do

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