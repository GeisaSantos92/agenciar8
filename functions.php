<?php

// CPTs: Soluções, Modelos de Negócio e Cases
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/solucoes.php';
require_once get_template_directory() . '/inc/modelos.php';
require_once get_template_directory() . '/inc/cases.php';

/**
 * Lê um CSS do tema já minificado para imprimir inline no <head> (PageSpeed: nenhuma requisição bloqueando a renderização)
 * As URLs relativas (../images) viram absolutas, porque o CSS deixa de ser servido de dentro de assets/css
 */
function agencia_css_inline($arquivo)
{
    $css = file_get_contents(get_template_directory() . '/assets/css/' . $arquivo);
    $css = preg_replace('#url\(([\'"]?)\.\./#', 'url($1' . get_template_directory_uri() . '/assets/', $css);
    $css = preg_replace('#/\*.*?\*/#s', '', $css);
    $css = preg_replace('/\s+/', ' ', $css);

    return trim($css);
}

// Enfileira um CSS do tema como <style> inline, mantendo o handle e as dependências do WordPress
function agencia_enqueue_css_inline($handle, $arquivo, $deps = array('agencia-geral'))
{
    wp_register_style($handle, false, $deps);
    wp_enqueue_style($handle);
    wp_add_inline_style($handle, agencia_css_inline($arquivo));
}

function agencia_enqueue_scripts()
{
    // CSS geral em todas as páginas (as fontes são locais, declaradas em agencia_fontes_head)
    agencia_enqueue_css_inline('agencia-geral', 'geral.css', array());

    // CSS home apenas na página que utiliza o template page-home.php ou slug 'home'
    if (is_page_template('page-home.php') || is_page('home')) {
        agencia_enqueue_css_inline('agencia-home', 'home.css');
    }

    // CSS agencia apenas na página que utiliza o template page-agencia.php ou slug 'agencia'
    if (is_page_template('page-agencia.php') || is_page('agencia')) {
        agencia_enqueue_css_inline('agencia-agencia', 'agencia.css');
    }

    // CSS das singles e listagens dos CPTs (Soluções, Modelos de Negócio e Cases)
    if ((is_post_type_archive(agencia_cpts()) && !is_post_type_archive('case')) || is_tax('area_solucao')) {
        agencia_enqueue_css_inline('agencia-single', 'single.css');
    }

    // CSS da single de Soluções (layout próprio). Modelos de Negócio e a listagem de Cases reaproveitam hero, FAQ e CTA dele.
    if (is_singular(array('solucao', 'modelo_negocio', 'case')) || is_post_type_archive('case')) {
        agencia_enqueue_css_inline('agencia-solucao', 'solucao.css');
    }

    // CSS da listagem e da página de Cases
    if (is_post_type_archive('case') || is_singular('case')) {
        agencia_enqueue_css_inline('agencia-cases', 'cases.css', array('agencia-solucao'));
    }

    // CSS da single de Modelos de Negócio (seções próprias e o CTA com fotos)
    if (is_singular(array('modelo_negocio', 'case')) || is_post_type_archive('case')) {
        agencia_enqueue_css_inline('agencia-modelo', 'modelo.css', array('agencia-solucao'));
    }

    // Enfileira o JS geral em todas as páginas, no rodapé para melhor performance
    wp_enqueue_script('agencia-geral-js', get_template_directory_uri() . '/assets/js/geral.js', array(), filemtime(get_template_directory() . '/assets/js/geral.js'), true);
}
add_action('wp_enqueue_scripts', 'agencia_enqueue_scripts');

/**
 * Fontes hospedadas no tema: assets/css/fontes.css é a cópia exata do CSS que o Google Fonts entregava
 * (mesmas famílias, pesos, itálicos e subsets), só que servida daqui, sem conexão extra com o Google
 * A Manrope latin (menu, títulos e o H1/LCP) vai com preload; as demais só baixam quando aparecem na tela
 */
add_action('wp_head', 'agencia_fontes_head', 1);
function agencia_fontes_head()
{
    $manrope = get_template_directory_uri() . '/assets/fonts/manrope-xn7gYHE41ni1AdIRggexSg.woff2';

    echo '<link rel="preload" href="' . esc_url($manrope) . '" as="font" type="font/woff2" crossorigin>' . "\n";
    echo '<style id="agencia-fontes">' . agencia_css_inline('fontes.css') . "</style>\n";
}

// O <title> de cada página fica a cargo do WordPress/Rank Math (antes era fixo no header.php)
add_action('after_setup_theme', 'agencia_theme_support');
function agencia_theme_support()
{
    add_theme_support('title-tag');
}

/**
 * Rank Math: no editor, faz a análise de SEO usar o conteúdo que a página publicada exibe
 * (os textos ficam em campos CMB2, fora do editor; ver assets/js/rank-math-conteudo.js)
 */
add_action('admin_enqueue_scripts', 'agencia_rank_math_conteudo');
function agencia_rank_math_conteudo($hook)
{
    if (!class_exists('RankMath') || !in_array($hook, array('post.php', 'post-new.php'), true)) {
        return;
    }

    $post = get_post();
    if (!$post || !in_array($post->post_type, array('page', 'solucao', 'modelo_negocio', 'case'), true)) {
        return;
    }

    $url = 'publish' === $post->post_status ? get_permalink($post) : get_preview_post_link($post);

    wp_enqueue_script('agencia-rank-math-conteudo', get_template_directory_uri() . '/assets/js/rank-math-conteudo.js', array('wp-hooks'), filemtime(get_template_directory() . '/assets/js/rank-math-conteudo.js'), true);
    wp_localize_script('agencia-rank-math-conteudo', 'agenciaRankMath', array('url' => $url));
}

// Rank Math: o teste "Content AI" mede o uso de um recurso pago do plugin (desativado aqui), não a qualidade da página
add_filter('rank_math/researches/tests', 'agencia_rank_math_testes');
function agencia_rank_math_testes($tests)
{
    unset($tests['hasContentAI']);
    return $tests;
}

/**
 * Meta description com o texto que a própria página já exibe (subtítulo do hero, resumo, descrição da área)
 * Com o Rank Math ativo, o tema não imprime a tag: só completa a descrição dele quando o campo está vazio
 */
