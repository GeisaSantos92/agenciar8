<?php

/**
 * Custom Post Types: Soluções, Modelos de Negócio e Cases
 */

/**
 * Lista dos CPTs do tema (usada nos templates, CSS e campos)
 */
function agencia_cpts()
{
    return array('solucao', 'modelo_negocio', 'case');
}

add_action('init', 'agencia_register_cpts');
function agencia_register_cpts()
{
    // Soluções
    register_post_type('solucao', array(
        'labels' => array(
            'name'               => 'Soluções',
            'singular_name'      => 'Solução',
            'add_new'            => 'Adicionar nova',
            'add_new_item'       => 'Adicionar nova solução',
            'edit_item'          => 'Editar solução',
            'new_item'           => 'Nova solução',
            'view_item'          => 'Ver solução',
            'search_items'       => 'Buscar soluções',
            'not_found'          => 'Nenhuma solução encontrada',
            'not_found_in_trash' => 'Nenhuma solução na lixeira',
            'all_items'          => 'Todas as soluções',
            'menu_name'          => 'Soluções',
        ),
        'public'       => true,
        'has_archive'  => 'solucoes',
        'rewrite'      => array('slug' => 'solucoes', 'with_front' => false),
        'menu_icon'    => 'dashicons-lightbulb',
        'menu_position' => 20,
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'show_in_rest' => true,
    ));

    // Área da solução (Marketing, Tecnologia, Vendas...) — monta as colunas do menu
    register_taxonomy('area_solucao', array('solucao'), array(
        'labels' => array(
            'name'          => 'Áreas',
            'singular_name' => 'Área',
            'add_new_item'  => 'Adicionar nova área',
            'edit_item'     => 'Editar área',
            'all_items'     => 'Todas as áreas',
            'menu_name'     => 'Áreas',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'solucoes/area', 'with_front' => false),
    ));

    // Modelos de Negócio
    register_post_type('modelo_negocio', array(
        'labels' => array(
            'name'               => 'Modelos de Negócio',
            'singular_name'      => 'Modelo de Negócio',
            'add_new'            => 'Adicionar novo',
            'add_new_item'       => 'Adicionar novo modelo',
            'edit_item'          => 'Editar modelo',
            'new_item'           => 'Novo modelo',
            'view_item'          => 'Ver modelo',
            'search_items'       => 'Buscar modelos',
            'not_found'          => 'Nenhum modelo encontrado',
            'not_found_in_trash' => 'Nenhum modelo na lixeira',
            'all_items'          => 'Todos os modelos',
            'menu_name'          => 'Modelos de Negócio',
        ),
        'public'       => true,
        'has_archive'  => 'modelos-de-negocio',
        'rewrite'      => array('slug' => 'modelos-de-negocio', 'with_front' => false),
        'menu_icon'    => 'dashicons-networking',
        'menu_position' => 21,
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'show_in_rest' => true,
    ));

    // Cases
    register_post_type('case', array(
        'labels' => array(
            'name'               => 'Cases',
            'singular_name'      => 'Case',
            'add_new'            => 'Adicionar novo',
            'add_new_item'       => 'Adicionar novo case',
            'edit_item'          => 'Editar case',
            'new_item'           => 'Novo case',
            'view_item'          => 'Ver case',
            'search_items'       => 'Buscar cases',
            'not_found'          => 'Nenhum case encontrado',
            'not_found_in_trash' => 'Nenhum case na lixeira',
            'all_items'          => 'Todos os cases',
            'menu_name'          => 'Cases',
        ),
        'public'       => true,
        'has_archive'  => 'cases',
        'rewrite'      => array('slug' => 'cases', 'with_front' => false),
        'menu_icon'    => 'dashicons-awards',
        'menu_position' => 22,
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'show_in_rest' => true,
    ));
}

/**
 * Atualiza os permalinks quando o tema é ativado ou quando os CPTs mudam de versão
 */
add_action('after_switch_theme', 'flush_rewrite_rules');

add_action('init', 'agencia_maybe_flush_rewrite', 99);
function agencia_maybe_flush_rewrite()
{
    $version = '1';
    if (get_option('agencia_cpt_version') !== $version) {
        flush_rewrite_rules();
        update_option('agencia_cpt_version', $version);
    }
}

/**
 * Ordena as listagens dos CPTs pela ordem manual (Atributos > Ordem)
 */
add_action('pre_get_posts', 'agencia_cpt_archive_order');
function agencia_cpt_archive_order($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_post_type_archive(agencia_cpts()) || $query->is_tax('area_solucao')) {
        $query->set('orderby', array('menu_order' => 'ASC', 'date' => 'DESC'));
    }
}

/**
 * Campos CMB2 comuns às singles (Hero + CTA)
 */
