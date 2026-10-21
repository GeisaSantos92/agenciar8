<?php
get_header();

while (have_posts()) : the_post();

    $post_id  = get_the_ID();
    $titulo   = get_post_meta($post_id, 'agencia_case_hero_titulo', true);
    $infos    = get_post_meta($post_id, 'agencia_case_infos', true);
    $logo_id  = get_post_meta($post_id, 'agencia_case_logo_id', true);
    $logo_cor = get_post_meta($post_id, 'agencia_case_logo_cor', true);
    $infos    = is_array($infos) ? array_filter($infos, function ($info) {
        return !empty($info['label']) && !empty($info['value']);
    }) : array();
?>

    <section class="hero-case">
        <div class="container">
            <div class="hero-case__grid">
                <div class="hero-case__txt">
                    <h1><?php echo $titulo ? agencia_solucao_titulo_html($titulo) : agencia_sem_quebra_hifen(esc_html(get_the_title())); ?></h1>

                    <?php if ($infos) : ?>
                        <dl class="hero-case__infos">
                            <?php foreach ($infos as $info) : ?>
                                <div>
                                    <dt><?php echo esc_html($info['label']); ?></dt>
                                    <dd><?php echo esc_html($info['value']); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </div>

                <?php if ($logo_id || has_post_thumbnail()) : ?>
                    <div class="hero-case__logo<?php echo $logo_id ? '' : ' hero-case__logo--imagem'; ?>" style="background-color:<?php echo esc_attr($logo_cor ? $logo_cor : '#1F1F1D'); ?>">
                        <?php
                        if ($logo_id) {
                            echo wp_get_attachment_image($logo_id, 'medium_large', false, array('alt' => esc_attr(get_post_meta($post_id, 'agencia_case_cliente', true))));
                        } else {
                            the_post_thumbnail('medium_large');
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (get_the_content()) : ?>
        <section class="case-conteudo">
            <div class="container">
                <div class="case-conteudo__texto">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php
    // CTA da página de Cases (Cases > Textos da página). Se vazio, o footer.php exibe o CTA padrão do site.
    if (agencia_solucao_tem_cta()) {
        get_template_part('template-parts/sol-cta', null, array(
            'heading'         => agencia_cases_opcao('cta_heading'),
            'text'            => agencia_cases_opcao('cta_text'),
            'button_text'     => agencia_cases_opcao('cta_button_text'),
            'button_link'     => agencia_cases_opcao('cta_button_link') ? agencia_cases_opcao('cta_button_link') : '#',
            'empresas_numero' => agencia_cases_opcao('cta_empresas_numero'),
            'empresas_texto'  => agencia_cases_opcao('cta_empresas_texto'),
        ));
    }

endwhile;

get_footer();