add_action('wp_head', 'agencia_meta_description', 2);
function agencia_meta_description()
{
    if (defined('WPSEO_VERSION') || class_exists('RankMath')) {
        return;
    }

    $desc = agencia_meta_description_texto();
    if ($desc) {
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    }
}

add_filter('rank_math/frontend/description', 'agencia_rank_math_description');
function agencia_rank_math_description($desc)
{
    return $desc ? $desc : agencia_meta_description_texto();
}

function agencia_meta_description_texto()
{
    $desc = '';
    if (is_page_template('page-home.php') || is_page('home')) {
        $desc = get_post_meta(get_the_ID(), 'agencia_hero_subtitle', true);
    } elseif (is_page_template('page-agencia.php')) {
        $desc = get_post_meta(get_the_ID(), 'agencia_pag_subtitle', true);
    } elseif (is_singular()) {
        $desc = has_excerpt() ? get_the_excerpt() : get_post_meta(get_the_ID(), 'agencia_single_subtitle', true);
    } elseif (is_tax() || is_category()) {
        $desc = term_description();
    } elseif (is_post_type_archive()) {
        $desc = get_the_post_type_description();
    }

    if (!$desc) {
        $desc = get_bloginfo('description');
    }

    return wp_trim_words(wp_strip_all_tags($desc), 30, '…');
}

/**
 * Áreas com as suas Soluções (menu e rodapé) e Modelos de Negócio (menu), em cache para não repetir as consultas a cada página
 * O cache é limpo sempre que uma Solução, Modelo de Negócio ou Área é criada, editada ou removida
 */
function agencia_menu_areas()
{
    $areas = get_transient('agencia_menu_areas');
    if (false !== $areas) {
        return $areas;
    }

    $areas = array();
    $terms = get_terms(array('taxonomy' => 'area_solucao', 'hide_empty' => true));
    if (!is_wp_error($terms)) {
        foreach ($terms as $term) {
            $solucoes = get_posts(array(
                'post_type'      => 'solucao',
                'posts_per_page' => -1,
                'orderby'        => array('menu_order' => 'ASC', 'title' => 'ASC'),
                'tax_query'      => array(array(
                    'taxonomy' => 'area_solucao',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                )),
            ));

            $itens = array();
            foreach ($solucoes as $solucao) {
                $itens[] = array('titulo' => $solucao->post_title, 'link' => get_permalink($solucao));
            }

            $areas[] = array('nome' => $term->name, 'link' => get_term_link($term), 'solucoes' => $itens);
        }
    }

    set_transient('agencia_menu_areas', $areas, DAY_IN_SECONDS);
    return $areas;
}

function agencia_menu_modelos()
{
    $modelos = get_transient('agencia_menu_modelos');
    if (false !== $modelos) {
        return $modelos;
    }

    $modelos = array();
    $posts   = get_posts(array(
        'post_type'      => 'modelo_negocio',
        'posts_per_page' => -1,
        'orderby'        => array('menu_order' => 'ASC', 'title' => 'ASC'),
    ));
    foreach ($posts as $modelo) {
        $modelos[] = array('titulo' => $modelo->post_title, 'link' => get_permalink($modelo));
    }

    set_transient('agencia_menu_modelos', $modelos, DAY_IN_SECONDS);
    return $modelos;
}

function agencia_limpa_cache_menu()
{
    delete_transient('agencia_menu_areas');
    delete_transient('agencia_menu_modelos');
}
add_action('save_post_solucao', 'agencia_limpa_cache_menu');
add_action('save_post_modelo_negocio', 'agencia_limpa_cache_menu');
add_action('deleted_post', 'agencia_limpa_cache_menu');
add_action('trashed_post', 'agencia_limpa_cache_menu');
add_action('set_object_terms', 'agencia_limpa_cache_menu');
add_action('created_area_solucao', 'agencia_limpa_cache_menu');
add_action('edited_area_solucao', 'agencia_limpa_cache_menu');
add_action('delete_area_solucao', 'agencia_limpa_cache_menu');
add_action('update_option_permalink_structure', 'agencia_limpa_cache_menu');

// Link da página que usa o template "A Agencia" (menu e rodapé), seguindo o slug que estiver no painel
function agencia_link_pagina_agencia()
{
    static $link = null;
    if (null === $link) {
        $paginas = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'page-agencia.php', 'number' => 1));
        $link    = $paginas ? get_permalink($paginas[0]) : '#';
    }

    return $link;
}

// srcset/sizes de um anexo para as tags <img> montadas à mão (o navegador baixa o tamanho certo para a tela)
function agencia_srcset_attr($image_id)
{
    $srcset = $image_id ? wp_get_attachment_image_srcset($image_id, 'full') : '';
    if (!$srcset) {
        return '';
    }

    return ' srcset="' . esc_attr($srcset) . '" sizes="' . esc_attr(wp_get_attachment_image_sizes($image_id, 'full')) . '"';
}

/**
 * Register CMB2 Custom Fields for the Hero Section on the Home Template
 */
add_action('cmb2_admin_init', 'agencia_register_hero_metabox');
function agencia_register_hero_metabox()
{
    $prefix = 'agencia_hero_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_hero_metabox',
        'title'        => esc_html__('Configurações da Hero (Dobra Inicial)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge Image
    $cmb->add_field(array(
        'name' => esc_html__('Imagem do Badge', 'agencia'),
        'desc' => esc_html__('Selecione ou envie uma imagem (ex: pessoas.webp)', 'agencia'),
        'id'   => $prefix . 'badge_image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'preview_size' => 'thumbnail',
    ));

    // Badge Number
    $cmb->add_field(array(
        'name' => esc_html__('Número do Badge', 'agencia'),
        'desc' => esc_html__('Ex: +1000', 'agencia'),
        'id'   => $prefix . 'badge_number',
        'type' => 'text',
    ));

    // Badge Label
    $cmb->add_field(array(
        'name' => esc_html__('Texto do Badge', 'agencia'),
        'desc' => esc_html__('Ex: Empresas impactadas', 'agencia'),
        'id'   => $prefix . 'badge_label',
        'type' => 'text',
    ));

    // Hero Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Hero', 'agencia'),
        'desc' => esc_html__('Insira o título principal (H1)', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    // Hero Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Subtítulo da Hero', 'agencia'),
        'desc' => esc_html__('Insira o parágrafo explicativo da Hero', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea',
    ));

    // Hero CTA Text
    $cmb->add_field(array(
        'name' => esc_html__('Texto do Botão CTA', 'agencia'),
        'desc' => esc_html__('Ex: Quero gerar mais resultados', 'agencia'),
        'id'   => $prefix . 'cta_text',
        'type' => 'text',
    ));

    // Hero CTA Link
    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão CTA', 'agencia'),
        'desc' => esc_html__('Link de destino do botão', 'agencia'),
        'id'   => $prefix . 'cta_link',
        'type' => 'text_url',
    ));

    // Hero Mosaic Image (LCP Image)
    $cmb->add_field(array(
        'name' => esc_html__('Imagem do Mosaico (Dobra Principal)', 'agencia'),
        'desc' => esc_html__('Selecione ou envie o mosaico de imagens (LCP)', 'agencia'),
        'id'   => $prefix . 'mosaic_image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
    ));
}

