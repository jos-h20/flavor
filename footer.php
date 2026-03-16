<style>
.site-footer {
    background-color: var(--color-bg-dark);
    color: var(--color-text-inverted);
    padding: var(--spacing-xl) 0 var(--spacing-lg);
}

.site-footer__container {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-lg);
}

.site-footer__nav ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: var(--spacing-md) var(--spacing-lg);
    list-style: none;
}

.site-footer__nav a {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.site-footer__nav a:hover {
    color: var(--color-text-inverted);
}

.site-footer__copy {
    font-size: 0.8125rem;
    color: rgba(255, 255, 255, 0.75);
}
</style>

<footer class="site-footer">
    <div class="site-footer__container">
        <nav class="site-footer__nav" aria-label="<?php esc_attr_e('Footer navigation', 'flavor'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 1,
            ]);
            ?>
        </nav>

        <p class="site-footer__copy">
            &copy; <?php echo esc_html(date('Y')); ?> Kanso Ventures LLC dba Kanso Media. All rights reserved.
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
