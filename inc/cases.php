<?php

/**
 * Listagem de Cases (archive-case.php): textos da página, campo extra do card e filtro por área
 */

/**
 * Página "Textos da página" dentro do menu Cases (hero e CTA da listagem)
 */
add_action('cmb2_admin_init', 'agencia_register_cases_options');
function agencia_register_cases_options()
{
    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_cases_options_page',
        'title'        => esc_html__('Textos da página de Cases', 'agencia'),
        'object_types' => array('options-page'),
        'option_key'   => 'agencia_cases',
        'parent_slug'  => 'edit.php?post_type=case',
        'menu_title'   => esc_html__('Textos da página', 'agencia'),
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Hero (Dobra Inicial)', 'agencia'),
        'id'   => 'hero_titulo_secao',
        'type' => 'title',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Badge', 'agencia'),
        'id'   => 'hero_badge',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site. Coloque entre *asteriscos* o trecho em amarelo.', 'agencia'),
        'id'   => 'hero_title',
        'type' => 'textarea_small',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Texto', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site.', 'agencia'),
        'id'   => 'hero_text',
        'type' => 'textarea_small',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Texto do link "Ver mais"', 'agencia'),
        'desc' => esc_html__('Leva até a lista de cases. Se vazio, o link não aparece.', 'agencia'),
        'id'   => 'hero_ver_mais',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('CTA (antes do rodapé)', 'agencia'),
        'id'   => 'cta_titulo_secao',
        'type' => 'title',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Número de empresas', 'agencia'),
        'desc' => esc_html__('Aparece com as fotos acima do título. Ex: +100', 'agencia'),
        'id'   => 'cta_empresas_numero',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Legenda do número', 'agencia'),
        'id'   => 'cta_empresas_texto',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site. Coloque entre *asteriscos* o trecho em amarelo. Se vazio, exibe o CTA padrão do site.', 'agencia'),
        'id'   => 'cta_heading',
        'type' => 'textarea_small',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Texto', 'agencia'),
        'id'   => 'cta_text',
        'type' => 'textarea_small',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Texto do Botão', 'agencia'),
        'id'   => 'cta_button_text',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão', 'agencia'),
        'desc' => esc_html__('Ex: link do WhatsApp ou da página de contato.', 'agencia'),
        'id'   => 'cta_button_link',
        'type' => 'text',
    ));
}

/**
 * Lê um texto da página de Cases
 */
function agencia_cases_opcao($key)
{
    $options = get_option('agencia_cases', array());

    return isset($options[$key]) ? $options[$key] : '';
}

/**
 * Seed dos textos da página de Cases (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_cases_opcoes');
function agencia_seed_cases_opcoes()
{
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_cases_opcoes_done') >= $seed_version) {
        return;
    }

    $defaults = array(
        'hero_badge'          => 'Cases de Sucesso',
        'hero_title'          => "Transformamos desafios em\n*resultados exponenciais*",
        'hero_text'           => "Conheça as estratégias que geraram ROI, escala e autoridade para\ngrandes marcas de diversos segmentos.",
        'hero_ver_mais'       => 'Ver mais',
        'cta_empresas_numero' => '+100',
        'cta_empresas_texto'  => 'Empresas impactadas',
        'cta_heading'         => "Crescimento previsível\n*para empresas B2B*",
        'cta_text'            => 'Na R8, cada entrega é parte de um processo contínuo para gerar resultados mensuráveis, reduzir CAC e aumentar o ROI da sua empresa.',
        'cta_button_text'     => 'Quero acelerar meu crescimento',
    );

    $options = get_option('agencia_cases', array());
    $options = is_array($options) ? $options : array();
    foreach ($defaults as $key => $value) {
        if (empty($options[$key])) {
            $options[$key] = $value;
        }
    }
    update_option('agencia_cases', $options);

    update_option('agencia_seed_cases_opcoes_done', $seed_version);
}

/**
 * Campo extra do Case: ícone do segmento (aparece no card da listagem)
 */
add_action('cmb2_admin_init', 'agencia_register_case_card_metabox');
function agencia_register_case_card_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_case_card_metabox',
        'title'        => esc_html__('Card na listagem de Cases', 'agencia'),
        'object_types' => array('case'),
        'context'      => 'side',
        'priority'     => 'low',
    ));

    $cmb->add_field(array(
        'name'         => esc_html__('Ícone do segmento', 'agencia'),
        'desc'         => esc_html__('Opcional (16x16). Se vazio, usa o ícone padrão. A imagem do card é a Imagem Destacada; o texto é o Resumo; os números são os 3 primeiros Resultados.', 'agencia'),
        'id'           => 'agencia_case_icone',
        'type'         => 'file',
        'options'      => array('url' => false),
        'preview_size' => array(40, 40),
        'query_args'   => array('type' => 'image'),
    ));
}

