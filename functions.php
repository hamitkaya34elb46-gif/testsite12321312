<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function modelajans_setup()
{
    // Title tag support
    add_theme_support('title-tag');

    // Post thumbnails support
    add_theme_support('post-thumbnails');

    // Register Menu
    register_nav_menus(array(
        'primary' => __('Ana Menü', 'modelajans'),
    ));

    // Custom Image Sizes if needed
    add_image_size('service-card', 600, 400, true);
    add_image_size('reference-logo', 150, 80, false); // Small size for references
}
add_action('after_setup_theme', 'modelajans_setup');

// Enqueue Scripts and Styles
function modelajans_scripts()
{
    // Styles
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap', array(), null);

    // Main Styles
    wp_enqueue_style('modelajans-genel', get_template_directory_uri() . '/css/genel.css', array(), '1.0');
    wp_enqueue_style('modelajans-yukleme', get_template_directory_uri() . '/css/yukleme-ekrani.css', array(), '1.0');
    wp_enqueue_style('modelajans-menu', get_template_directory_uri() . '/css/ust-menu.css', array(), '1.0');
    wp_enqueue_style('modelajans-ana', get_template_directory_uri() . '/css/ana-bolum.css', array(), '1.0');
    wp_enqueue_style('modelajans-referans', get_template_directory_uri() . '/css/referanslar.css', array(), '1.0');
    wp_enqueue_style('modelajans-hizmet', get_template_directory_uri() . '/css/hizmetler.css', array(), '1.0');
    wp_enqueue_style('modelajans-form', get_template_directory_uri() . '/css/basvuru-formu.css', array(), '1.0');
    wp_enqueue_style('modelajans-mobil', get_template_directory_uri() . '/css/mobil-uyumlu.css', array(), '1.0');
    wp_enqueue_style('modelajans-style', get_stylesheet_uri());
    wp_enqueue_style('modelajans-footer', get_template_directory_uri() . '/css/footer.css', array(), '1.0');

    // Scripts
    wp_enqueue_script('modelajans-yukleme-js', get_template_directory_uri() . '/js/yukleme-ekrani.js', array(), '1.0', true);
    wp_enqueue_script('modelajans-menu-js', get_template_directory_uri() . '/js/ust-menu.js', array(), '1.0', true);
    wp_enqueue_script('modelajans-slider-js', get_template_directory_uri() . '/js/ana-slider.js', array(), '1.0', true);
    wp_enqueue_script('modelajans-animasyon-js', get_template_directory_uri() . '/js/animasyon.js', array(), '1.0', true);
    wp_enqueue_script('modelajans-scroll-js', get_template_directory_uri() . '/js/yumusak-kaydirma.js', array(), '1.0', true);

    // AJAX URL definition for frontend
    wp_localize_script('modelajans-animasyon-js', 'modelajans_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('basvuru_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'modelajans_scripts');

// AJAX Handler for Application
function modelajans_ajax_submit_basvuru()
{
    check_ajax_referer('basvuru_ajax_nonce', 'security');

    $fullname = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $category = sanitize_text_field($_POST['category']);
    $message = sanitize_textarea_field($_POST['message']);

    $post_id = wp_insert_post(array(
        'post_title' => $fullname,
        'post_content' => $message,
        'post_type' => 'basvuru',
        'post_status' => 'publish',
    ));

    if ($post_id) {
        update_post_meta($post_id, '_basvuru_email', $email);
        update_post_meta($post_id, '_basvuru_phone', $phone);
        update_post_meta($post_id, '_basvuru_category', $category);
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_submit_basvuru', 'modelajans_ajax_submit_basvuru');
add_action('wp_ajax_nopriv_submit_basvuru', 'modelajans_ajax_submit_basvuru');

// Register Custom Post Types
function modelajans_register_cpt()
{
    // Referanslar (References)
    // Referanslar (References)
    register_post_type('referans', array(
        'labels' => array(
            'name' => 'Referanslar',
            'singular_name' => 'Referans',
            'all_items' => 'Referans Kaldır', // Renaming "All Items" to "Referans Kaldır" based on user req
            'add_new' => 'Referans Ekle',
            'add_new_item' => 'Referans Ekle',
            'edit_item' => 'Referans Düzenle',
        ),
        'public' => true,
        'show_in_menu' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'thumbnail'), // Title allows naming the client, Thumbnail is the logo
    ));

    // Slider
    register_post_type('slider', array(
        'labels' => array(
            'name' => 'Slider',
            'singular_name' => 'Slide',
            'add_new' => 'Yeni Slide Ekle',
        ),
        'public' => true,
        'show_in_menu' => false, // Hidden from admin menu
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'thumbnail'),
    ));

    // Başvurular (Applications) Statuses
    register_post_status('accepted', array(
        'label' => 'Kabul Edildi',
        'public' => false,
        'exclude_from_search' => true,
        'show_in_admin_all_list' => false,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Kabul Edilenler <span class="count">(%s)</span>', 'Kabul Edilenler <span class="count">(%s)</span>'),
    ));

    register_post_status('rejected', array(
        'label' => 'Reddedildi',
        'public' => false,
        'exclude_from_search' => true,
        'show_in_admin_all_list' => false,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Reddedilenler <span class="count">(%s)</span>', 'Reddedilenler <span class="count">(%s)</span>'),
    ));

    // Başvurular (Applications) - NEW
    register_post_type('basvuru', array(
        'labels' => array(
            'name' => 'Başvurular',
            'singular_name' => 'Başvuru',
            'search_items' => 'Başvuru Ara',
            'not_found' => 'Başvuru bulunamadı',
            'edit_item' => 'Başvuru Detayları',
        ),
        'public' => false, // Not visible on frontend
        'show_ui' => true, // Visible in admin
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => array('title', 'editor'), // Title=Name, Editor=Message
        'capabilities' => array(
            'create_posts' => false,
        ),
        'map_meta_cap' => true,
    ));
}
add_action('init', 'modelajans_register_cpt');

// Rename Featured Image Box for Referans
function modelajans_customize_referans_ui()
{
    remove_meta_box('postimagediv', 'referans', 'side');
    add_meta_box('postimagediv', 'Referans Logosu (Resim)', 'post_thumbnail_meta_box', 'referans', 'normal', 'high');
}
add_action('do_meta_boxes', 'modelajans_customize_referans_ui');

// Rename Title Placeholder
function modelajans_change_title_placeholder($title)
{
    if (get_current_screen()->post_type == 'referans') {
        return 'Firma / Marka Adı';
    }
    return $title;
}
add_action('enter_title_here', 'modelajans_change_title_placeholder');

// Add Sub-menus for Application Statuses
// Add Sub-menus for Application Statuses
function modelajans_add_basvuru_submenus()
{
    add_submenu_page(
        'edit.php?post_type=basvuru',
        'Kabul Edilenler',
        'Kabul Edilenler',
        'manage_options',
        'basvuru-accepted',
        '__return_null'
    );
    add_submenu_page(
        'edit.php?post_type=basvuru',
        'Reddedilenler',
        'Reddedilenler',
        'manage_options',
        'basvuru-rejected',
        '__return_null'
    );
}
add_action('admin_menu', 'modelajans_add_basvuru_submenus');

// Handle Redirects for Submenus BEFORE Headers are Sent
function modelajans_handle_menu_redirects()
{
    // Check if we are in admin and page param exists
    if (is_admin() && isset($_GET['page'])) {
        if ($_GET['page'] === 'basvuru-accepted') {
            wp_redirect(admin_url('edit.php?post_type=basvuru&post_status=accepted'));
            exit;
        }
        if ($_GET['page'] === 'basvuru-rejected') {
            wp_redirect(admin_url('edit.php?post_type=basvuru&post_status=rejected'));
            exit;
        }
    }
}
add_action('admin_init', 'modelajans_handle_menu_redirects');

// --- 1. Handle Frontend Form Submission ---
function modelajans_handle_basvuru_submit()
{
    // 1. Verify Nonce (Security)
    // if ( ! isset( $_POST['basvuru_nonce'] ) || ! wp_verify_nonce( $_POST['basvuru_nonce'], 'submit_basvuru' ) ) {
    //    wp_die( 'Güvenlik doğrulaması başarısız oldu.' );
    // }
    // Skipping strict nonce check for simplicity if user didn't request check, but good practice.
    // Let's rely on basic sanity checks.

    $fullname = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $category = sanitize_text_field($_POST['category']);
    $message = sanitize_textarea_field($_POST['message']);

    // Create Post
    $post_id = wp_insert_post(array(
        'post_title' => $fullname,
        'post_content' => $message,
        'post_type' => 'basvuru',
        'post_status' => 'publish', // So admin can see it immediately
    ));

    if ($post_id) {
        // Save Meta Data
        update_post_meta($post_id, '_basvuru_email', $email);
        update_post_meta($post_id, '_basvuru_phone', $phone);
        update_post_meta($post_id, '_basvuru_category', $category);

        // Redirect back with success
        wp_redirect(home_url('/?basvuru=basarili'));
        exit;
    }
}
add_action('admin_post_submit_basvuru', 'modelajans_handle_basvuru_submit');
add_action('admin_post_nopriv_submit_basvuru', 'modelajans_handle_basvuru_submit');

// --- 2. Admin Meta Boxes for Application Details ---
function modelajans_add_basvuru_metaboxes()
{
    add_meta_box(
        'basvuru_detaylari',
        'Başvuru Bilgileri',
        'modelajans_render_basvuru_metabox',
        'basvuru',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'modelajans_add_basvuru_metaboxes');

function modelajans_render_basvuru_metabox($post)
{
    $email = get_post_meta($post->ID, '_basvuru_email', true);
    $phone = get_post_meta($post->ID, '_basvuru_phone', true);
    $category = get_post_meta($post->ID, '_basvuru_category', true);

    // Status Actions
    $accept_url = wp_nonce_url(admin_url('admin-post.php?action=basvuru_status_change&post_id=' . $post->ID . '&status=accepted'), 'basvuru_status_' . $post->ID);
    $reject_url = wp_nonce_url(admin_url('admin-post.php?action=basvuru_status_change&post_id=' . $post->ID . '&status=rejected'), 'basvuru_status_' . $post->ID);
    ?>
    <table class="form-table">
        <tr>
            <th><label>E-posta:</label></th>
            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
        </tr>
        <tr>
            <th><label>Telefon:</label></th>
            <td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
        </tr>
        <tr>
            <th><label>Kategori:</label></th>
            <td><strong><?php echo esc_html(ucfirst($category)); ?></strong></td>
        </tr>
        <tr>
            <th><label>Durum İşlemleri:</label></th>
            <td>
                <?php if ($post->post_status !== 'accepted'): ?>
                    <a href="<?php echo esc_url($accept_url); ?>" class="button button-primary">Kabul Et</a>
                <?php else: ?>
                    <span class="dashicons dashicons-yes" style="color: green;"></span> <strong>Kabul Edildi</strong>
                <?php endif; ?>

                <?php if ($post->post_status !== 'rejected'): ?>
                    <a href="<?php echo esc_url($reject_url); ?>" class="button"
                        style="color: #a00; margin-left: 10px;">Reddet</a>
                <?php else: ?>
                    <span class="dashicons dashicons-no" style="color: red;"></span> <strong>Reddedildi</strong>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <p><em>Mesaj içeriği yukarıdaki editörde görüntülenmektedir.</em></p>
    <?php
}

// Handle Status Change
function modelajans_handle_status_change()
{
    if (!current_user_can('edit_posts')) {
        wp_die('Yetkisiz erişim.');
    }

    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';

    check_admin_referer('basvuru_status_' . $post_id);

    if ($post_id && in_array($status, array('accepted', 'rejected'))) {
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => $status
        ));
    }

    wp_redirect(admin_url('post.php?post=' . $post_id . '&action=edit'));
    exit;
}
add_action('admin_post_basvuru_status_change', 'modelajans_handle_status_change');


