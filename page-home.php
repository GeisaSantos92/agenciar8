<?php
/*
Template Name: Home
*/

get_header();

$prefix = 'agencia_hero_';
$post_id = get_the_ID();

// Badge
$badge_image_id = get_post_meta($post_id, $prefix . 'badge_image_id', true);
$badge_image_url = get_post_meta($post_id, $prefix . 'badge_image', true);
$badge_number = get_post_meta($post_id, $prefix . 'badge_number', true);
$badge_label = get_post_meta($post_id, $prefix . 'badge_label', true);

// Hero Text
$hero_title = get_post_meta($post_id, $prefix . 'title', true);
$hero_subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);

// CTA
$cta_text = get_post_meta($post_id, $prefix . 'cta_text', true);
$cta_link = get_post_meta($post_id, $prefix . 'cta_link', true);

// Mosaic Image
$mosaic_image_id = get_post_meta($post_id, $prefix . 'mosaic_image_id', true);
$mosaic_image_url = get_post_meta($post_id, $prefix . 'mosaic_image', true);

// Logos Marquee
$client_logos = get_post_meta($post_id, 'agencia_marquee_client_logos', true);

// Differential Section
$prefix_diff = 'agencia_diferencial_';
$diff_badge = get_post_meta($post_id, $prefix_diff . 'badge', true);
$diff_title = get_post_meta($post_id, $prefix_diff . 'title', true);
$diff_subtitle = get_post_meta($post_id, $prefix_diff . 'subtitle', true);
$diff_cards = get_post_meta($post_id, $prefix_diff . 'group', true);

// Solutions Section
$prefix_sol = 'agencia_solucoes_';
$sol_badge = get_post_meta($post_id, $prefix_sol . 'badge', true);
$sol_title = get_post_meta($post_id, $prefix_sol . 'title', true);
$sol_subtitle = get_post_meta($post_id, $prefix_sol . 'subtitle', true);
$sol_cards = get_post_meta($post_id, $prefix_sol . 'group', true);

// Resultados Section
$prefix_res = 'agencia_resultados_';
$res_title = get_post_meta($post_id, $prefix_res . 'title', true);
$res_cards = get_post_meta($post_id, $prefix_res . 'group', true);

// Performance Section
$prefix_perf = 'agencia_performance_';
$perf_badge = get_post_meta($post_id, $prefix_perf . 'badge', true);
$perf_title = get_post_meta($post_id, $prefix_perf . 'title', true);
$perf_subtitle = get_post_meta($post_id, $prefix_perf . 'subtitle', true);
$perf_cards = get_post_meta($post_id, $prefix_perf . 'group', true);

// Video Section
$prefix_vid = 'agencia_video_';
$vid_badge = get_post_meta($post_id, $prefix_vid . 'badge', true);
$vid_title = get_post_meta($post_id, $prefix_vid . 'title', true);
$vid_url = get_post_meta($post_id, $prefix_vid . 'url', true);
$vid_cover = get_post_meta($post_id, $prefix_vid . 'cover', true);
$vid_cover_id = get_post_meta($post_id, $prefix_vid . 'cover_id', true);
$vid_cta_text = get_post_meta($post_id, $prefix_vid . 'cta_text', true);
$vid_cta_link = get_post_meta($post_id, $prefix_vid . 'cta_link', true);

// Certificações Section
$prefix_cert = 'agencia_certificacoes_';
$cert_title = get_post_meta($post_id, $prefix_cert . 'title', true);
$cert_logos = get_post_meta($post_id, $prefix_cert . 'logos', true);

// Metodologia Section
$prefix_met = 'agencia_metodologia_';
$met_badge = get_post_meta($post_id, $prefix_met . 'badge', true);
$met_title = get_post_meta($post_id, $prefix_met . 'title', true);
$met_subtitle = get_post_meta($post_id, $prefix_met . 'subtitle', true);
$met_steps = get_post_meta($post_id, $prefix_met . 'group', true);

// Impulsionar Section
$prefix_imp = 'agencia_impulsionar_';
$imp_title = get_post_meta($post_id, $prefix_imp . 'title', true);
$imp_subtitle = get_post_meta($post_id, $prefix_imp . 'subtitle', true);
$imp_cta_text = get_post_meta($post_id, $prefix_imp . 'cta_text', true);
$imp_cta_link = get_post_meta($post_id, $prefix_imp . 'cta_link', true);
$imp_image_id = get_post_meta($post_id, $prefix_imp . 'image_id', true);
$imp_image_url = get_post_meta($post_id, $prefix_imp . 'image', true);
?>

