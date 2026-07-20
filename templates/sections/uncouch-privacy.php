<?php
/**
 * Section: Privacy
 * Page: Uncouch
 * Description: Single glass card communicating on-device privacy and location handling, with a policy link.
 * Fields:
 *   - uncouch_privacy_heading (text): Heading
 *   - uncouch_privacy_body (textarea): Body copy
 *   - uncouch_privacy_policy_url (text): Link to the full privacy policy
 */

// ─── Data ────────────────────────────────────────────────────
$post_id    = get_the_ID();
$heading    = carbon_get_post_meta($post_id, 'uncouch_privacy_heading') ?: 'Your data stays yours';
$body       = carbon_get_post_meta($post_id, 'uncouch_privacy_body') ?: 'Uncouch works entirely on your device. There\'s no account, no sign-in, and nothing sent to a server. Your location is used only during a workout — to measure distance and keep coaching while your phone is locked — and it never leaves your phone.';
$policy_url = carbon_get_post_meta($post_id, 'uncouch_privacy_policy_url') ?: '/privacy-policy';
?>

<!-- ─── Styles ─────────────────────────────────────────────── -->
<style>
.uncouch-privacy {
    background: var(--bg);
    padding: 80px var(--space-xl);
    font-family: var(--sf-font);
}

.uncouch-privacy__card {
    max-width: 700px;
    margin: 0 auto;
    background: var(--surface);
    border: 1px solid var(--divider);
    border-radius: 20px;
    padding: var(--space-xxxl) var(--space-xxl);
    text-align: center;
}

.uncouch-privacy__icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: var(--success-dim);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto var(--space-xl);
    line-height: 1;
}

.uncouch-privacy__heading {
    font-size: 22px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 var(--space-lg);
    letter-spacing: -0.01em;
}

.uncouch-privacy__body {
    font-size: 16px;
    color: var(--text-secondary);
    line-height: 1.65;
    margin: 0 0 var(--space-xxl);
}

.uncouch-privacy__chip {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    padding: 6px 14px;
    border-radius: 99px;
    background: var(--success-dim);
    color: var(--success);
    font-size: 13px;
    font-weight: 600;
}

.uncouch-privacy__policy {
    display: block;
    font-size: 14px;
    color: var(--text-secondary);
    margin: var(--space-xl) 0 0;
}

.uncouch-privacy__policy a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
}

.uncouch-privacy__policy a:hover {
    text-decoration: underline;
}

@media (min-width: 768px) {
    .uncouch-privacy {
        padding: 100px var(--space-xxl);
    }

    .uncouch-privacy__card {
        padding: var(--space-xxxl) 56px;
    }
}
</style>

<!-- ─── Markup ─────────────────────────────────────────────── -->
<section class="uncouch-privacy" data-section="uncouch-privacy">
    <div class="uncouch-privacy__card">
        <div class="uncouch-privacy__icon" aria-hidden="true">🔒</div>
        <h2 class="uncouch-privacy__heading"><?= esc_html($heading) ?></h2>
        <p class="uncouch-privacy__body"><?= esc_html($body) ?></p>
        <span class="uncouch-privacy__chip">
            <span aria-hidden="true">✓</span>
            Works entirely on your iPhone — no account required
        </span>
        <p class="uncouch-privacy__policy">
            Read the full <a href="<?= esc_url($policy_url) ?>">Privacy Policy</a>.
        </p>
    </div>
</section>