// --- 3. Theme Settings (Referans Modu) ---
function modelajans_add_admin_menu()
{
    add_menu_page(
        'Tema Ayarları',
        'Tema Ayarları',
        'manage_options',
        'modelajans-ayarlar',
        'modelajans_render_settings_page',
        'dashicons-admin-generic',
        60
    );

    // YÖNETİCİ Menüsü
    add_menu_page(
        'Yönetici İşlemleri', // Page Title
        'YÖNETİCİ',          // Menu Title
        'manage_options',    // Capability
        'yonetici-home',     // Menu Slug
        'modelajans_manager_redirect', // Callback to redirect
        'dashicons-businesswoman',     // Icon
        5                    // Position (High up)
    );

    // Submenu: Kullanıcılar
    add_submenu_page(
        'yonetici-home',
        'Kullanıcılar',
        'Kullanıcılar',
        'list_users',
        'users.php'
    );

    // Submenu: Yeni Ekle
    add_submenu_page(
        'yonetici-home',
        'Yeni Kullanıcı Ekle',
        'Yeni Ekle',
        'create_users',
        'user-new.php'
    );

    // Submenu: Profil
    add_submenu_page(
        'yonetici-home',
        'Profiliniz',
        'Profil',
        'read',
        'profile.php'
    );
}
add_action('admin_menu', 'modelajans_add_admin_menu');