/**
 * Campos da página do Case (hero com informações do projeto e logo). O conteúdo vem do editor.
 */
add_action('cmb2_admin_init', 'agencia_register_case_pagina_metabox');
function agencia_register_case_pagina_metabox()
{
    $prefix = 'agencia_case_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_case_pagina_metabox',
        'title'        => esc_html__('Página do Case (topo)', 'agencia'),
        'object_types' => array('case'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da página', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site. Se vazio, usa o título do post. No conteúdo (editor), use Título para a frase grande, Imagem para as imagens de largura total e Parágrafo para os textos à direita.', 'agencia'),
        'id'   => $prefix . 'hero_titulo',
        'type' => 'textarea_small',
    ));

    $group = $cmb->add_field(array(
        'id'          => $prefix . 'infos',
        'type'        => 'group',
        'description' => esc_html__('Informações do projeto (ex: Duração, Público, Setor, Serviços)', 'agencia'),
        'options'     => array(
            'group_title'    => esc_html__('Informação {#}', 'agencia'),
            'add_button'     => esc_html__('Adicionar Informação', 'agencia'),
            'remove_button'  => esc_html__('Remover Informação', 'agencia'),
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Rótulo', 'agencia'),
        'id'   => 'label',
        'type' => 'text',
    ));
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Valor', 'agencia'),
        'id'   => 'value',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name'         => esc_html__('Logo do cliente', 'agencia'),
        'desc'         => esc_html__('Aparece no quadrado à direita do título. Prefira PNG/WebP com fundo transparente. Se vazio, o quadrado mostra a Imagem Destacada.', 'agencia'),
        'id'           => $prefix . 'logo',
        'type'         => 'file',
        'options'      => array('url' => false),
        'preview_size' => 'medium',
        'query_args'   => array('type' => 'image'),
    ));

    $cmb->add_field(array(
        'name'    => esc_html__('Cor de fundo do quadrado do logo', 'agencia'),
        'id'      => $prefix . 'logo_cor',
        'type'    => 'colorpicker',
        'default' => '#1F1F1D',
    ));
}

/**
 * Áreas de um Case (vindas das Soluções aplicadas), na ordem do menu
 */
function agencia_case_areas($post_id)
{
    $sol_ids = get_post_meta($post_id, 'agencia_case_solucoes', true);
    if (empty($sol_ids) || !is_array($sol_ids)) {
        return array();
    }

    $terms = wp_get_object_terms(array_map('absint', $sol_ids), 'area_solucao');
    if (is_wp_error($terms)) {
        return array();
    }

    $areas = array();
    foreach ($terms as $term) {
        $areas[$term->slug] = $term->name;
    }

    return agencia_ordenar_areas($areas);
}

/**
 * Ordem das áreas igual à do layout (Marketing, Design, Tecnologia, Vendas). Áreas novas vão para o fim.
 */
function agencia_ordenar_areas($areas)
{
    $ordem = array('marketing', 'design', 'tecnologia', 'vendas');
    uksort($areas, function ($a, $b) use ($ordem) {
        $pa = array_search($a, $ordem, true);
        $pb = array_search($b, $ordem, true);
        $pa = $pa === false ? 99 : $pa;
        $pb = $pb === false ? 99 : $pb;
        return $pa === $pb ? strcmp($a, $b) : $pa - $pb;
    });

    return $areas;
}

/**
 * A listagem de Cases mostra todos os cases de uma vez (o filtro por área é feito na própria página)
 */
add_action('pre_get_posts', 'agencia_cases_archive_query');
function agencia_cases_archive_query($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('case')) {
        $query->set('posts_per_page', -1);
    }
}

/**
 * Seed: cases de exemplo iguais aos do layout (6 cards). Roda uma vez; depois é só editar ou apagar no painel.
 */