add_action('cmb2_admin_init', 'agencia_register_cpt_hero_metabox');
function agencia_register_cpt_hero_metabox()
{
    $prefix = 'agencia_single_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_single_hero_metabox',
        'title'        => esc_html__('Hero (Dobra Inicial)', 'agencia'),
        'object_types' => array('case'), // Soluções e Modelos de Negócio têm campos próprios em inc/solucoes.php e inc/modelos.php
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Badge', 'agencia'),
        'desc' => esc_html__('Texto pequeno acima do título. Se vazio, usa a área (Soluções) ou o nome do tipo de conteúdo.', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Hero (H1)', 'agencia'),
        'desc' => esc_html__('Se vazio, usa o título do post. Aceita <br>.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Subtítulo da Hero', 'agencia'),
        'desc' => esc_html__('Se vazio, usa o resumo (excerpt) do post.', 'agencia'),
        'id'   => $prefix . 'subtitle',
        'type' => 'textarea',
    ));

    $cmb->add_field(array(
        'name'    => esc_html__('Texto do Botão CTA', 'agencia'),
        'id'      => $prefix . 'cta_text',
        'type'    => 'text',
        'default' => 'Quero gerar mais resultados',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão CTA', 'agencia'),
        'id'   => $prefix . 'cta_link',
        'type' => 'text_url',
    ));
}

/**
 * Dados do Case (cliente, segmento e resultados)
 */
add_action('cmb2_admin_init', 'agencia_register_case_metabox');
function agencia_register_case_metabox()
{
    $prefix = 'agencia_case_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_case_metabox',
        'title'        => esc_html__('Dados do Case', 'agencia'),
        'object_types' => array('case'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Cliente', 'agencia'),
        'id'   => $prefix . 'cliente',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Segmento', 'agencia'),
        'desc' => esc_html__('Ex: Indústria, E-commerce, SaaS', 'agencia'),
        'id'   => $prefix . 'segmento',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Soluções aplicadas', 'agencia'),
        'id'         => $prefix . 'solucoes',
        'type'       => 'multicheck',
        'options_cb' => 'agencia_solucoes_options',
    ));

    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'resultados',
        'type'        => 'group',
        'description' => esc_html__('Resultados em números', 'agencia'),
        'options'     => array(
            'group_title'    => esc_html__('Resultado {#}', 'agencia'),
            'add_button'     => esc_html__('Adicionar Resultado', 'agencia'),
            'remove_button'  => esc_html__('Remover Resultado', 'agencia'),
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Número', 'agencia'),
        'desc' => esc_html__('Ex: +320%', 'agencia'),
        'id'   => 'number',
        'type' => 'text',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Legenda', 'agencia'),
        'desc' => esc_html__('Ex: em leads qualificados', 'agencia'),
        'id'   => 'label',
        'type' => 'text',
    ));
}

/**
 * Opções do multicheck "Soluções aplicadas" no Case
 */
function agencia_solucoes_options()
{
    $options = array();
    $solucoes = get_posts(array(
        'post_type'      => 'solucao',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ));

    foreach ($solucoes as $solucao) {
        $options[$solucao->ID] = $solucao->post_title;
    }

    return $options;
}

/**
 * Seed: cria as áreas e os itens que já estavam no menu do layout (roda uma vez)
 */
add_action('admin_init', 'agencia_seed_cpts');
function agencia_seed_cpts()
{
    if (get_option('agencia_cpts_seeded')) {
        return;
    }

    $solucoes = array(
        'Marketing'  => array('Mídia e performance', 'Inbound Marketing', 'Audiovisual', 'Automação de marketing', 'Landing page e hotsites'),
        'Tecnologia' => array('Suporte e manutenção', 'Sites Institucionais', 'E-commerce', 'Hospedagem de sites', 'E-mail Profissional'),
        'Vendas'     => array(),
    );

    $order = 0;
    foreach ($solucoes as $area => $itens) {
        $term = term_exists($area, 'area_solucao');
        if (!$term) {
            $term = wp_insert_term($area, 'area_solucao');
        }
        if (is_wp_error($term)) {
            continue;
        }

        foreach ($itens as $titulo) {
            $post_id = wp_insert_post(array(
                'post_type'   => 'solucao',
                'post_title'  => $titulo,
                'post_status' => 'publish',
                'menu_order'  => $order++,
            ));
            if ($post_id && !is_wp_error($post_id)) {
                wp_set_object_terms($post_id, (int) $term['term_id'], 'area_solucao');
            }
        }
    }

    $modelos = array('Mídia e performance', 'Suporte e manutenção', 'Implementação e Integração', 'Branding');
    foreach ($modelos as $i => $titulo) {
        wp_insert_post(array(
            'post_type'   => 'modelo_negocio',
            'post_title'  => $titulo,
            'post_status' => 'publish',
            'menu_order'  => $i,
        ));
    }

    update_option('agencia_cpts_seeded', 1);
}
