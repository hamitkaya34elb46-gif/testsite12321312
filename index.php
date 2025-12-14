<?php get_header(); ?>

<div class="content-wrapper"
    style="padding-top: 120px; padding-bottom: 60px; max-width: 1200px; margin: 0 auto; width: 90%;">
    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 30px; text-align: center;">
                    <h1 class="entry-title" style="font-family: 'Playfair Display', serif; font-size: 3rem; color: #1a1a1a;">
                        <?php the_title(); ?></h1>
                </header>

                <div class="entry-content" style="font-family: 'Poppins', sans-serif; line-height: 1.8;">
                    <?php
                    if (has_post_thumbnail()) {
                        echo '<div style="margin-bottom: 30px; border-radius: 10px; overflow: hidden;">';
                        the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; display: block;'));
                        echo '</div>';
                    }

                    the_content();
                    ?>
                </div>
            </article>
        <?php endwhile;
    else:
        echo '<p>İçerik bulunamadı.</p>';
    endif; ?>
</div>

<?php get_footer(); ?>