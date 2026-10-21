<?php
get_header();

while (have_posts()) : the_post();

    $post_id = get_the_ID();
    $img_dir = get_template_directory_uri() . '/assets/images';

    $meta = function ($key) use ($post_id) {
        return get_post_meta($post_id, 'agencia_mod_' . $key, true);
    };

    // Remove itens vazios dos repeaters para não renderizar blocos em branco
    $list = function ($key, $required) use ($meta) {
        $items = $meta($key);
        return is_array($items) ? array_filter($items, function ($item) use ($required) {
            return !empty($item[$required]);
        }) : array();
    };

    $desafios   = $list('desafios_group', 'text');
    $ajuda      = $list('ajuda_group', 'title');
    $etapas     = $list('metodologia_group', 'title');
    $resultados = $list('resultados_group', 'text');

    $badge = function ($text, $class = 'badge-white') {
        if (!$text) {
            return;
        } ?>
        <div class="badge-section <?php echo esc_attr($class); ?>">
            <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="3" cy="3" r="3" fill="#FFE700" />
            </svg>
            <?php echo esc_html($text); ?>
        </div>
    <?php };

    // Quadrados e linhas inclinadas nas laterais (versão escura para seções de fundo preto)
    $grafismo = function ($lado, $escuro = false) use ($img_dir) {
        $linhas = $escuro ? '/modelos/linhas-' . $lado . '-escuro.svg' : '/solucoes/linhas-' . $lado . '.svg'; ?>
        <div class="grafismo grafismo--<?php echo esc_attr($lado); ?><?php echo $escuro ? ' grafismo--escuro' : ''; ?>" aria-hidden="true">
            <span></span>
            <img src="<?php echo esc_url($img_dir . $linhas); ?>" alt="" loading="lazy">
            <span></span>
        </div>
    <?php };

    $logo = function ($id, $class) {
        if ($id) {
            echo wp_get_attachment_image($id, 'medium', false, array('class' => $class, 'loading' => 'lazy', 'alt' => esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true))));
        }
    };

    get_template_part('template-parts/sol-hero', null, array(
        'badge'          => $meta('hero_badge'),
        'highlight'      => $meta('hero_title_highlight'),
        'title'          => $meta('hero_title'),
        'text'           => $meta('hero_text'),
        'form_title'     => $meta('hero_form_title'),
        'form_button'    => $meta('hero_form_button'),
        'form_shortcode' => $meta('hero_form_shortcode'),
        'modelo_atual'   => get_the_title(),
    ));