/**
 * Register CMB2 Custom Fields for the Hero Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_hero_metabox');
function agencia_register_agencia_hero_metabox()
{
    $prefix = 'agencia_pag_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_hero_metabox',
        'title'        => esc_html__('Configurações da Hero (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge da Hero
    $cmb->add_field(array(
        'name'    => esc_html__('Badge da Hero', 'agencia'),
        'desc'    => esc_html__('Ex: A Agência', 'agencia'),
        'id'      => $prefix . 'badge',
        'type'    => 'text',
        'default' => 'A Agência',
    ));

    // Título da Hero
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Hero', 'agencia'),
        'desc'    => esc_html__('Insira o título principal (H1)', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'textarea_small',
        'default' => 'Muito além de uma agência <br> de marketing digital',
    ));

    // Subtítulo da Hero
    $cmb->add_field(array(
        'name'    => esc_html__('Subtítulo da Hero', 'agencia'),
        'desc'    => esc_html__('Insira o parágrafo explicativo da Hero', 'agencia'),
        'id'      => $prefix . 'subtitle',
        'type'    => 'textarea',
        'default' => 'Unimos pessoas, tecnologia e processos para impulsionar o crescimento dos nossos clientes. Criamos estratégias inteligentes, transparentes e orientadas a resultados que fortalecem marcas e constroem relações duradouras.',
    ));



    // Grupo de Mosaico (Repeater)
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'mosaico_grupo',
        'type'        => 'group',
        'description' => esc_html__('Mosaico de Imagens (Hero)', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Imagem {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Imagem', 'agencia'),
            'remove_button'     => esc_html__('Remover Imagem', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover esta imagem?', 'agencia'),
        ),
    ));

    // Campo de Imagem dentro do grupo
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Imagem', 'agencia'),
        'id'   => 'imagem',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
    ));
}

/**
 * Register CMB2 Custom Fields for the "O que nos move" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_move_metabox');
function agencia_register_agencia_move_metabox()
{
    $prefix = 'agencia_pag_move_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_move_metabox',
        'title'        => esc_html__('Configurações da Seção "O que nos move" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: O que nos move', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => 'O que nos move',
    ));

    // Grupo de Itens (Repeater)
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'itens_grupo',
        'type'        => 'group',
        'description' => esc_html__('Itens do Grid (Textos apenas)', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Item {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Item', 'agencia'),
            'remove_button'     => esc_html__('Remover Item', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este item?', 'agencia'),
        ),
    ));

    // Campo de Texto do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Texto do Item', 'agencia'),
        'id'   => 'texto',
        'type' => 'textarea_small',
    ));

    // Campo de Imagem do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Imagem do Item', 'agencia'),
        'id'   => 'imagem',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for "O que nos move" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_move_data');
function agencia_seed_agencia_move_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_move_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'O que nos move');
        }

        // Seed group items if not set
        $existing_group = get_post_meta($post_id, $prefix . 'itens_grupo', true);
        if (empty($existing_group)) {
            $default_items = array(
                array('texto' => 'Transformar pessoas e empresas com relações verdadeiras e colaboração real.'),
                array('texto' => 'Unir Pessoas, Tecnologia e Processos para potencializar resultados.'),
                array('texto' => 'Construir parcerias duradouras, guiadas por confiança e propósito.'),
                array('texto' => 'Ampliar a visão dos clientes sobre o potencial dos seus negócios.'),
                array('texto' => 'Criar estratégias sob medida que elevam marcas e impulsionam crescimento.'),
                array('texto' => 'Entregar impacto sustentável, combinando inovação, clareza e performance.')
            );
            update_post_meta($post_id, $prefix . 'itens_grupo', $default_items);
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Impulsionar Banner" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_impulsionar_metabox');
function agencia_register_agencia_impulsionar_metabox()
{
    $prefix = 'agencia_pag_impulsionar_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_impulsionar_metabox',
        'title'        => esc_html__('Configurações da Seção "Impulsionar" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Impulsionamos Negócios...', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'textarea_small',
        'default' => 'Impulsionamos Negócios B2B e e-commerce com Marketing e Tecnologia Inteligentes',
    ));

    // Subtítulo da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Subtítulo da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Soluções completas...', 'agencia'),
        'id'      => $prefix . 'subtitle',
        'type'    => 'textarea',
        'default' => 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável',
    ));

    // Texto do Botão CTA
    $cmb->add_field(array(
        'name'    => esc_html__('Texto do Botão CTA', 'agencia'),
        'desc'    => esc_html__('Ex: Quero gerar mais resultados', 'agencia'),
        'id'      => $prefix . 'cta_text',
        'type'    => 'text',
        'default' => 'Quero gerar mais resultados',
    ));

    // Link do Botão CTA
    $cmb->add_field(array(
        'name'    => esc_html__('Link do Botão CTA', 'agencia'),
        'desc'    => esc_html__('Link de destino do botão', 'agencia'),
        'id'      => $prefix . 'cta_link',
        'type'    => 'text_url',
        'default' => '',
    ));

    // Imagem do Banner
    $cmb->add_field(array(
        'name' => esc_html__('Imagem do Banner', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem lateral do banner', 'agencia'),
        'id'   => $prefix . 'image',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for "Impulsionar Banner" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_impulsionar_data');
function agencia_seed_agencia_impulsionar_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_impulsionar_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Impulsionamos Negócios B2B e e-commerce com Marketing e Tecnologia Inteligentes');
        }

        // Seed subtitle if not set
        $existing_subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);
        if ($existing_subtitle === '') {
            update_post_meta($post_id, $prefix . 'subtitle', 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável');
        }

        // Seed CTA text if not set
        $existing_cta_text = get_post_meta($post_id, $prefix . 'cta_text', true);
        if ($existing_cta_text === '') {
            update_post_meta($post_id, $prefix . 'cta_text', 'Quero gerar mais resultados');
        }

        // Seed CTA link if not set
        $existing_cta_link = get_post_meta($post_id, $prefix . 'cta_link', true);
        if ($existing_cta_link === '') {
            update_post_meta($post_id, $prefix . 'cta_link', '#');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Essencia" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_essencia_metabox');
function agencia_register_agencia_essencia_metabox()
{
    $prefix = 'agencia_pag_essencia_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_essencia_metabox',
        'title'        => esc_html__('Configurações da Seção "Essência" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Badge da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Por que R8', 'agencia'),
        'id'      => $prefix . 'badge',
        'type'    => 'text',
        'default' => 'Por que R8',
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: A essência por trás do nosso nome', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => 'A essência por trás do nosso nome',
    ));

    // Descrição da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Descrição da Seção', 'agencia'),
        'desc'    => esc_html__('Insira o texto explicativo da Essência', 'agencia'),
        'id'      => $prefix . 'description',
        'type'    => 'textarea',
        'default' => 'O R representa nossos dois pilares — Resultados e Relacionamentos, que orientam nosso jeito de trabalhar. Já o 8 simboliza o elo infinito entre agência e cliente, refletindo nossa visão de parceria contínua. R8 sintetiza, em um único nome, nossa cultura, nosso propósito e a forma como construímos cada projeto.',
    ));

    // Imagem da Essência
    $cmb->add_field(array(
        'name' => esc_html__('Imagem da Essência', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem lateral', 'agencia'),
        'id'   => $prefix . 'image',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for "Essencia" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_essencia_data');
function agencia_seed_agencia_essencia_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_essencia_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Por que R8');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'A essência por trás do nosso nome');
        }

        // Seed description if not set
        $existing_desc = get_post_meta($post_id, $prefix . 'description', true);
        if ($existing_desc === '') {
            update_post_meta($post_id, $prefix . 'description', 'O R representa nossos dois pilares — Resultados e Relacionamentos, que orientam nosso jeito de trabalhar. Já o 8 simboliza o elo infinito entre agência e cliente, refletindo nossa visão de parceria contínua. R8 sintetiza, em um único nome, nossa cultura, nosso propósito e a forma como construímos cada projeto.');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Estrutura" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_estrutura_metabox');
function agencia_register_agencia_estrutura_metabox()
{
    $prefix = 'agencia_pag_estrutura_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_estrutura_metabox',
        'title'        => esc_html__('Configurações da Seção "Estrutura" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Badge da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Nossa Estrutura', 'agencia'),
        'id'      => $prefix . 'badge',
        'type'    => 'text',
        'default' => 'Nossa Estrutura',
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Onde ideias viram performance', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => 'Onde ideias viram performance',
    ));

    // Descrição da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Descrição da Seção', 'agencia'),
        'desc'    => esc_html__('Insira o texto explicativo da Estrutura', 'agencia'),
        'id'      => $prefix . 'description',
        'type'    => 'textarea',
        'default' => 'Nosso espaço foi pensado para integrar criatividade, estratégia e dados. Aqui, nossa equipe conecta marketing, tecnologia e vendas em um ambiente colaborativo e focado em resultados.',
    ));

    // Imagem da Estrutura
    $cmb->add_field(array(
        'name' => esc_html__('Imagem da Estrutura', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem lateral', 'agencia'),
        'id'   => $prefix . 'image',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for "Estrutura" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_estrutura_data');
function agencia_seed_agencia_estrutura_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_estrutura_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Nossa Estrutura');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Onde ideias viram performance');
        }

        // Seed description if not set
        $existing_desc = get_post_meta($post_id, $prefix . 'description', true);
        if ($existing_desc === '') {
            update_post_meta($post_id, $prefix . 'description', 'Nosso espaço foi pensado para integrar criatividade, estratégia e dados. Aqui, nossa equipe conecta marketing, tecnologia e vendas em um ambiente colaborativo e focado em resultados.');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Proposito" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_proposito_metabox');
function agencia_register_agencia_proposito_metabox()
{
    $prefix = 'agencia_pag_proposito_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_proposito_metabox',
        'title'        => esc_html__('Configurações da Seção "Propósito" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Badge da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Nosso Propósito', 'agencia'),
        'id'      => $prefix . 'badge',
        'type'    => 'text',
        'default' => 'Nosso Propósito',
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Transformar negócios...', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => 'Transformar negócios em histórias de crescimento',
    ));

    // Descrição da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Descrição da Seção', 'agencia'),
        'desc'    => esc_html__('Insira o texto explicativo do Propósito', 'agencia'),
        'id'      => $prefix . 'description',
        'type'    => 'textarea',
        'default' => 'Nosso propósito é transformar pessoas e empresas por meio de três pilares: Pessoas, Tecnologia e Processos. Cada estratégia é feita sob medida para garantir resultados mensuráveis e sustentáveis.',
    ));

    // Imagem do Propósito
    $cmb->add_field(array(
        'name' => esc_html__('Imagem do Propósito', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem lateral', 'agencia'),
        'id'   => $prefix . 'image',
        'type' => 'file',
        'options' => array(
            'url' => false, // Retorna o ID da mídia para otimização de imagem responsiva (PageSpeed)
        ),
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for "Proposito" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_proposito_data');
function agencia_seed_agencia_proposito_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_proposito_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Nosso Propósito');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Transformar negócios em histórias de crescimento');
        }

        // Seed description if not set
        $existing_desc = get_post_meta($post_id, $prefix . 'description', true);
        if ($existing_desc === '') {
            update_post_meta($post_id, $prefix . 'description', 'Nosso propósito é transformar pessoas e empresas por meio de três pilares: Pessoas, Tecnologia e Processos. Cada estratégia é feita sob medida para garantir resultados mensuráveis e sustentáveis.');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Nossa Cultura" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_cultura_metabox');
function agencia_register_agencia_cultura_metabox()
{
    $prefix = 'agencia_pag_cultura_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_cultura_metabox',
        'title'        => esc_html__('Configurações da Seção "Nossa Cultura" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Badge da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Badge da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Nossa Cultura', 'agencia'),
        'id'      => $prefix . 'badge',
        'type'    => 'text',
        'default' => 'Nossa Cultura',
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: Como pensamos e trabalhamos', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => 'Como pensamos e trabalhamos',
    ));

    // Descrição da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Descrição da Seção', 'agencia'),
        'desc'    => esc_html__('Insira o texto explicativo da Cultura', 'agencia'),
        'id'      => $prefix . 'description',
        'type'    => 'textarea',
        'default' => 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável',
    ));

    // Grupo de Itens (Repeater)
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'itens_grupo',
        'type'        => 'group',
        'description' => esc_html__('Itens de Cultura', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Item {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Item', 'agencia'),
            'remove_button'     => esc_html__('Remover Item', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este item?', 'agencia'),
        ),
    ));

    // Campo de Título do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título do Item', 'agencia'),
        'id'   => 'titulo',
        'type' => 'text',
    ));

    // Campo de Descrição do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição do Item', 'agencia'),
        'id'   => 'descricao',
        'type' => 'textarea_small',
    ));
}

/**
 * Seed default values for "Nossa Cultura" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_cultura_data');
function agencia_seed_agencia_cultura_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_cultura_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Nossa Cultura');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Como pensamos e trabalhamos');
        }

        // Seed description if not set
        $existing_desc = get_post_meta($post_id, $prefix . 'description', true);
        if ($existing_desc === '') {
            update_post_meta($post_id, $prefix . 'description', 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável');
        }

        // Seed group items if not set
        $existing_group = get_post_meta($post_id, $prefix . 'itens_grupo', true);
        if (empty($existing_group)) {
            $default_items = array(
                array(
                    'titulo'    => 'Pessoas em primeiro lugar',
                    'descricao' => 'Construímos relações genuínas, ouvindo de perto e colaborando de forma ativa. Atuamos como parceiros comprometidos em entender suas necessidades e impulsionar seus resultados.'
                ),
                array(
                    'titulo'    => 'Excelência sempre',
                    'descricao' => 'Cuidamos de cada detalhe com rigor e buscamos ir além do esperado. Refinamos continuamente nosso trabalho para entregar soluções precisas, impactantes e alinhadas aos seus objetivos.'
                ),
                array(
                    'titulo'    => 'Inovação constante',
                    'descricao' => 'Exploramos novas ideias, ferramentas e metodologias para criar soluções criativas e adaptáveis. Transformamos desafios em oportunidades que geram cultura real e melhoria contínua.'
                ),
                array(
                    'titulo'    => 'Transparência total',
                    'descricao' => 'Mantemos comunicação direta e objetiva em todas as etapas do processo. Você tem visibilidade completa das decisões, garantindo previsibilidade, confiança e alinhamento constante.'
                )
            );
            update_post_meta($post_id, $prefix . 'itens_grupo', $default_items);
        }
    }
}

/**
 * Register CMB2 Custom Fields for the "Solucoes" Section on the A Agencia Template
 */
