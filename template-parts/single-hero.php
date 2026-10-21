<?php
/**
 * Hero das singles dos CPTs (Soluções, Modelos de Negócio e Cases)
 *
 * $args['badge_fallback'] — badge usado quando o campo está vazio
 * $args['meta']           — array opcional de "Rótulo => Valor" exibido abaixo do subtítulo
 */

$post_id = get_the_ID();
$prefix  = 'agencia_single_';

$badge = get_post_meta($post_id, $prefix . 'badge', true);
if (empty($badge) && !empty($args['badge_fallback'])) {
    $badge = $args['badge_fallback'];
}

$title = get_post_meta($post_id, $prefix . 'title', true);
if (empty($title)) {
    $title = get_the_title();
}

$subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);
if (empty($subtitle) && has_excerpt()) {
    $subtitle = get_the_excerpt();
}

$cta_text = get_post_meta($post_id, $prefix . 'cta_text', true);
$cta_link = get_post_meta($post_id, $prefix . 'cta_link', true);

$meta = !empty($args['meta']) ? array_filter($args['meta']) : array();
?>

<section class="hero-single">
    <div class="container">
        <div class="hero-txt">
            <?php if ($badge) : ?>
                <div class="badge-section">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="3" cy="3" r="3" fill="#FFE700" />
                    </svg>
                    <?php echo esc_html($badge); ?>
                </div>
            <?php endif; ?>

            <h1><?php echo wp_kses_post($title); ?></h1>

            <?php if ($subtitle) : ?>
                <p><?php echo wp_kses_post($subtitle); ?></p>
            <?php endif; ?>

            <?php if ($meta) : ?>
                <ul class="hero-single__meta">
                    <?php foreach ($meta as $label => $value) : ?>
                        <li><span><?php echo esc_html($label); ?></span><?php echo esc_html($value); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if ($cta_text && $cta_link) : ?>
            <div class="btn-hero">
                <a href="<?php echo esc_url($cta_link); ?>" class="btn-primary"><?php echo esc_html($cta_text); ?>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M13.4793 10.8335H3.3335V9.16683H13.4793L8.81266 4.50016L10.0002 3.3335L16.6668 10.0002L10.0002 16.6668L8.81266 15.5002L13.4793 10.8335Z" fill="#292928" />
                    </svg>
                </a>
            </div>
        <?php endif; ?>

        <?php if (has_post_thumbnail()) : ?>
            <div class="hero-single__image">
                <?php the_post_thumbnail('full', array(
                    'loading'       => 'eager',
                    'fetchpriority' => 'high',
                    'decoding'      => 'async',
                    'alt'           => esc_attr(get_the_title()),
                )); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
