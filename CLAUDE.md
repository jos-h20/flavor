# CLAUDE.md — WordPress Section Builder Theme

## Project Overview

This is a **zero-build WordPress theme** designed for rapid section-based page building. Each page section is a fully self-contained PHP file with its own inline CSS and JavaScript. There is no build step, no compiler, no bundler. You edit a file, refresh the browser, and it's live.

The theme uses **Carbon Fields** (free, bundled via Composer) as the layout engine. A `complex` field named `sections` provides flexible content layouts. Each layout maps to a PHP file in `templates/sections/`. The dispatcher loads the matching file automatically.

---

## Architecture

```
themes/flavor/
├── CLAUDE.md                  ← You are here
├── style.css                  ← Theme declaration + design tokens + base reset
├── composer.json              ← Carbon Fields dependency
├── vendor/                    ← Composer packages (gitignored)
├── functions.php              ← Theme setup, Carbon Fields boot, utilities
├── header.php                 ← Global site header
├── footer.php                 ← Global site footer
├── templates/
│   ├── page-builder.php       ← Page template with flexible content loop
│   └── sections/
│       ├── hero.php
│       ├── pricing-table.php
│       ├── testimonials.php
│       └── ...                ← Each section is one self-contained file
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
// $section_data is passed from page-builder.php
$field = $section_data['field_name'] ?? '';
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

## Carbon Fields Registration

All fields are registered in code in `includes/fields.php`. The theme bundles Carbon Fields via Composer (`composer.json`). Run `composer install` after cloning.

When creating a new section, add a new `->add_fields()` call to the `sections` complex field. The layout name **must exactly match** the section's PHP filename (without the `.php` extension).

### Field Registration Pattern

```php
// In includes/fields.php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    Container::make('post_meta', 'Page Sections')
        ->where('post_template', '=', 'templates/page-builder.php')
        ->add_fields([
            Field::make('complex', 'sections', 'Sections')
                ->set_layout('tabbed-vertical')

                ->add_fields('hero', 'Hero', [
                    Field::make('text', 'heading', 'Heading'),
                    Field::make('textarea', 'subheading', 'Subheading'),
                    Field::make('image', 'background_image', 'Background Image'),
                    Field::make('text', 'cta_url', 'CTA URL'),
                    Field::make('text', 'cta_title', 'CTA Text'),
                    Field::make('select', 'cta_target', 'CTA Target')
                        ->set_options(['_self' => 'Same Window', '_blank' => 'New Tab']),
                    Field::make('select', 'style', 'Style')
                        ->set_options(['default' => 'Default', 'dark' => 'Dark', 'minimal' => 'Minimal']),
                ]),
                // ... more layouts
        ]);
});
```

### Carbon Fields Conventions
- **Image fields** return an attachment ID. Use `flavor_get_image_data($id)` to get `['url', 'alt', 'width', 'height']`.
- **Link/CTA fields:** Carbon Fields has no link field. Use 3 flat fields: `cta_url` (text), `cta_title` (text), `cta_target` (select).
- **Complex (repeater) fields:** Return arrays of associative arrays. Loop with `foreach`.
- **WYSIWYG fields:** Output with `wp_kses_post()` for safety.
- **Each section entry** has a `_type` key containing the layout name.

### Common Field Access Patterns
```php
// $section_data is passed from page-builder.php (an associative array)

// Text / Textarea
$heading = $section_data['heading'] ?? '';

// Image (returns attachment ID — convert with helper)
$image = flavor_get_image_data($section_data['background_image'] ?? 0);
// Use: $image['url'], $image['alt'], $image['width'], $image['height']

// CTA (flat fields assembled into array)
$cta_url = $section_data['cta_url'] ?? '';
$cta = $cta_url ? ['url' => $cta_url, 'title' => $section_data['cta_title'] ?? '', 'target' => $section_data['cta_target'] ?? '_self'] : null;

// Complex (repeater)
$items = $section_data['features'] ?? [];
// Loop: foreach ($items as $item) { echo $item['title']; }

// WYSIWYG
$content = $section_data['content'] ?? '';
// Use: echo wp_kses_post($content);

// True/False (checkbox)
$show_bg = $section_data['show_background'] ?? false;
// Use: if ($show_bg) { ... }

// Select / Radio
$style = $section_data['style'] ?? 'default';
// Use as modifier class: class="hero hero--<?= esc_attr($style) ?>"
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
<!-- Replace all PHP/PHP calls with hardcoded sample data -->

</body>
</html>
```

---

## Creating a New Section — Checklist

When asked to create a new section, always do all of the following:

1. **Create the section file** at `templates/sections/{name}.php` following the template format above.
2. **Register the Carbon Fields** by adding a new `->add_fields()` call in `includes/fields.php`.
3. **Create a preview file** at `_preview/{name}.html` with dummy data.
4. **Document the section** in the file header comment block: list all fields with types and descriptions.

---

## Editing an Existing Section

When asked to edit a section:

1. Read the existing file first.
2. Maintain all existing conventions (BEM naming, scoping, IIFE).
3. If adding new fields, also update the field registration in `includes/fields.php`.
4. Update the preview file if it exists.

---

## Common Patterns

### Section with Style Variants
```php
$variant = $section_data['style'] ?? 'default';
?>
<section class="feature-grid feature-grid--<?= esc_attr($variant) ?>" data-section="feature-grid">
```

### Conditional Background Image
```php
$bg = flavor_get_image_data($section_data['background_image'] ?? 0);
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