?>

    <?php if ($desafios) : ?>
        <section class="desafios-modelo">
            <?php $grafismo('esquerda'); ?>
            <div class="container">
                <div class="desafios-modelo__grid">
                    <div class="desafios-modelo__header">
                        <?php $badge($meta('desafios_badge')); ?>
                        <?php if ($meta('desafios_title')) : ?><h2><?php echo agencia_solucao_titulo_html($meta('desafios_title')); ?></h2><?php endif; ?>
                    </div>
                    <ul class="lista-desafios">
                        <?php foreach ($desafios as $desafio) : ?>
                            <li><?php echo esc_html($desafio['text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php $grafismo('direita'); ?>
        </section>
    <?php endif; ?>

    <?php if ($ajuda) : ?>
        <section class="ajuda-modelo">
            <?php $grafismo('esquerda'); ?>
            <div class="container">
                <div class="ajuda-modelo__header">
                    <?php $badge($meta('ajuda_badge')); ?>
                    <?php if ($meta('ajuda_title')) : ?><h2><?php echo agencia_solucao_titulo_html($meta('ajuda_title')); ?></h2><?php endif; ?>
                    <?php if ($meta('ajuda_text')) : ?><p><?php echo esc_html($meta('ajuda_text')); ?></p><?php endif; ?>
                </div>
                <div class="grid-ajuda">
                    <?php foreach ($ajuda as $card) : ?>
                        <div class="card-ajuda">
                            <span class="card-ajuda__icone">
                                <img src="<?php echo esc_url($img_dir . '/modelos/icone-check.svg'); ?>" alt="" width="24" height="24" loading="lazy">
                            </span>
                            <h3><?php echo agencia_solucao_titulo_html($card['title']); ?></h3>
                            <?php if (!empty($card['description'])) : ?><p><?php echo esc_html($card['description']); ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $grafismo('direita'); ?>
        </section>
    <?php endif; ?>

    <?php if ($etapas) : ?>
        <section class="metodologia-modelo">
            <div class="container">
                <div class="metodologia-modelo__header">
                    <?php $badge($meta('metodologia_badge')); ?>
                    <?php if ($meta('metodologia_title')) : ?><h2><?php echo agencia_solucao_titulo_html($meta('metodologia_title')); ?></h2><?php endif; ?>
                </div>
                <ol class="lista-etapas-amarela">
                    <?php $step_number = 1;
                    foreach ($etapas as $etapa) : ?>
                        <li>
                            <span class="lista-etapas-amarela__numero" aria-hidden="true"><?php echo esc_html($step_number++); ?></span>
                            <div class="lista-etapas-amarela__txt">
                                <h3><?php echo esc_html($etapa['title']); ?></h3>
                                <?php if (!empty($etapa['description'])) : ?><p><?php echo esc_html($etapa['description']); ?></p><?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($resultados) : ?>
        <section class="resultados-modelo">
            <?php $grafismo('esquerda', true); ?>
            <div class="container">
                <div class="resultados-modelo__header">
                    <?php $badge($meta('resultados_badge'), ''); ?>
                    <?php if ($meta('resultados_title')) : ?><h2><?php echo agencia_solucao_titulo_html($meta('resultados_title')); ?></h2><?php endif; ?>
                </div>
                <div class="lista-resultados">
                    <?php $linha = 0;
                    foreach ($resultados as $resultado) : ?>
                        <div class="resultado-linha<?php echo ($linha++ % 2) ? ' resultado-linha--invertida' : ''; ?>">
                            <div class="resultado-case">
                                <div class="resultado-case__logo"><?php $logo(isset($resultado['logo_id']) ? $resultado['logo_id'] : 0, ''); ?></div>
                                <div class="resultado-case__txt">
                                    <p><?php echo esc_html($resultado['text']); ?></p>
                                    <div class="resultado-case__numeros">
                                        <?php foreach (array('n1', 'n2') as $n) :
                                            if (empty($resultado[$n . '_valor'])) {
                                                continue;
                                            } ?>
                                            <div class="resultado-numero">
                                                <strong><?php echo esc_html($resultado[$n . '_valor']); ?></strong>
                                                <?php if (!empty($resultado[$n . '_texto'])) : ?><span><?php echo esc_html($resultado[$n . '_texto']); ?></span><?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($resultado['destaque_valor'])) : ?>
                                <div class="resultado-destaque">
                                    <?php $logo(isset($resultado['destaque_logo_id']) ? $resultado['destaque_logo_id'] : 0, 'resultado-destaque__logo'); ?>
                                    <div class="resultado-destaque__txt">
                                        <strong><?php echo esc_html($resultado['destaque_valor']); ?></strong>
                                        <?php if (!empty($resultado['destaque_texto'])) : ?><span><?php echo esc_html($resultado['destaque_texto']); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $grafismo('direita', true); ?>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/sol-faq', null, array(
        'badge' => $meta('faq_badge'),
        'title' => $meta('faq_title'),
        'items' => $meta('faq_group'),
    )); ?>

    <?php
    // CTA próprio do Modelo. Se vazio, o footer.php exibe o CTA padrão do site.
    if (agencia_solucao_tem_cta()) {
        get_template_part('template-parts/sol-cta', null, array(
            'heading'         => $meta('cta_heading'),
            'text'            => $meta('cta_text'),
            'button_text'     => $meta('cta_button_text'),
            'button_link'     => $meta('cta_button_link'),
            'empresas_numero' => $meta('cta_empresas_numero'),
            'empresas_texto'  => $meta('cta_empresas_texto'),
        ));
    }

endwhile;

get_footer();