add_action('cmb2_admin_init', 'agencia_register_agencia_solucoes_metabox');
function agencia_register_agencia_solucoes_metabox()
{
    $prefix = 'agencia_pag_solucoes_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_pag_solucoes_metabox',
        'title'        => esc_html__('Configurações da Seção "Soluções" (A Agência)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-agencia.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Título da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Título da Seção', 'agencia'),
        'desc'    => esc_html__('Ex: 360° de verdade!', 'agencia'),
        'id'      => $prefix . 'title',
        'type'    => 'text',
        'default' => '360° de verdade!',
    ));

    // Descrição da Seção
    $cmb->add_field(array(
        'name'    => esc_html__('Descrição da Seção', 'agencia'),
        'desc'    => esc_html__('Insira o texto explicativo de Soluções', 'agencia'),
        'id'      => $prefix . 'description',
        'type'    => 'textarea_small',
        'default' => 'Temos soluções completas para gerar resultados reais',
    ));

    // Grupo de Itens (Repeater)
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'itens_grupo',
        'type'        => 'group',
        'description' => esc_html__('Itens de Soluções', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Item {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Item', 'agencia'),
            'remove_button'     => esc_html__('Remover Item', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este item?', 'agencia'),
        ),
    ));

    // Campo de Título do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título do Item', 'agencia'),
        'id'   => 'titulo',
        'type' => 'text',
    ));

    // Campo de Descrição do Item
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição do Item', 'agencia'),
        'id'   => 'descricao',
        'type' => 'textarea_small',
    ));
}