add_action('admin_init', 'agencia_seed_cases_exemplo');
function agencia_seed_cases_exemplo()
{
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_cases_exemplo_done') >= $seed_version) {
        return;
    }

    $inbound = get_page_by_path('inbound-marketing', OBJECT, 'solucao');
    $imagem  = agencia_seed_import_image('assets/seed/cases/agrsis.webp');

    $numeros_2 = array(
        array('number' => '+300%', 'label' => 'ROI Médio'),
        array('number' => '45k', 'label' => 'Novos Leads'),
    );
    $numeros_3 = array_merge($numeros_2, array(array('number' => '45k', 'label' => 'Novos Leads')));

    // Mesma ordem do layout: cards 1 e 2 com 2 números, card 3 sem números, cards 4 a 6 com 3 números
    $cards = array($numeros_2, $numeros_2, array(), $numeros_3, $numeros_3, $numeros_3);

    foreach ($cards as $i => $numeros) {
        $post_id = wp_insert_post(array(
            'post_type'    => 'case',
            'post_title'   => 'Escalando o faturamento em 300% com Inbound Marketing',
            'post_name'    => 'case-exemplo-' . ($i + 1),
            'post_status'  => 'publish',
            'menu_order'   => $i,
            'post_excerpt' => 'Reestruturação completa da jornada de compra e automação de marketing para um dos maiores e-commerces do agronegócio.',
        ));

        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }

        if ($imagem) {
            set_post_thumbnail($post_id, $imagem);
        }
        update_post_meta($post_id, 'agencia_case_cliente', 'Agrsis');
        update_post_meta($post_id, 'agencia_case_segmento', 'Agronegócio');
        if ($inbound) {
            update_post_meta($post_id, 'agencia_case_solucoes', array((string) $inbound->ID));
        }
        if ($numeros) {
            update_post_meta($post_id, 'agencia_case_resultados', $numeros);
        }
    }

    update_option('agencia_seed_cases_exemplo_done', $seed_version);
}

/**
 * Seed: conteúdo da página interna nos cases de exemplo (layout do Figma). Só preenche o que estiver vazio.
 */
add_action('admin_init', 'agencia_seed_cases_exemplo_pagina');
function agencia_seed_cases_exemplo_pagina()
{
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_cases_exemplo_pagina_done') >= $seed_version) {
        return;
    }

    $exemplos = get_posts(array(
        'post_type'      => 'case',
        'post_name__in'  => array('case-exemplo-1', 'case-exemplo-2', 'case-exemplo-3', 'case-exemplo-4', 'case-exemplo-5', 'case-exemplo-6'),
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ));
    if (!$exemplos) {
        return;
    }

    $logo    = agencia_seed_import_image('assets/seed/cases/cafezale-logo-branco.webp');
    $grafico = agencia_seed_import_image('assets/seed/cases/cafezale-grafico.webp');
    $mockup  = agencia_seed_import_image('assets/seed/cases/cafezale-mockup.webp');

    $imagem = function ($id) {
        return $id ? sprintf(
            '<!-- wp:image {"id":%1$d,"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="%2$s" alt="" class="wp-image-%1$d"/></figure><!-- /wp:image -->',
            $id,
            esc_url(wp_get_attachment_url($id))
        ) : '';
    };
    $texto = '<!-- wp:paragraph --><p>Na Agência R8, ajudamos indústrias, distribuidoras, construtoras e empresas de serviços a vender mais para outras empresas. Do marketing ao CRM, entregamos soluções completas para escalar negócios B2B.</p><!-- /wp:paragraph -->';

    // Mesma sequência do layout: frase, imagem, texto, imagem, imagem, texto, imagem
    $conteudo = implode("\n\n", array(
        '<!-- wp:heading --><h2 class="wp-block-heading">Do marketing ao CRM, entregamos soluções completas para escalar negócios B2B.</h2><!-- /wp:heading -->',
        $imagem($grafico),
        $texto,
        $imagem($mockup),
        $imagem($grafico),
        $texto,
        $imagem($mockup),
    ));

    foreach ($exemplos as $exemplo) {
        if (trim($exemplo->post_content) === '') {
            wp_update_post(array('ID' => $exemplo->ID, 'post_content' => $conteudo));
        }

        agencia_seed_solucao_meta($exemplo->ID, array(
            'agencia_case_hero_titulo' => "Como a Cafezale\ntriplicou o faturamento no seu e-commerce",
            'agencia_case_infos'       => array(
                array('label' => 'Duração', 'value' => '10 meses'),
                array('label' => 'Público', 'value' => 'Amantes de café'),
                array('label' => 'Setor', 'value' => 'Alimentício'),
                array('label' => 'Serviços', 'value' => 'Website, E-commerce, SEO'),
            ),
            'agencia_case_logo_cor'    => '#613624',
        ));

        if ($logo && !get_post_meta($exemplo->ID, 'agencia_case_logo_id', true)) {
            update_post_meta($exemplo->ID, 'agencia_case_logo_id', $logo);
            update_post_meta($exemplo->ID, 'agencia_case_logo', wp_get_attachment_url($logo));
        }
    }

    update_option('agencia_seed_cases_exemplo_pagina_done', $seed_version);
}