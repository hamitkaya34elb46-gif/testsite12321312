<?php get_header(); ?>

<section class="hero-section">
    <div class="hero-image-container">
        <?php
        $args = array(
            'post_type' => 'slider',
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'ASC'
        );
        $slider_query = new WP_Query($args);
        $slide_count = 0;

        if ($slider_query->have_posts()):
            while ($slider_query->have_posts()):
                $slider_query->the_post();
                $active_class = ($slide_count === 0) ? 'active' : '';
                $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                if (!$bg_image) {
                    // Fallback if no featured image
                    $bg_image = get_template_directory_uri() . '/resimler/hero-1.png';
                }
                ?>
                <div class="hero-image hero-slide <?php echo esc_attr($active_class); ?>"
                    style="background-image: url('<?php echo esc_url($bg_image); ?>');"></div>
                <?php
                $slide_count++;
            endwhile;
            wp_reset_postdata();
        else:
            // Static Fallback
            ?>
            <div class="hero-image hero-slide active"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/resimler/hero-1.png');"></div>
            <div class="hero-image hero-slide"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/resimler/hero-2.png');"></div>
            <div class="hero-image hero-slide"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/resimler/hero-3.png');"></div>
            <?php
            $slide_count = 3;
        endif;
        ?>
    </div>

    <div class="hero-arrow-down">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </div>

    <div class="slider-nav">
        <button class="slider-btn prev-btn" id="prev-btn" aria-label="Onceki">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <div class="slider-dots" id="slider-dots">
            <?php for ($i = 0; $i < $slide_count; $i++): ?>
                <span class="dot <?php echo ($i === 0) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
        <button class="slider-btn next-btn" id="next-btn" aria-label="Sonraki">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>

    <div class="typing-container">
        <h1 class="typing-text" id="typing-text">MODEL AJANSI</h1>
        <span class="cursor">|</span>
    </div>

</section>

<section class="references-section" id="referanslar">
    <div class="references-container">
        <div class="section-header">
            <h2 class="section-title">Referanslarımız</h2>
            <p class="section-subtitle">Güvenilir markalarla çalışıyoruz</p>
        </div>

        <div class="logo-slider-wrapper">
            <div class="logo-slider">
                <?php
                // Check Admin Setting
                $ref_mode = get_option('modelajans_referans_mode', 'custom');

                $ref_posts_list = array();

                // Only fetch if mode is custom
                if ($ref_mode === 'custom') {
                    $ref_args = array(
                        'post_type' => 'referans',
                        'posts_per_page' => -1,
                    );
                    $ref_query = new WP_Query($ref_args);
                    if ($ref_query->have_posts()) {
                        $ref_posts_list = $ref_query->posts;
                    }
                }

                $use_fallback = empty($ref_posts_list);
                $min_items = 10;

                // Prepare Render List (The "Half Set")
                if (!$use_fallback) {
                    $half_set = $ref_posts_list;
                    while (count($half_set) < $min_items) {
                        $half_set = array_merge($half_set, $ref_posts_list);
                    }
                } else {
                    $half_set = range(1, $min_items);
                }

                // Output EXACTLY TWICE
                for ($k = 0; $k < 2; $k++):
                    foreach ($half_set as $item):
                        if (!$use_fallback) {
                            $post = $item;
                            setup_postdata($post);
                            if (has_post_thumbnail($post->ID)) {
                                ?>
                                <div class="logo-item">
                                    <?php echo get_the_post_thumbnail($post->ID, 'reference-logo', array('style' => '')); ?>
                                </div>
                                <?php
                            } else {
                                echo '<div class="logo-item">' . get_the_title($post->ID) . '</div>';
                            }
                        } else {
                            // Fallback Content
                            ?>
                            <div class="logo-item">
                                <svg width="120" height="60" viewBox="0 0 120 60" fill="none">
                                    <rect x="10" y="10" width="100" height="40" rx="5" stroke="#d4af37" stroke-width="2"
                                        fill="none" />
                                    <text x="60" y="38" font-family="Arial" font-size="16" fill="#d4af37"
                                        text-anchor="middle">LOGO</text>
                                </svg>
                            </div>
                            <?php
                        }
                    endforeach;
                endfor;

                if (!$use_fallback)
                    wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="services-container">
        <div class="section-header">
            <h2 class="section-title">Ajans Hizmetlerimiz</h2>
            <p class="section-subtitle">Profesyonel çözümler, yaratıcı yaklaşımlar</p>
        </div>

        <div class="services-grid">

            <a href="dizi-ajansi.html" class="service-card">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=600&h=400&fit=crop"
                        alt="Dizi Ajansı">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-title">Dizi Ajansı</h3>
                    <p class="service-description">Profesyonel dizi oyuncu kadromuzla projelerinize değer katıyoruz.</p>
                    <div class="service-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="reklam-ajansi.html" class="service-card">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&h=400&fit=crop"
                        alt="Reklam Ajansı">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-title">Reklam Ajansı</h3>
                    <p class="service-description">Markanızın yüzü olacak yetenekli reklam yüzleri.</p>
                    <div class="service-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="manken-ajansi.html" class="service-card">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?w=600&h=400&fit=crop"
                        alt="Manken Ajansı">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-title">Manken Ajansı</h3>
                    <p class="service-description">Defile ve katalog çekimleri için profesyonel mankenler.</p>
                    <div class="service-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="klip-ajansi.html" class="service-card">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&h=400&fit=crop"
                        alt="Klip Ajansı">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-title">Klip Ajansı</h3>
                    <p class="service-description">Müzik klipleri için yetenekli oyuncu ve dansçılar.</p>
                    <div class="service-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="tiyatro-ajansi.html" class="service-card" style="opacity: 1; transform: none;">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1507676184212-d03ab07a11d0?auto=format&fit=crop&w=600&q=80"
                        alt="Tiyatro Ajansı">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-title">Tiyatro Ajansı</h3>
                    <p class="service-description">Sahne sanatları ve tiyatro projeleri için profesyonel oyuncular.</p>
                    <div class="service-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>