/**
 * Seed default values for "Solucoes" metabox on page-agencia.php template pages
 */
add_action('admin_init', 'agencia_seed_agencia_solucoes_data');
function agencia_seed_agencia_solucoes_data()
{
    if (!is_admin()) {
        return;
    }

    $agencia_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-agencia.php',
    ));

    if (empty($agencia_pages)) {
        return;
    }

    $prefix = 'agencia_pag_solucoes_';

    foreach ($agencia_pages as $page) {
        $post_id = $page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', '360° de verdade!');
        }

        // Seed description if not set
        $existing_desc = get_post_meta($post_id, $prefix . 'description', true);
        if ($existing_desc === '') {
            update_post_meta($post_id, $prefix . 'description', 'Temos soluções completas para gerar resultados reais');
        }

        // Seed group items if not set
        $existing_group = get_post_meta($post_id, $prefix . 'itens_grupo', true);
        if (empty($existing_group)) {
            $default_items = array(
                array(
                    'titulo'    => 'Projetos pontuais',
                    'descricao' => 'Entrega de projetos pontuais de acordo com a necessidade do seu negócio: sites, estruturação da sua base de dados, criativos e o que mais a sua empresa precisar.'
                ),
                array(
                    'titulo'    => 'Time compartilhado',
                    'descricao' => 'Um time de profissionais que irão operar o seu negócio dividindo a atenção com outras empresas. Modelo desenhado para diminuir os custos da sua empresa.'
                ),
                array(
                    'titulo'    => 'Time dedicado',
                    'descricao' => 'Profissionais ou times dedicados para atender grandes demandas com processos robustos e que buscam soluções de alta qualidade no menor tempo possível.'
                )
            );
            update_post_meta($post_id, $prefix . 'itens_grupo', $default_items);
        }
    }
}



/**
 * Register CMB2 Custom Fields for the Marquee Section (Partner Logos)
 */