<section class="hero" id="home">
    <div class="container">
        <?php if ($badge_image_id || $badge_image_url || $badge_number || $badge_label) : ?>
            <div class="badge-hero">
                <?php if ($badge_image_id || $badge_image_url) : ?>
                    <div class="img-badge">
                        <?php
                        if ($badge_image_id) {
                            echo wp_get_attachment_image($badge_image_id, 'full', false, array(
                                'loading' => 'eager',
                                'decoding' => 'async',
                                'alt' => esc_attr($badge_label),
                            ));
                        } else {
                            echo '<img src="' . esc_url($badge_image_url) . '" alt="' . esc_attr($badge_label) . '" loading="eager" decoding="async">';
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($badge_number || $badge_label) : ?>
                    <div class="txt-badge">
                        <?php if ($badge_number) : ?><strong><?php echo esc_html($badge_number); ?></strong><?php endif; ?>
                        <?php if ($badge_label) : ?><span><?php echo esc_html($badge_label); ?></span><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($hero_title || $hero_subtitle || ($cta_text && $cta_link)) : ?>
            <div class="hero-txt">
                <?php if ($hero_title) : ?><h1><?php echo wp_kses_post($hero_title); ?></h1><?php endif; ?>
                <?php if ($hero_subtitle) : ?><p><?php echo wp_kses_post($hero_subtitle); ?></p><?php endif; ?>
                <div class="btn-hero">
                    <a href="<?php echo esc_url($cta_link); ?>" class="btn-primary"><?php echo esc_html($cta_text); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_13456_1627" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="14" height="14">
                                <path d="M13.4793 10.8333H3.3335V9.16658H13.4793L8.81266 4.49992L10.0002 3.33325L16.6668 9.99992L10.0002 16.6666L8.81266 15.4999L13.4793 10.8333Z" fill="#1C1B1F" />
                            </mask>
                            <g mask="url(#mask0_13456_1627)">
                                <rect width="20" height="20" fill="#292928" />
                            </g>
                        </svg>
                    </a>
                </div>

            </div>
        <?php endif; ?>
    </div>

    <?php if ($mosaic_image_id || $mosaic_image_url) : ?>
        <div class="hero-image">
            <?php
            if ($mosaic_image_id) {
                echo wp_get_attachment_image($mosaic_image_id, 'full', false, array(
                    'loading' => 'eager',
                    'decoding' => 'sync',
                    'fetchpriority' => 'high',
                    'alt' => esc_attr(wp_strip_all_tags($hero_title)),
                ));
            } else {
                echo '<img src="' . esc_url($mosaic_image_url) . '" alt="' . esc_attr(wp_strip_all_tags($hero_title)) . '" fetchpriority="high" loading="eager" decoding="sync">';
            }
            ?>
        </div>
    <?php endif; ?>
</section>

<?php if ($client_logos) : ?>
    <section class="clients-marquee" aria-label="Empresas parceiras">
        <div class="marquee-track">

            <div class="marquee-group">
                <?php
                $index = 1;
                foreach ($client_logos as $attachment_id => $logo_url) {
                    $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                    if (!$alt_text) {
                        $alt_text = 'Logo ' . $index;
                    }
                    echo wp_get_attachment_image($attachment_id, 'full', false, array(
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'alt' => esc_attr($alt_text),
                    ));
                    $index++;
                }
                ?>
            </div>

            <!-- duplicado -->
            <div class="marquee-group" aria-hidden="true">
                <?php
                foreach ($client_logos as $attachment_id => $logo_url) {
                    echo wp_get_attachment_image($attachment_id, 'full', false, array(
                        'alt' => '',
                    ));
                }
                ?>
            </div>

        </div>
    </section>
<?php endif; ?>

<?php if ($diff_badge || $diff_title || $diff_subtitle || $diff_cards) : ?>
    <section class="diferencial">
        <div class="container">
            <?php if ($diff_badge) : ?>
                <div class="badge-section">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($diff_badge); ?>
                </div>
            <?php endif; ?>
            <?php if ($diff_title || $diff_subtitle) : ?>
                <div class="title-section">
                    <?php if ($diff_title) : ?><h2><?php echo wp_kses_post($diff_title); ?></h2><?php endif; ?>
                    <?php if ($diff_subtitle) : ?><p><?php echo wp_kses_post($diff_subtitle); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($diff_cards) : ?>
                <div class="grid-card-diferencial">
                    <?php
                    foreach ($diff_cards as $card) :
                        $card_title       = isset($card['title']) ? $card['title'] : '';
                        $card_desc        = isset($card['description']) ? $card['description'] : '';
                        $card_image_id    = isset($card['image_id']) ? $card['image_id'] : '';
                        $card_image_url   = isset($card['image']) ? $card['image'] : '';
                    ?>
                        <div class="card-diferencial">
                            <div class="img-card-diferencial">
                                <?php
                                if ($card_image_id) {
                                    echo wp_get_attachment_image($card_image_id, 'full', false, array(
                                        'loading' => 'lazy',
                                        'decoding' => 'async',
                                        'alt' => esc_attr($card_title),
                                    ));
                                } elseif ($card_image_url) {
                                    echo '<img src="' . esc_url($card_image_url) . '" alt="' . esc_attr($card_title) . '" loading="lazy" decoding="async">';
                                }
                                ?>
                            </div>
                            <?php if ($card_title) : ?>
                                <div class="title-card-diferencial">
                                    <h3><?php echo wp_kses_post($card_title); ?></h3>
                                </div>
                            <?php endif; ?>
                            <?php if ($card_desc) : ?>
                                <div class="desc-diferencial">
                                    <p><?php echo wp_kses_post($card_desc); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>


<?php if ($sol_badge || $sol_title || $sol_subtitle || $sol_cards) : ?>
    <section class="solucoes">
        <div class="container">
            <?php if ($sol_badge) : ?>
                <div class="badge-section badge-white">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($sol_badge); ?>
                </div>
            <?php endif; ?>
            <?php if ($sol_title || $sol_subtitle) : ?>
                <div class="title-section title-white">
                    <?php if ($sol_title) : ?><h2><?php echo wp_kses_post($sol_title); ?></h2><?php endif; ?>
                    <?php if ($sol_subtitle) : ?><p><?php echo wp_kses_post($sol_subtitle); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($sol_cards) : ?>
                <div class="grid-solucoes">
                    <?php
                    foreach ($sol_cards as $card) :
                        $card_title     = isset($card['title']) ? $card['title'] : '';
                        $card_image_id  = isset($card['image_id']) ? $card['image_id'] : '';
                        $card_image_url = isset($card['image']) ? $card['image'] : '';
                        $items_raw      = isset($card['items']) ? $card['items'] : '';
                        $items          = array_filter(array_map('trim', explode("\n", $items_raw)));
                    ?>
                        <div class="card-solucao">
                            <?php
                            if ($card_image_id) {
                                echo wp_get_attachment_image($card_image_id, 'full', false, array(
                                    'loading' => 'lazy',
                                    'decoding' => 'async',
                                    'alt' => esc_attr($card_title),
                                ));
                            } elseif ($card_image_url) {
                                echo '<img src="' . esc_url($card_image_url) . '" alt="' . esc_attr($card_title) . '" loading="lazy" decoding="async">';
                            }
                            ?>
                            <div class="overlay-solucao"></div>
                            <div class="conteudo-solucao">
                                <?php if ($card_title) : ?>
                                    <h3><?php echo wp_kses_post($card_title); ?></h3>
                                <?php endif; ?>
                                <?php if ($items) : ?>
                                    <ul>
                                        <?php foreach ($items as $item) : ?>
                                            <li><?php echo esc_html($item); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($res_title || !empty($res_cards)) : ?>
    <section class="resultados-cards">
        <div class="container">
            <?php if ($res_title) : ?>
                <div class="title-section">
                    <h2><?php echo esc_html($res_title); ?></h2>
                </div>
            <?php endif; ?>
            <?php if (!empty($res_cards)) : ?>
                <div class="cards-resultados">
                    <?php foreach ($res_cards as $card) :
                        $number = isset($card['number']) ? $card['number'] : '';
                        $label  = isset($card['label']) ? $card['label'] : '';
                        if ($number || $label) :
                    ?>
                            <div class="box-resultado">
                                <?php if ($number) : ?><strong><?php echo esc_html($number); ?></strong><?php endif; ?>
                                <?php if ($label) : ?><p><?php echo esc_html($label); ?></p><?php endif; ?>
                            </div>
                    <?php
                        endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($perf_badge || $perf_title || $perf_subtitle || !empty($perf_cards)) : ?>
    <section class="performance">
        <div class="container">

            <?php if ($perf_badge) : ?>
                <div class="badge-section">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($perf_badge); ?>
                </div>
            <?php endif; ?>

            <?php if ($perf_title || $perf_subtitle) : ?>
                <div class="title-section">
                    <?php if ($perf_title) : ?>
                        <h2><?php echo esc_html($perf_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($perf_subtitle) : ?>
                        <p><?php echo esc_html($perf_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($perf_cards)) : ?>
            <div class="performance__slider">
                <div class="performance__track">
                    <?php foreach ($perf_cards as $card) :
                        $logo_id  = isset($card['logo_id']) ? $card['logo_id'] : '';
                        $logo_url = isset($card['logo']) ? $card['logo'] : '';
                        $num1     = isset($card['num1']) ? $card['num1'] : '';
                        $desc1    = isset($card['desc1']) ? $card['desc1'] : '';
                        $num2     = isset($card['num2']) ? $card['num2'] : '';
                        $desc2    = isset($card['desc2']) ? $card['desc2'] : '';
                    ?>
                        <div class="performance-card">
                            <?php
                            if ($logo_id) {
                                echo wp_get_attachment_image($logo_id, 'full', false, array(
                                    'loading' => 'lazy',
                                    'alt'     => '',
                                ));
                            } elseif ($logo_url) {
                                echo '<img src="' . esc_url($logo_url) . '" alt="" loading="lazy">';
                            }
                            ?>
                            <div class="box-performance">
                                <?php if ($num1 || $desc1) : ?>
                                    <div class="box-card-performance">
                                        <?php if ($num1) : ?><h3><?php echo esc_html($num1); ?></h3><?php endif; ?>
                                        <?php if ($desc1) : ?><p><?php echo esc_html($desc1); ?></p><?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($num2 || $desc2) : ?>
                                    <div class="box-card-performance">
                                        <?php if ($num2) : ?><h3><?php echo esc_html($num2); ?></h3><?php endif; ?>
                                        <?php if ($desc2) : ?><p><?php echo esc_html($desc2); ?></p><?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php if ($vid_badge || $vid_title || $vid_url || $vid_cover || $vid_cta_text) : ?>
    <section class="video">
        <div class="container">
            <?php if ($vid_badge) : ?>
                <div class="badge-section badge-white">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($vid_badge); ?>
                </div>
            <?php endif; ?>

            <?php if ($vid_title) : ?>
                <div class="title-section title-white">
                    <h2><?php echo esc_html($vid_title); ?></h2>
                </div>
            <?php endif; ?>

            <?php if ($vid_url || $vid_cover) : ?>
                <div class="box-video" id="video-container" data-video-url="<?php echo esc_url($vid_url); ?>">
                    <?php if ($vid_cover || $vid_cover_id) : ?>
                        <div class="video-cover" id="video-cover-btn">
                            <?php
                            if ($vid_cover_id) {
                                echo wp_get_attachment_image($vid_cover_id, 'full', false, array(
                                    'loading' => 'lazy',
                                    'alt'     => esc_attr($vid_title),
                                ));
                            } else {
                                echo '<img src="' . esc_url($vid_cover) . '" alt="' . esc_attr($vid_title) . '" loading="lazy">';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var coverBtn = document.getElementById('video-cover-btn');
                        if (coverBtn) {
                            coverBtn.addEventListener('click', function() {
                                var container = document.getElementById('video-container');
                                if (!container) return;
                                var videoUrl = container.getAttribute('data-video-url');
                                if (!videoUrl) return;

                                var embedUrl = videoUrl;
                                if (videoUrl.includes('youtube.com/watch?v=')) {
                                    var videoId = videoUrl.split('v=')[1];
                                    var ampersandPosition = videoId.indexOf('&');
                                    if (ampersandPosition !== -1) {
                                        videoId = videoId.substring(0, ampersandPosition);
                                    }
                                    embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
                                } else if (videoUrl.includes('youtu.be/')) {
                                    var videoId = videoUrl.split('youtu.be/')[1];
                                    var ampersandPosition = videoId.indexOf('&');
                                    if (ampersandPosition !== -1) {
                                        videoId = videoId.substring(0, ampersandPosition);
                                    }
                                    embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
                                } else if (videoUrl.includes('vimeo.com/')) {
                                    var videoId = videoUrl.split('vimeo.com/')[1];
                                    embedUrl = 'https://player.vimeo.com/video/' + videoId + '?autoplay=1';
                                }

                                var iframe = document.createElement('iframe');
                                iframe.setAttribute('src', embedUrl);
                                iframe.setAttribute('frameborder', '0');
                                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
                                iframe.setAttribute('allowfullscreen', '1');

                                container.innerHTML = '';
                                container.appendChild(iframe);
                            });
                        }
                    });
                </script>
            <?php endif; ?>

            <?php if ($vid_cta_text && $vid_cta_link) : ?>
                <div class="btn-hero">
                    <a href="<?php echo esc_url($vid_cta_link); ?>" class="btn-primary">
                        <?php echo esc_html($vid_cta_text); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_13456_1627" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="14" height="14">
                                <path d="M13.4793 10.8333H3.3335V9.16658H13.4793L8.81266 4.49992L10.0002 3.33325L16.6668 9.99992L10.0002 16.6666L8.81266 15.4999L13.4793 10.8333Z" fill="#1C1B1F" />
                            </mask>
                            <g mask="url(#mask0_13456_1627)">
                                <rect width="20" height="20" fill="#292928" />
                            </g>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>



<?php if ($cert_title || !empty($cert_logos)) : ?>
    <section class="certificacoes">
        <div class="container">
            <?php if ($cert_title) : ?>
                <div class="title-section title-white">
                    <h2><?php echo esc_html($cert_title); ?></h2>
                </div>
            <?php endif; ?>
            <?php if (!empty($cert_logos)) : ?>
                <div class="box-logos-brand">
                    <?php foreach ($cert_logos as $logo_id => $logo_url) : ?>
                        <?php
                        echo wp_get_attachment_image($logo_id, 'full', false, array(
                            'loading' => 'lazy',
                            'alt'     => '',
                        ));
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($met_badge || $met_title || $met_subtitle || !empty($met_steps)) : ?>
    <section class="metodologia performance">
        <div class="container">
            <?php if ($met_badge) : ?>
                <div class="badge-section badge-white">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($met_badge); ?>
                </div>
            <?php endif; ?>

            <?php if ($met_title || $met_subtitle) : ?>
                <div class="title-section title-white">
                    <?php if ($met_title) : ?><h2><?php echo wp_kses_post($met_title); ?></h2><?php endif; ?>
                    <?php if ($met_subtitle) : ?><p><?php echo wp_kses_post($met_subtitle); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>


            <?php if (!empty($met_steps)) : ?>
                <section class="cards-metodologia">
                    <?php
                    $index = 0;
                    foreach ($met_steps as $step) :
                        $step_num   = isset($step['numero']) ? $step['numero'] : '';
                        $step_title = isset($step['title']) ? $step['title'] : '';
                        $step_desc  = isset($step['description']) ? $step['description'] : '';
                        $active_class = ($index === 0) ? ' active' : '';
                    ?>
                        <div class="card-metodologia<?php echo esc_attr($active_class); ?>">
                            <?php if ($step_num) : ?><span class="numero"><?php echo esc_html($step_num); ?></span><?php endif; ?>

                            <?php if ($step_title) : ?><h3><?php echo esc_html($step_title); ?></h3><?php endif; ?>

                            <?php if ($step_desc) : ?>
                                <p>
                                    <?php echo esc_html($step_desc); ?>
                                </p>
                            <?php endif; ?>

                            <button class="toggle" aria-label="<?php echo esc_attr($step_title ? $step_title : 'Ver etapa'); ?>">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="outer-circle" cx="8" cy="8" r="7.5" />
                                    <circle class="inner-circle" cx="8" cy="8" r="4" />
                                </svg>
                            </button>
                        </div>
                    <?php
                        $index++;
                    endforeach;
                    ?>
                </section>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($imp_title || $imp_subtitle) : ?>
    <section class="impulsionar">
        <div class="container">
            <div class="box-impulsionar">
                <div class="left-impulso">
                    <div class="title-section title-white">
                        <?php if ($imp_title) : ?><h2><?php echo wp_kses_post($imp_title); ?></h2><?php endif; ?>
                        <?php if ($imp_subtitle) : ?><p><?php echo wp_kses_post($imp_subtitle); ?></p><?php endif; ?>
                        <?php if ($imp_cta_text && $imp_cta_link) : ?>
                            <div class="btn-hero">
                                <a href="<?php echo esc_url($imp_cta_link); ?>" class="btn-primary btn-black"><?php echo esc_html($imp_cta_text); ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_13456_1627" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="14" height="14">
                                            <path d="M13.4793 10.8333H3.3335V9.16658H13.4793L8.81266 4.49992L10.0002 3.33325L16.6668 9.99992L10.0002 16.6666L8.81266 15.4999L13.4793 10.8333Z" fill="#1C1B1F" />
                                        </mask>
                                        <g mask="url(#mask0_13456_1627)">
                                            <rect width="20" height="20" fill="#292928" />
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($imp_image_id || $imp_image_url) : ?>
                    <div class="right-impulso">
                        <?php
                        if ($imp_image_id) {
                            echo wp_get_attachment_image($imp_image_id, 'full', false, array(
                                'loading' => 'lazy',
                                'alt'     => esc_attr(wp_strip_all_tags($imp_title)),
                            ));
                        } else {
                            echo '<img src="' . esc_url($imp_image_url) . '" alt="' . esc_attr(wp_strip_all_tags($imp_title)) . '" loading="lazy">';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>