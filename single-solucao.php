<?php
get_header();

while (have_posts()) : the_post();

    $post_id = get_the_ID();
    $img_dir = get_template_directory_uri() . '/assets/images/solucoes';

    // Hero
    $prefix_hero        = 'agencia_sol_hero_';
    $hero_highlight     = get_post_meta($post_id, $prefix_hero . 'title_highlight', true);
    $hero_title         = get_post_meta($post_id, $prefix_hero . 'title', true);
    $hero_text          = get_post_meta($post_id, $prefix_hero . 'text', true);
    $form_title         = get_post_meta($post_id, $prefix_hero . 'form_title', true);
    $form_button        = get_post_meta($post_id, $prefix_hero . 'form_button', true);
    $form_shortcode     = get_post_meta($post_id, $prefix_hero . 'form_shortcode', true);
    $has_form           = $form_title || $form_shortcode;

    // Entregas
    $prefix_ent    = 'agencia_sol_entregas_';
    $ent_badge     = get_post_meta($post_id, $prefix_ent . 'badge', true);
    $ent_title     = get_post_meta($post_id, $prefix_ent . 'title', true);
    $ent_text      = get_post_meta($post_id, $prefix_ent . 'text', true);
    $ent_cards     = get_post_meta($post_id, $prefix_ent . 'group', true);

    // Galeria
    $prefix_gal    = 'agencia_sol_galeria_';
    $gal_badge     = get_post_meta($post_id, $prefix_gal . 'badge', true);
    $gal_title     = get_post_meta($post_id, $prefix_gal . 'title', true);
    $gal_text      = get_post_meta($post_id, $prefix_gal . 'text', true);
    $gal_images    = get_post_meta($post_id, $prefix_gal . 'images', true);
    $gal_cta_text  = get_post_meta($post_id, $prefix_gal . 'cta_text', true);
    $gal_cta_link  = get_post_meta($post_id, $prefix_gal . 'cta_link', true);
    if (empty($gal_cta_link)) {
        $gal_cta_link = get_post_type_archive_link('case');
    }

    // Processo
    $prefix_proc   = 'agencia_sol_processo_';
    $proc_badge    = get_post_meta($post_id, $prefix_proc . 'badge', true);
    $proc_title    = get_post_meta($post_id, $prefix_proc . 'title', true);
    $proc_steps    = get_post_meta($post_id, $prefix_proc . 'group', true);

    // FAQ
    $prefix_faq    = 'agencia_sol_faq_';
    $faq_badge     = get_post_meta($post_id, $prefix_faq . 'badge', true);
    $faq_title     = get_post_meta($post_id, $prefix_faq . 'title', true);
    $faq_items     = get_post_meta($post_id, $prefix_faq . 'group', true);

    // Remove itens vazios dos repeaters para não renderizar blocos em branco
    $ent_cards  = is_array($ent_cards) ? array_filter($ent_cards, function ($c) {
        return !empty($c['title']) || !empty($c['description']);
    }) : array();
    $proc_steps = is_array($proc_steps) ? array_filter($proc_steps, function ($s) {
        return !empty($s['title']);
    }) : array();
    $gal_images = is_array($gal_images) ? $gal_images : array();
