<?php

/**
 * CTA antes do rodapé (singles de Soluções e Modelos de Negócio)
 *
 * Args: heading (*amarelo* e quebras de linha), text, button_text, button_link,
 *       empresas_numero e empresas_texto (bloco com avatares acima do título, opcional)
 */

$args = wp_parse_args($args, array(
    'heading'         => '',
    'text'            => '',
    'button_text'     => '',
    'button_link'     => '',
    'empresas_numero' => '',
    'empresas_texto'  => '',
));

$img_dir     = get_template_directory_uri() . '/assets/images';
$button_link = $args['button_link'] ? $args['button_link'] : '#form-solucao';
?>

<section class="cta cta-solucao">
    <div class="cta-solucao__circulos" aria-hidden="true"></div>
    <div class="container">
        <div class="title-section">
            <?php if ($args['empresas_numero'] || $args['empresas_texto']) : ?>
                <div class="cta-empresas">
                    <div class="cta-empresas__pessoas" aria-hidden="true">
                        <?php foreach (array(1, 2, 3) as $n) : ?>
                            <img src="<?php echo esc_url($img_dir . '/modelos/avatar-' . $n . '.webp'); ?>" alt="" width="42" height="42" loading="lazy">
                        <?php endforeach; ?>
                    </div>
                    <div class="cta-empresas__txt">
                        <?php if ($args['empresas_numero']) : ?><strong><?php echo esc_html($args['empresas_numero']); ?></strong><?php endif; ?>
                        <?php if ($args['empresas_texto']) : ?><span><?php echo esc_html($args['empresas_texto']); ?></span><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <h2><?php echo agencia_solucao_cta_heading_html($args['heading']); ?></h2>
            <?php if ($args['text']) : ?>
                <p><?php echo nl2br(esc_html($args['text'])); ?></p>
            <?php endif; ?>
            <?php if ($args['button_text']) : ?>
                <div class="btn-cta">
                    <a href="<?php echo esc_url($button_link); ?>" class="btn-primary"><?php echo esc_html($args['button_text']); ?>
                        <img src="<?php echo esc_url($img_dir . '/solucoes/seta.svg'); ?>" alt="" width="20" height="20">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
