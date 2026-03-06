<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<style>
.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background-color: var(--color-bg);
    border-bottom: 1px solid var(--color-border);
    box-shadow: var(--shadow-sm);
}

.site-header__container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 4rem;
}

.site-header__logo {
    font-family: var(--font-heading);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-text);
    text-decoration: none;
}

.site-header__logo:hover {
    color: var(--color-primary);
}

.site-header__nav ul {
    display: flex;
    gap: var(--spacing-lg);
    list-style: none;
}

.site-header__nav a {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--color-text);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.site-header__nav a:hover,
.site-header__nav .current-menu-item a {
    color: var(--color-primary);
}

.site-header__toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: var(--spacing-sm);
    color: var(--color-text);
}

.site-header__toggle svg {
    width: 1.5rem;
    height: 1.5rem;
}

@media (max-width: 767px) {
    .site-header__nav {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: var(--color-bg);
        border-bottom: 1px solid var(--color-border);
        box-shadow: var(--shadow-md);
        padding: var(--spacing-md);
    }

    .site-header__nav.is-open {
        display: block;
    }

    .site-header__nav ul {
        flex-direction: column;
        gap: 0;
    }

    .site-header__nav a {
        display: block;
        padding: var(--spacing-sm) 0;
    }

    .site-header__toggle {
        display: block;
    }
}
</style>

<header class="site-header">
    <div class="site-header__container container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo">
            <?php echo esc_html(get_bloginfo('name')); ?>
        </a>

        <nav class="site-header__nav" id="primary-nav" aria-label="<?php esc_attr_e('Primary navigation', 'flavor'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 2,
            ]);
            ?>
        </nav>

        <button class="site-header__toggle" id="menu-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="<?php esc_attr_e('Toggle menu', 'flavor'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</header>

<script>
(function () {
    var toggle = document.getElementById('menu-toggle');
    var nav = document.getElementById('primary-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', function () {
        var expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!expanded));
        nav.classList.toggle('is-open');
    });
})();
</script>