add_action('cmb2_admin_init', 'agencia_register_marquee_metabox');
function agencia_register_marquee_metabox()
{
    $prefix = 'agencia_marquee_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_marquee_metabox',
        'title'        => esc_html__('Configurações dos Parceiros (Carrossel)', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Client Logos (Marquee Carousel)
    $cmb->add_field(array(
        'name' => esc_html__('Logos dos Parceiros (Carrossel)', 'agencia'),
        'desc' => esc_html__('Selecione ou envie as logos das empresas parceiras para o carrossel marquee.', 'agencia'),
        'id'   => $prefix . 'client_logos',
        'type' => 'file_list',
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Register CMB2 Custom Fields for the Differential Section
 */
add_action('cmb2_admin_init', 'agencia_register_diferencial_metabox');
function agencia_register_diferencial_metabox()
{
    $prefix = 'agencia_diferencial_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_diferencial_metabox',
        'title'        => esc_html__('Configurações do Diferencial', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Badge
    $cmb->add_field(array(
        'name' => esc_html__('Tag da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Nosso Diferencial', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Não precisa de mais uma agência...', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Section Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Descrição da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Do branding ao funil de vendas previsível...', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea_small',
    ));

    // Repeater Group for Cards
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Gerencie os cards de diferenciais', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Card {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Novo Card', 'agencia'),
            'remove_button'     => esc_html__('Remover Card', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este card?', 'agencia'),
        ),
    ));

    // Subfield: Image
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Ícone/Imagem', 'agencia'),
        'id'   => 'image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
    ));

    // Subfield: Title
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título', 'agencia'),
        'id'   => 'title',
        'type' => 'text',
    ));

    // Subfield: Description
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));
}

/**
 * Register CMB2 Custom Fields for the Solutions Section
 */
add_action('cmb2_admin_init', 'agencia_register_solucoes_metabox');
function agencia_register_solucoes_metabox()
{
    $prefix = 'agencia_solucoes_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_solucoes_metabox',
        'title'        => esc_html__('Configurações de Soluções', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Badge
    $cmb->add_field(array(
        'name' => esc_html__('Tag da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Soluções R8', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Soluções completas de...', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Section Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Descrição da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Do branding ao funil de vendas...', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea_small',
    ));

    // Repeater Group for Cards
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Gerencie os cards de soluções', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Solução {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Nova Solução', 'agencia'),
            'remove_button'     => esc_html__('Remover Solução', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));

    // Subfield: Image
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Imagem de Fundo', 'agencia'),
        'id'   => 'image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
    ));

    // Subfield: Title
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título', 'agencia'),
        'id'   => 'title',
        'type' => 'text',
    ));

    // Subfield: List Items
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Itens (um por linha)', 'agencia'),
        'desc' => esc_html__('Digite cada item em uma linha nova para compor a lista', 'agencia'),
        'id'   => 'items',
        'type' => 'textarea_small',
    ));
}

/**
 * Register CMB2 Custom Fields for the Resultados Section
 */
add_action('cmb2_admin_init', 'agencia_register_resultados_metabox');
function agencia_register_resultados_metabox()
{
    $prefix = 'agencia_resultados_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_resultados_metabox',
        'title'        => esc_html__('Configurações dos Resultados', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Nossos resultados em números', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Repeater Group for Cards
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Gerencie os cards de resultados', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Resultado {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Novo Resultado', 'agencia'),
            'remove_button'     => esc_html__('Remover Resultado', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este resultado?', 'agencia'),
        ),
    ));

    // Subfield: Number/Value
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Número / Valor', 'agencia'),
        'id'   => 'number',
        'type' => 'text',
        'desc' => esc_html__('Ex: +400, R$1M, 13', 'agencia'),
    ));

    // Subfield: Label/Description
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'label',
        'type' => 'text',
        'desc' => esc_html__('Ex: projetos escalados, anos acelerando negócios', 'agencia'),
    ));
}

/**
 * Seed default values for Resultados metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_resultados_data');
function agencia_seed_resultados_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_resultados_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Nossos resultados em números');
        }

        // Seed group (repeater) if not set or empty
        $existing_group = get_post_meta($post_id, $prefix . 'group', true);
        if (empty($existing_group)) {
            $default_group = array(
                array(
                    'number' => '+400',
                    'label'  => 'projetos escalados',
                ),
                array(
                    'number' => 'R$1M',
                    'label'  => 'em mídia otimizada no último ano',
                ),
                array(
                    'number' => '13',
                    'label'  => 'anos acelerando negócios',
                ),
            );
            update_post_meta($post_id, $prefix . 'group', $default_group);
        }
    }
}

/**
 * Register CMB2 Custom Fields for the Performance Section
 */
add_action('cmb2_admin_init', 'agencia_register_performance_metabox');
function agencia_register_performance_metabox()
{
    $prefix = 'agencia_performance_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_performance_metabox',
        'title'        => esc_html__('Configurações de Performance', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Badge
    $cmb->add_field(array(
        'name' => esc_html__('Tag da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Nossos resultados', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Resultados que comprovam nossa performance', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Section Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Descrição da Seção', 'agencia'),
        'desc' => esc_html__('Ex: De indústrias a e-commerces...', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea_small',
    ));

    // Repeater Group for Performance Cards
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Gerencie os cards de performance', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Card {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Novo Card', 'agencia'),
            'remove_button'     => esc_html__('Remover Card', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover este card?', 'agencia'),
        ),
    ));

    // Subfield: Logo
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Logo da Empresa', 'agencia'),
        'id'   => 'logo',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'preview_size' => 'thumbnail',
    ));

    // Subfield: Num 1
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Valor 1 (Métrica 1)', 'agencia'),
        'id'   => 'num1',
        'type' => 'text',
    ));

    // Subfield: Desc 1
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição 1 (Métrica 1)', 'agencia'),
        'id'   => 'desc1',
        'type' => 'text',
    ));

    // Subfield: Num 2
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Valor 2 (Métrica 2)', 'agencia'),
        'id'   => 'num2',
        'type' => 'text',
    ));

    // Subfield: Desc 2
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição 2 (Métrica 2)', 'agencia'),
        'id'   => 'desc2',
        'type' => 'text',
    ));
}