<section class="application-section" id="basvuru">
    <div class="application-container">
        <div class="section-header">
            <h2 class="section-title">Başvuru Formu</h2>
            <p class="section-subtitle">Bizimle çalışmak için başvurunuzu iletin</p>
        </div>

        <!-- Success Popup (Hidden by default) -->
        <div id="success-popup" class="success-popup"
            style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10000; background: rgba(0,0,0,0.9); border: 2px solid #d4af37; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 0 20px rgba(212, 175, 55, 0.3); max-width: 90%; width: 400px;">
            <div class="popup-content" style="color: #fff;">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2"
                    style="margin-bottom: 20px;">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <h3 style="color: #d4af37; margin-bottom: 10px; font-family: 'Playfair Display', serif;">Başvurunuz
                    Alınmıştır!</h3>
                <p style="color: #ccc; font-size: 14px;">En kısa sürede size dönüş yapılacaktır.</p>
            </div>
        </div>

        <form class="application-form" id="application-form" method="POST">
            <!-- No action/method needed for AJAX but keeping method for semantics -->
            <div class="form-row">
                <div class="form-group">
                    <label for="fullname">Ad Soyad *</label>
                    <input type="text" id="fullname" name="fullname" class="form-input"
                        placeholder="Adınız ve soyadınız" required>
                </div>
                <div class="form-group">
                    <label for="email">E-posta *</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="ornek@email.com"
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Telefon *</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="+90 ### ### ## ##"
                        required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select id="category" name="category" class="form-input">
                        <option value="">Seçiniz</option>
                        <option value="dizi_ajansi">Dizi Ajansı</option>
                        <option value="reklam_ajansi">Reklam Ajansı</option>
                        <option value="manken_ajansi">Manken Ajansı</option>
                        <option value="klip_ajansi">Klip Ajansı</option>
                        <option value="tiyatro_ajansi">Tiyatro Ajansı</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Mesajınız</label>
                <textarea id="message" name="message" class="form-input" rows="6"
                    placeholder="Kendinizden bahsedin..."></textarea>
            </div>

            <button type="submit" class="form-submit-btn" id="submit-btn">
                <span>Başvuru Gönder</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </form>

        <script>
            document.getElementById('application-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const btn = document.getElementById('submit-btn');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span>Gönderiliyor...</span>';
                btn.disabled = true;

                const formData = new FormData(this);
                formData.append('action', 'submit_basvuru');
                formData.append('security', modelajans_ajax.nonce);

                fetch(modelajans_ajax.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset Form
                            document.getElementById('application-form').reset();

                            // Show Popup
                            const popup = document.getElementById('success-popup');
                            popup.style.display = 'block';
                            popup.animate([
                                { opacity: 0, transform: 'translate(-50%, -60%)' },
                                { opacity: 1, transform: 'translate(-50%, -50%)' }
                            ], {
                                duration: 300,
                                fill: 'forwards'
                            });

                            // Hide after 2.5 seconds
                            setTimeout(() => {
                                popup.animate([
                                    { opacity: 1 },
                                    { opacity: 0 }
                                ], {
                                    duration: 300,
                                    fill: 'forwards'
                                }).onfinish = () => popup.style.display = 'none';
                            }, 2500);
                        } else {
                            alert('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Bir hata oluştu.');
                    })
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
            });
        </script>
    </div>
</section>

<?php get_footer(); ?>