<?php
/**
 * Section: Contact Form
 * Page: Contact
 * Description: Light background section with an optional heading and a Contact Form 7 embed.
 * Fields:
 *   - contact_form_heading (text): Optional label above the form, e.g. "Send a message"
 *   - contact_form_shortcode (text): Full [contact-form-7 ...] shortcode to render
 */

// ─── Data ────────────────────────────────────────────────────
$post_id   = get_the_ID();
$heading   = carbon_get_post_meta($post_id, 'contact_form_heading')   ?: 'Send a message';
$shortcode = carbon_get_post_meta($post_id, 'contact_form_shortcode');
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.contact-form {
    background: var(--color-bg-alt);
    padding: var(--spacing-3xl) var(--spacing-md);
}

.contact-form__container {
    max-width: var(--max-width-narrow);
    margin: 0 auto;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.contact-form.is-visible .contact-form__container {
    opacity: 1;
    transform: translateY(0);
}

.contact-form__heading {
    font-family: var(--font-heading);
    font-weight: 300;
    font-size: clamp(1.5rem, 3vw, 2rem);
    color: var(--color-text);
    margin-bottom: var(--spacing-xl);
}

/* ── CF7 overrides ─────────────────────────────────────────── */

/* CF7 wraps each field in <p> — use those for spacing */
.contact-form .wpcf7 form > p {
    margin: 0 0 var(--spacing-lg);
}

.contact-form .wpcf7 form > p:last-of-type {
    margin-bottom: 0;
}

/* Hidden fields fieldset reset */
.contact-form .wpcf7 fieldset.hidden-fields-container {
    border: none;
    margin: 0;
    padding: 0;
}

/* Label: flex so "Name" text node + * share one row; input wraps to the next */
.contact-form .wpcf7 label {
    display: flex;
    flex-wrap: wrap;
    align-items: baseline;
    row-gap: var(--spacing-xs);
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.8rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--color-text-light);
}

.contact-form .wpcf7 label br {
    display: none;
}

.contact-form .wpcf7 .required {
    color: var(--color-error);
    margin-left: 0.15em;
}

/* Full-width so it always wraps to its own row */
.contact-form .wpcf7 .wpcf7-form-control-wrap {
    flex: 0 0 100%;
}

/* Inputs + textarea */
.contact-form .wpcf7 input[type="text"],
.contact-form .wpcf7 input[type="email"],
.contact-form .wpcf7 textarea {
    width: 100%;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    padding: 0.75rem 1rem;
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--color-text);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
    -webkit-appearance: none;
    appearance: none;
}

.contact-form .wpcf7 input[type="text"]:focus,
.contact-form .wpcf7 input[type="email"]:focus,
.contact-form .wpcf7 textarea:focus {
    outline: none;
    border-color: var(--color-km-blue);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-km-blue) 15%, transparent);
}

.contact-form .wpcf7 textarea {
    min-height: 160px;
    resize: vertical;
}

/* Bottom row: submit + (future) Turnstile */
.contact-form .wpcf7 .form-bottom {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: var(--spacing-md);
    margin-top: var(--spacing-sm);
}

@media (min-width: 576px) {
    .contact-form .wpcf7 .form-bottom {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
}

/* <p> inside .form-bottom wrapping the submit button */
.contact-form .wpcf7 .form-bottom p {
    margin: 0;
}

/* Submit */
.contact-form .wpcf7 input[type="submit"] {
    font-family: var(--font-body);
    font-weight: 400;
    font-size: 0.78rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-white);
    background: var(--color-navy-deep);
    border: none;
    border-radius: 1px;
    padding: 0.9rem 2.4rem;
    cursor: pointer;
    transition: background var(--transition-base);
    -webkit-appearance: none;
    appearance: none;
}

.contact-form .wpcf7 input[type="submit"]:hover {
    background: var(--color-km-blue);
}

.contact-form .wpcf7 .wpcf7-spinner {
    display: none;
}

/* Validation */
.contact-form .wpcf7 .wpcf7-not-valid {
    border-color: var(--color-error);
}

.contact-form .wpcf7 .wpcf7-not-valid-tip {
    display: block;
    font-family: var(--font-body);
    font-size: 0.8rem;
    color: var(--color-error);
    margin-top: var(--spacing-xs);
}

/* Response output */
.contact-form .wpcf7 .wpcf7-response-output {
    margin: var(--spacing-lg) 0 0;
    padding: 0.75rem 1rem;
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-size: 0.875rem;
    border: none;
}

.contact-form .wpcf7 .wpcf7-mail-sent-ok {
    background: color-mix(in srgb, var(--color-success) 12%, transparent);
    color: var(--color-success);
}

.contact-form .wpcf7 .wpcf7-mail-sent-ng,
.contact-form .wpcf7 .wpcf7-spam-blocked,
.contact-form .wpcf7 .wpcf7-validation-errors,
.contact-form .wpcf7 .wpcf7-acceptance-missing {
    background: color-mix(in srgb, var(--color-error) 10%, transparent);
    color: var(--color-error);
}

/* ── Dev notice (shown only when no shortcode is set) ──────── */
.contact-form__notice {
    padding: var(--spacing-lg);
    border: 1px dashed var(--color-border);
    border-radius: var(--radius-md);
    font-family: var(--font-mono);
    font-size: 0.8rem;
    color: var(--color-text-light);
    text-align: center;
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="contact-form" data-section="contact-form">
    <div class="contact-form__container">

        <?php if ($heading) : ?>
            <h2 class="contact-form__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($shortcode) : ?>
            <?php echo do_shortcode(wp_kses_post($shortcode)); ?>
        <?php else : ?>
            <div class="contact-form__notice">
                No CF7 shortcode set. Paste <code>[contact-form-7 id="…" title="…"]</code> into the <strong>Contact — Form</strong> field in WP Admin.
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- ─── Script ─────────────────────────────────────────────── -->
<script>
(function () {
    var section = document.querySelector('[data-section="contact-form"]');
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