/**
 * Seed default values for Performance metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_performance_data');
function agencia_seed_performance_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_performance_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Nossos resultados');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Resultados que comprovam nossa performance');
        }

        // Seed subtitle if not set
        $existing_subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);
        if ($existing_subtitle === '') {
            update_post_meta($post_id, $prefix . 'subtitle', 'De indústrias a e-commerces, de clínicas a agronegócios — entregamos resultados reais que escalam negócios.');
        }

        // Seed group (repeater) if not set or empty
        $existing_group = get_post_meta($post_id, $prefix . 'group', true);
        if (empty($existing_group)) {
            $default_logo = get_template_directory_uri() . '/assets/images/logo.svg';
            $default_group = array(
                array(
                    'logo'  => $default_logo,
                    'num1'  => '180%',
                    'desc1' => 'No faturamento em 6 meses',
                    'num2'  => '180%',
                    'desc2' => 'No faturamento em 6 meses',
                ),
                array(
                    'logo'  => $default_logo,
                    'num1'  => '180%',
                    'desc1' => 'No faturamento em 6 meses',
                    'num2'  => '180%',
                    'desc2' => 'No faturamento em 6 meses',
                ),
                array(
                    'logo'  => $default_logo,
                    'num1'  => '180%',
                    'desc1' => 'No faturamento em 6 meses',
                    'num2'  => '180%',
                    'desc2' => 'No faturamento em 6 meses',
                ),
                array(
                    'logo'  => $default_logo,
                    'num1'  => '180%',
                    'desc1' => 'No faturamento em 6 meses',
                    'num2'  => '180%',
                    'desc2' => 'No faturamento em 6 meses',
                ),
                array(
                    'logo'  => $default_logo,
                    'num1'  => '180%',
                    'desc1' => 'No faturamento em 6 meses',
                    'num2'  => '180%',
                    'desc2' => 'No faturamento em 6 meses',
                ),
            );
            update_post_meta($post_id, $prefix . 'group', $default_group);
        }
    }
}

/**
 * Register CMB2 Custom Fields for the Video Section
 */
add_action('cmb2_admin_init', 'agencia_register_video_metabox');
function agencia_register_video_metabox()
{
    $prefix = 'agencia_video_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_video_metabox',
        'title'        => esc_html__('Configurações do Vídeo', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Badge
    $cmb->add_field(array(
        'name' => esc_html__('Tag da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Conheça a R8', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Assista nosso vídeo institucional...', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Video URL
    $cmb->add_field(array(
        'name' => esc_html__('URL do Vídeo (YouTube, Vimeo, etc.)', 'agencia'),
        'desc' => esc_html__('Insira o link do vídeo para incorporação', 'agencia'),
        'id'   => $prefix . 'url',
        'type' => 'text_url',
    ));

    // Video Cover
    $cmb->add_field(array(
        'name' => esc_html__('Imagem de Capa do Vídeo', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem de capa (ex: video.webp)', 'agencia'),
        'id'   => $prefix . 'cover',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'preview_size' => 'thumbnail',
    ));

    // Button CTA Text
    $cmb->add_field(array(
        'name' => esc_html__('Texto do Botão CTA', 'agencia'),
        'desc' => esc_html__('Ex: Agende uma reunião', 'agencia'),
        'id'   => $prefix . 'cta_text',
        'type' => 'text',
    ));

    // Button CTA Link
    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão CTA', 'agencia'),
        'desc' => esc_html__('Ex: #', 'agencia'),
        'id'   => $prefix . 'cta_link',
        'type' => 'text',
    ));
}

/**
 * Seed default values for Video metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_video_data');
function agencia_seed_video_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_video_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Conheça a R8');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Assista nosso vídeo institucional e venha transformar ideias em impacto');
        }

        // Seed video URL if not set
        $existing_url = get_post_meta($post_id, $prefix . 'url', true);
        if ($existing_url === '') {
            update_post_meta($post_id, $prefix . 'url', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        }

        // Seed video cover if not set
        $existing_cover = get_post_meta($post_id, $prefix . 'cover', true);
        if ($existing_cover === '') {
            $default_cover = get_template_directory_uri() . '/assets/images/video.webp';
            update_post_meta($post_id, $prefix . 'cover', $default_cover);
        }

        // Seed CTA text if not set
        $existing_cta_text = get_post_meta($post_id, $prefix . 'cta_text', true);
        if ($existing_cta_text === '') {
            update_post_meta($post_id, $prefix . 'cta_text', 'Agende uma reunião');
        }

        // Seed CTA link if not set
        $existing_cta_link = get_post_meta($post_id, $prefix . 'cta_link', true);
        if ($existing_cta_link === '') {
            update_post_meta($post_id, $prefix . 'cta_link', '#');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the Certificações Section
 */
add_action('cmb2_admin_init', 'agencia_register_certificacoes_metabox');
function agencia_register_certificacoes_metabox()
{
    $prefix = 'agencia_certificacoes_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_certificacoes_metabox',
        'title'        => esc_html__('Configurações de Certificações', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Certificações e parceria', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    // Logos list
    $cmb->add_field(array(
        'name' => esc_html__('Logos das Certificações', 'agencia'),
        'desc' => esc_html__('Selecione ou envie as logos das certificadoras/parceiros', 'agencia'),
        'id'   => $prefix . 'logos',
        'type' => 'file_list',
        'preview_size' => 'thumbnail',
    ));
}

/**
 * Seed default values for Certificações metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_certificacoes_data');
function agencia_seed_certificacoes_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_certificacoes_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Certificações e parceria');
        }
    }
}

/**
 * Register CMB2 Custom Fields for the Metodologia Section
 */
add_action('cmb2_admin_init', 'agencia_register_metodologia_metabox');
function agencia_register_metodologia_metabox()
{
    $prefix = 'agencia_metodologia_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_metodologia_metabox',
        'title'        => esc_html__('Configurações da Metodologia', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Badge
    $cmb->add_field(array(
        'name' => esc_html__('Tag da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Metodologia', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Nossa Metodologia: do diagnóstico à escala contínua', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    // Section Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Descrição da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Do branding ao funil de vendas previsível...', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea_small',
    ));

    // Repeater Group for steps
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Gerencie as etapas da metodologia', 'agencia'),
        'options'     => array(
            'group_title'       => esc_html__('Etapa {#}', 'agencia'),
            'add_button'        => esc_html__('Adicionar Nova Etapa', 'agencia'),
            'remove_button'     => esc_html__('Remover Etapa', 'agencia'),
            'sortable'          => true,
            'closed'            => true,
            'remove_confirm'    => esc_html__('Tem certeza que deseja remover esta etapa?', 'agencia'),
        ),
    ));

    // Subfield: Step Number
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Número da Etapa', 'agencia'),
        'id'   => 'numero',
        'type' => 'text',
        'desc' => esc_html__('Ex: 01, 02, 03', 'agencia'),
    ));

    // Subfield: Step Title
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título da Etapa', 'agencia'),
        'id'   => 'title',
        'type' => 'text',
    ));

    // Subfield: Step Description
    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição da Etapa', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));
}

