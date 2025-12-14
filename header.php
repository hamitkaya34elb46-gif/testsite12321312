<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div class="preloader" id="preloader">
        <div class="preloader-content">
            <div class="logo-loader">
                <span class="logo-text-loader">MODEL</span>
                <span class="logo-accent-loader">AJANS</span>
            </div>

            <div class="loading-messages">
                <h2 class="loading-text" id="loading-text">Kameralar hazırlanıyor...</h2>
            </div>

            <div class="loading-bar-container">
                <div class="loading-bar" id="loading-bar"></div>
            </div>

            <div class="loading-percentage" id="loading-percentage">0%</div>
        </div>
    </div>

    <div class="curtain-top" id="curtain-top"></div>
    <div class="curtain-bottom" id="curtain-bottom"></div>

    <div class="main-content" id="main-content">

        <header class="header-wrapper" id="header-wrapper">

            <div class="top-bar" id="top-bar">
                <div class="top-bar-container">
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg class="contact-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span class="contact-text">info@modelsagency.com</span>
                        </div>
                        <div class="contact-item">
                            <svg class="contact-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <span class="contact-text">+90 530 910 55 90</span>
                        </div>
                        <div class="contact-item">
                            <svg class="contact-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span class="contact-text">İstanbul, Türkiye</span>
                        </div>
                    </div>

                    <div class="social-media">
                        <a href="#" class="social-link" aria-label="Instagram" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <nav class="navbar" id="navbar">
                <div class="nav-container">
                    <div class="logo">
                        <a href="<?php echo home_url(); ?>" id="logo-link">
                            <span class="logo-text">MODEL</span>
                            <span class="logo-accent">AJANS</span>
                        </a>
                    </div>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'nav-menu',
                        'fallback_cb' => false, // Fallback to manual if empty? Or just empty.
                    ));
                    ?>
                    <!-- Manual fallback if menu not set -->
                    <?php if (!has_nav_menu('primary')): ?>
                        <ul class="nav-menu">
                            <li class="nav-item"><a href="#referanslar" class="nav-link">Referanslarımız</a></li>
                            <li class="nav-item"><a href="#services" class="nav-link">Hizmetlerimiz</a></li>
                            <li class="nav-item"><a href="#basvuru" class="nav-link">Başvuru Formu</a></li>
                        </ul>
                    <?php endif; ?>

                    <div class="menu-toggle" id="mobile-menu">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </div>
            </nav>

        </header>