?>

    <?php get_template_part('template-parts/sol-hero', null, array(
        'highlight'      => $hero_highlight,
        'title'          => $hero_title,
        'text'           => $hero_text,
        'form_title'     => $form_title,
        'form_button'    => $form_button,
        'form_shortcode' => $form_shortcode,
    )); ?>

    <?php if ($ent_title || $ent_cards) : ?>
        <section class="entregas-solucao">
            <div class="grafismo grafismo--esquerda" aria-hidden="true">
                <span></span>
                <img src="<?php echo esc_url($img_dir . '/linhas-esquerda.svg'); ?>" alt="" loading="lazy">
                <span></span>
            </div>
            <div class="container">
                <div class="entregas-solucao__header">
                    <div>
                        <?php if ($ent_badge) : ?>
                            <div class="badge-section badge-white">
                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="3" r="3" fill="#FFE700" />
                                </svg>
                                <?php echo esc_html($ent_badge); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($ent_title) : ?><h2><?php echo agencia_solucao_titulo_html($ent_title); ?></h2><?php endif; ?>
                    </div>
                    <?php if ($ent_text) : ?><p><?php echo wp_kses_post($ent_text); ?></p><?php endif; ?>
                </div>

                <?php if ($ent_cards) : ?>
                    <div class="grid-entregas">
                        <?php foreach ($ent_cards as $card) :
                            $card_title = isset($card['title']) ? $card['title'] : '';
                            $card_desc  = isset($card['description']) ? $card['description'] : '';
                            $icon_id    = isset($card['icon_id']) ? $card['icon_id'] : '';
                        ?>
                            <div class="card-entrega">
                                <div class="card-entrega__icone">
                                    <?php if ($icon_id) : ?>
                                        <?php echo wp_get_attachment_image($icon_id, 'thumbnail', false, array('alt' => '', 'loading' => 'lazy', 'width' => 40, 'height' => 40)); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url($img_dir . '/icone-entrega.svg'); ?>" alt="" width="40" height="40" loading="lazy">
                                    <?php endif; ?>
                                </div>
                                <div class="card-entrega__txt">
                                    <?php if ($card_title) : ?><h3><?php echo agencia_solucao_titulo_html($card_title); ?></h3><?php endif; ?>
                                    <?php if ($card_desc) : ?><p><?php echo esc_html($card_desc); ?></p><?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="grafismo grafismo--direita" aria-hidden="true">
                <span></span>
                <img src="<?php echo esc_url($img_dir . '/linhas-direita.svg'); ?>" alt="" loading="lazy">
                <span></span>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($gal_images) : ?>
        <section class="galeria-solucao">
            <?php if ($gal_badge || $gal_title || $gal_text) : ?>
                <div class="container">
                    <?php if ($gal_badge) : ?>
                        <div class="badge-section badge-white">
                            <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="3" cy="3" r="3" fill="#FFE700" />
                            </svg>
                            <?php echo esc_html($gal_badge); ?>
                        </div>
                    <?php endif; ?>
                    <div class="title-section title-white">
                        <?php if ($gal_title) : ?><h2><?php echo agencia_solucao_titulo_html($gal_title); ?></h2><?php endif; ?>
                        <?php if ($gal_text) : ?><p><?php echo wp_kses_post($gal_text); ?></p><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            // Duas faixas: a segunda corre no sentido contrário. Cada grupo é duplicado para o loop infinito.
            foreach (array('', ' galeria-faixa--reversa') as $faixa_class) : ?>
                <div class="galeria-faixa<?php echo esc_attr($faixa_class); ?>">
                    <div class="galeria-faixa__track">
                        <?php for ($copy = 0; $copy < 2; $copy++) : ?>
                            <div class="galeria-faixa__grupo"<?php echo $copy ? ' aria-hidden="true"' : ''; ?>>
                                <?php foreach ($gal_images as $image_id => $image_url) :
                                    echo wp_get_attachment_image($image_id, 'large', false, array(
                                        'alt'      => $copy ? '' : esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)),
                                        'loading'  => 'lazy',
                                        'decoding' => 'async',
                                        'sizes'    => '(max-width: 640px) 360px, 600px',
                                    ));
                                endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($gal_cta_text && $gal_cta_link) : ?>
                <div class="btn-cta">
                    <a href="<?php echo esc_url($gal_cta_link); ?>" class="btn-primary"><?php echo esc_html($gal_cta_text); ?>
                        <img src="<?php echo esc_url($img_dir . '/seta.svg'); ?>" alt="" width="20" height="20">
                    </a>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <?php if ($proc_steps) : ?>
        <section class="processo-solucao">
            <div class="container">
                <?php if ($proc_badge || $proc_title) : ?>
                    <div class="processo-solucao__header">
                        <?php if ($proc_badge) : ?>
                            <div class="badge-section badge-white">
                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="3" r="3" fill="#FFE700" />
                                </svg>
                                <?php echo esc_html($proc_badge); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($proc_title) : ?><h2><?php echo agencia_solucao_titulo_html($proc_title); ?></h2><?php endif; ?>
                    </div>
                <?php endif; ?>

                <ol class="lista-etapas">
                    <?php $step_number = 1;
                    foreach ($proc_steps as $step) : ?>
                        <li class="etapa">
                            <span class="etapa__numero" aria-hidden="true"><?php echo esc_html($step_number++); ?></span>
                            <div class="etapa__txt">
                                <h3><?php echo esc_html($step['title']); ?></h3>
                                <?php if (!empty($step['description'])) : ?>
                                    <p><?php echo esc_html($step['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/sol-faq', null, array(
        'badge' => $faq_badge,
        'title' => $faq_title,
        'items' => $faq_items,
    )); ?>

    <?php
    // CTA próprio da Solução. Se vazio, o footer.php exibe o CTA padrão do site.
    if (agencia_solucao_tem_cta()) :
        $prefix_cta      = 'agencia_sol_cta_';
        $cta_button_link = get_post_meta($post_id, $prefix_cta . 'button_link', true);
        if (empty($cta_button_link)) {
            $cta_button_link = $has_form ? '#form-solucao' : get_post_type_archive_link('case');
        }

        get_template_part('template-parts/sol-cta', null, array(
            'heading'     => get_post_meta($post_id, $prefix_cta . 'heading', true),
            'text'        => get_post_meta($post_id, $prefix_cta . 'text', true),
            'button_text' => get_post_meta($post_id, $prefix_cta . 'button_text', true),
            'button_link' => $cta_button_link,
        ));
    endif; ?>

<?php
endwhile;

get_footer();