/**
 * Seed default values for Metodologia metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_metodologia_data');
function agencia_seed_metodologia_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_metodologia_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed badge if not set
        $existing_badge = get_post_meta($post_id, $prefix . 'badge', true);
        if ($existing_badge === '') {
            update_post_meta($post_id, $prefix . 'badge', 'Metodologia');
        }

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', 'Nossa Metodologia:<br> do diagnóstico à escala contínua');
        }

        // Seed subtitle if not set
        $existing_subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);
        if ($existing_subtitle === '') {
            update_post_meta($post_id, $prefix . 'subtitle', 'Do branding ao funil de vendas previsível, oferecemos soluções integradas para empresas que querem escalar com performance.');
        }

        // Seed group if empty
        $existing_group = get_post_meta($post_id, $prefix . 'group', true);
        if (empty($existing_group)) {
            $default_group = array(
                array(
                    'numero'      => '01',
                    'title'       => 'Diagnóstico estratégico',
                    'description' => 'Análise de mercado, dores e metas.',
                ),
                array(
                    'numero'      => '02',
                    'title'       => 'Plano de crescimento',
                    'description' => 'Estratégias e cronograma.',
                ),
                array(
                    'numero'      => '03',
                    'title'       => 'Integração de ferramentas e equipes',
                    'description' => 'Organização dos processos.',
                ),
                array(
                    'numero'      => '04',
                    'title'       => 'Atração e conversão',
                    'description' => 'Organização dos processos.',
                ),
                array(
                    'numero'      => '05',
                    'title'       => 'Otimização baseada em dados',
                    'description' => 'Organização dos processos.',
                ),
                array(
                    'numero'      => '06',
                    'title'       => 'Escala e expansão',
                    'description' => 'Organização dos processos.',
                ),
            );
            update_post_meta($post_id, $prefix . 'group', $default_group);
        }
    }
}

/**
 * Register CMB2 Custom Fields for the Impulsionar Section
 */
add_action('cmb2_admin_init', 'agencia_register_impulsionar_metabox');
function agencia_register_impulsionar_metabox()
{
    $prefix = 'agencia_impulsionar_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_impulsionar_metabox',
        'title'        => esc_html__('Configurações da Seção Impulsionar', 'agencia'),
        'object_types' => array('page'), // Post type: page
        'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    // Section Title
    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Insira o título principal (com quebras de linha <br> se desejar)', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    // Section Subtitle
    $cmb->add_field(array(
        'name' => esc_html__('Descrição da Seção', 'agencia'),
        'desc' => esc_html__('Insira a descrição abaixo do título', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea_small',
    ));

    // CTA Text
    $cmb->add_field(array(
        'name' => esc_html__('Texto do Botão CTA', 'agencia'),
        'desc' => esc_html__('Texto do botão (ex: Falar com um especialista)', 'agencia'),
        'id'   => $prefix . 'cta_text',
        'type' => 'text',
    ));

    // CTA Link
    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão CTA', 'agencia'),
        'desc' => esc_html__('Link de destino do botão', 'agencia'),
        'id'   => $prefix . 'cta_link',
        'type' => 'text',
    ));

    // Section Image
    $cmb->add_field(array(
        'name' => esc_html__('Imagem da Seção', 'agencia'),
        'desc' => esc_html__('Selecione ou envie a imagem para o lado direito da seção', 'agencia'),
        'id'   => $prefix . 'image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'preview_size' => 'medium',
    ));
}

/**
 * Seed default values for Impulsionar metabox on page-home.php template pages
 */
add_action('admin_init', 'agencia_seed_impulsionar_data');
function agencia_seed_impulsionar_data()
{
    if (!is_admin()) {
        return;
    }

    $home_pages = get_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'posts_per_page' => -1,
    ));

    if (empty($home_pages)) {
        return;
    }

    $prefix = 'agencia_impulsionar_';

    foreach ($home_pages as $home_page) {
        $post_id = $home_page->ID;

        // Seed title if not set
        $existing_title = get_post_meta($post_id, $prefix . 'title', true);
        if ($existing_title === '') {
            update_post_meta($post_id, $prefix . 'title', "Impulsionamos Negócios <br>\nB2B e e-commerce com <br>\nMarketing e Tecnologia <br>\nInteligentes");
        }

        // Seed subtitle if not set
        $existing_subtitle = get_post_meta($post_id, $prefix . 'subtitle', true);
        if ($existing_subtitle === '') {
            update_post_meta($post_id, $prefix . 'subtitle', 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável');
        }

        // Seed CTA text if not set
        $existing_cta_text = get_post_meta($post_id, $prefix . 'cta_text', true);
        if ($existing_cta_text === '') {
            update_post_meta($post_id, $prefix . 'cta_text', 'Falar com um especialista');
        }

        // Seed CTA link if not set
        $existing_cta_link = get_post_meta($post_id, $prefix . 'cta_link', true);
        if ($existing_cta_link === '') {
            update_post_meta($post_id, $prefix . 'cta_link', '#');
        }
    }
}

/**
 * Defer non-critical scripts on the frontend for PageSpeed optimization (reduces TBT)
 */
add_filter('script_loader_tag', 'agencia_defer_scripts', 10, 2);
function agencia_defer_scripts($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    $defer_handles = array('agencia-geral-js', 'jquery-core', 'jquery-migrate', 'wp-embed');

    if (in_array($handle, $defer_handles)) {
        return str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}

/**
 * Disable WordPress Emojis to improve Total Blocking Time (TBT)
 */
add_action('init', 'agencia_disable_emojis');
function agencia_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'agencia_disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'agencia_disable_emoji_dns_prefetch', 10, 2);
}

function agencia_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

function agencia_disable_emoji_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/14.0.0/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}