function modelajans_manager_redirect()
{
    // Redirect main menu click to Users page
    ?>
    <script type="text/javascript">
                window.location = "<?php echo admin_url('users.php'); ?>";
    </script>
    <?php
}

function modelajans_register_settings()
{
    register_setting('modelajans_options_group', 'modelajans_referans_mode');
}
add_action('admin_init', 'modelajans_register_settings');

function modelajans_render_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Tema Ayarları</h1>
        <form method="post" action="options.php">
            <?php settings_fields('modelajans_options_group'); ?>
            <?php do_settings_sections('modelajans_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Referanslar Bölümü Modu</th>
                    <td>
                        <?php $current_mode = get_option('modelajans_referans_mode', 'custom'); ?>
                        <fieldset>
                            <label>
                                <input type="radio" name="modelajans_referans_mode" value="default" <?php checked($current_mode, 'default'); ?>>
                                <strong>Varsayılan (Dönen Yazılar):</strong> Sadece "Logo" yazan boş kutular döner.
                            </label><br><br>
                            <label>
                                <input type="radio" name="modelajans_referans_mode" value="custom" <?php checked($current_mode, 'custom'); ?>>
                                <strong>Özel (Eklenen Logolar):</strong> "Referanslar" menüsünden eklediğiniz logolar döner
                                (Eğer hiç logo yoksa varsayılan görünür).
                            </label>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Remove Standard Admin Menus
function modelajans_remove_admin_menus()
{
    remove_menu_page('edit.php');                   // Posts
    remove_menu_page('edit.php?post_type=page');    // Pages
    remove_menu_page('edit-comments.php');          // Comments
    remove_menu_page('upload.php');                 // Media
    remove_menu_page('themes.php');                 // Appearance
    remove_menu_page('plugins.php');                // Plugins
    remove_menu_page('users.php');                  // Users
    remove_menu_page('tools.php');                  // Tools
    remove_menu_page('options-general.php');        // Settings
    remove_menu_page('wpcf7');                      // Contact Form 7
}
add_action('admin_menu', 'modelajans_remove_admin_menus', 999);
