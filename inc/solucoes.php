<?php

/**
 * Single de Soluções: campos CMB2, formulário do hero e seed das páginas Branding e UX/UI
 */

/**
 * Register CMB2 Custom Fields for the Hero Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_hero_metabox');
function agencia_register_sol_hero_metabox()
{
    $prefix = 'agencia_sol_hero_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_hero_metabox',
        'title'        => esc_html__('Hero (Dobra Inicial)', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título - parte em destaque (amarelo)', 'agencia'),
        'desc' => esc_html__('Ex: Branding estratégico', 'agencia'),
        'id'   => $prefix . 'title_highlight',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título - continuação (branco)', 'agencia'),
        'desc' => esc_html__('Ex: para fortalecer sua marca e gerar confiança. Se o título ficar todo vazio, usa o título do post.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Texto', 'agencia'),
        'id'   => $prefix . 'text',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título do Formulário', 'agencia'),
        'desc' => esc_html__('Se vazio, o formulário não é exibido. Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'form_title',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name'    => esc_html__('Texto do Botão do Formulário', 'agencia'),
        'id'      => $prefix . 'form_button',
        'type'    => 'text',
        'default' => 'Começar agora',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('E-mail que recebe os contatos', 'agencia'),
        'desc' => esc_html__('Se vazio, envia para o e-mail do administrador do site.', 'agencia'),
        'id'   => $prefix . 'form_email',
        'type' => 'text_email',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Shortcode de formulário (opcional)', 'agencia'),
        'desc' => esc_html__('Preencha para usar um plugin de formulário (ex: Contact Form 7) no lugar do formulário padrão.', 'agencia'),
        'id'   => $prefix . 'form_shortcode',
        'type' => 'text',
    ));
}

/**
 * Register CMB2 Custom Fields for the "Entregas" Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_entregas_metabox');
function agencia_register_sol_entregas_metabox()
{
    $prefix = 'agencia_sol_entregas_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_entregas_metabox',
        'title'        => esc_html__('Seção "Nossas entregas"', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Badge da Seção', 'agencia'),
        'desc' => esc_html__('Ex: O que entregamos', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Texto da Seção', 'agencia'),
        'id'   => $prefix . 'text',
        'type' => 'textarea_small',
    ));

    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Cards de entregas', 'agencia'),
        'options'     => array(
            'group_title'    => esc_html__('Entrega {#}', 'agencia'),
            'add_button'     => esc_html__('Adicionar Entrega', 'agencia'),
            'remove_button'  => esc_html__('Remover Entrega', 'agencia'),
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Ícone', 'agencia'),
        'desc' => esc_html__('Opcional. Se vazio, usa o ícone padrão do layout.', 'agencia'),
        'id'   => 'icon',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'preview_size' => 'thumbnail',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => 'title',
        'type' => 'textarea_small',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));
}

/**
 * Register CMB2 Custom Fields for the "Galeria" Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_galeria_metabox');
function agencia_register_sol_galeria_metabox()
{
    $prefix = 'agencia_sol_galeria_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_galeria_metabox',
        'title'        => esc_html__('Seção "Galeria"', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Badge da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Galeria', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Texto da Seção', 'agencia'),
        'id'   => $prefix . 'text',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Imagens', 'agencia'),
        'desc' => esc_html__('As imagens passam em duas faixas animadas. Use a mesma altura visual (a largura pode variar).', 'agencia'),
        'id'   => $prefix . 'images',
        'type' => 'file_list',
        'preview_size' => array(100, 100),
        'query_args'   => array('type' => 'image'),
    ));

    $cmb->add_field(array(
        'name'    => esc_html__('Texto do Botão', 'agencia'),
        'id'      => $prefix . 'cta_text',
        'type'    => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão', 'agencia'),
        'desc' => esc_html__('Se vazio, leva para a listagem de Cases.', 'agencia'),
        'id'   => $prefix . 'cta_link',
        'type' => 'text_url',
    ));
}

/**
 * Register CMB2 Custom Fields for the "Processo" Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_processo_metabox');
function agencia_register_sol_processo_metabox()
{
    $prefix = 'agencia_sol_processo_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_processo_metabox',
        'title'        => esc_html__('Seção "Processo"', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Badge da Seção', 'agencia'),
        'desc' => esc_html__('Ex: Como funciona', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Etapas (numeradas automaticamente)', 'agencia'),
        'options'     => array(
            'group_title'    => esc_html__('Etapa {#}', 'agencia'),
            'add_button'     => esc_html__('Adicionar Etapa', 'agencia'),
            'remove_button'  => esc_html__('Remover Etapa', 'agencia'),
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Título', 'agencia'),
        'id'   => 'title',
        'type' => 'text',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));
}

/**
 * Register CMB2 Custom Fields for the "FAQ" Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_faq_metabox');
function agencia_register_sol_faq_metabox()
{
    $prefix = 'agencia_sol_faq_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_faq_metabox',
        'title'        => esc_html__('Seção "Perguntas Frequentes"', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Badge da Seção', 'agencia'),
        'desc' => esc_html__('Ex: FAQ', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'group',
        'type'        => 'group',
        'description' => esc_html__('Perguntas e respostas', 'agencia'),
        'options'     => array(
            'group_title'    => esc_html__('Pergunta {#}', 'agencia'),
            'add_button'     => esc_html__('Adicionar Pergunta', 'agencia'),
            'remove_button'  => esc_html__('Remover Pergunta', 'agencia'),
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Pergunta', 'agencia'),
        'id'   => 'question',
        'type' => 'text',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => esc_html__('Resposta', 'agencia'),
        'id'   => 'answer',
        'type' => 'textarea',
    ));
}

/**
 * Register CMB2 Custom Fields for the "CTA" Section on Soluções
 */
add_action('cmb2_admin_init', 'agencia_register_sol_cta_metabox');
function agencia_register_sol_cta_metabox()
{
    $prefix = 'agencia_sol_cta_';

    $cmb = new_cmb2_box(array(
        'id'           => 'agencia_sol_cta_metabox',
        'title'        => esc_html__('Seção "CTA" (antes do rodapé)', 'agencia'),
        'object_types' => array('solucao'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site. Coloque entre *asteriscos* o trecho em amarelo. Ex: *Seu site* sempre seguro, (enter) rápido e atualizado. Se vazio, exibe o CTA padrão do site.', 'agencia'),
        'id'   => $prefix . 'heading',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Texto', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'text',
        'type' => 'textarea_small',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Texto do Botão', 'agencia'),
        'id'   => $prefix . 'button_text',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Link do Botão', 'agencia'),
        'desc' => esc_html__('Se vazio, rola até o formulário do topo da página.', 'agencia'),
        'id'   => $prefix . 'button_link',
        'type' => 'text',
    ));
}

/**
 * A Solução atual tem CTA próprio? (usado no footer.php para não repetir o CTA padrão)
 */
function agencia_solucao_tem_cta()
{
    if (is_post_type_archive('case') || is_singular('case')) {
        return trim((string) agencia_cases_opcao('cta_heading')) !== '';
    }

    if (is_singular('solucao')) {
        $key = 'agencia_sol_cta_heading';
    } elseif (is_singular('modelo_negocio')) {
        $key = 'agencia_mod_cta_heading';
    } else {
        return false;
    }

    return trim((string) get_post_meta(get_queried_object_id(), $key, true)) !== '';
}

/**
 * Palavras com hífen (e-commerce, e-mail) não quebram no hífen, como no layout. Recebe texto já escapado.
 */
function agencia_sem_quebra_hifen($html)
{
    return preg_replace('/(?<![\w-])(\w+(?:-\w+)+)(?![\w-])/u', '<span class="nowrap">$1</span>', $html);
}

/**
 * Títulos das seções: cada quebra de linha do painel vira <br> (mesma disposição do layout)
 */
function agencia_solucao_titulo_html($title)
{
    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $title)));

    return agencia_sem_quebra_hifen(implode(' <br>', array_map('esc_html', $lines)));
}

/**
 * Título do CTA: cada linha vira um bloco e o texto entre *asteriscos* fica amarelo
 */
function agencia_solucao_cta_heading_html($heading)
{
    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $heading)));
    $html  = '';

    foreach ($lines as $line) {
        $line  = preg_replace('/\*(.+?)\*/', '<span class="text-yellow">$1</span>', agencia_sem_quebra_hifen(esc_html($line)));
        $html .= '<span class="cta-solucao__linha">' . $line . '</span>';
    }

    return $html;
}

/**
 * Migração: os campos antigos do título do CTA (linha branca + linha amarela) viram o campo único "heading"
 */
add_action('admin_init', 'agencia_migrate_sol_cta_heading');
function agencia_migrate_sol_cta_heading()
{
    if (get_option('agencia_sol_cta_heading_migrated')) {
        return;
    }

    $posts = get_posts(array('post_type' => 'solucao', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids'));
    foreach ($posts as $post_id) {
        $title     = trim((string) get_post_meta($post_id, 'agencia_sol_cta_title', true));
        $highlight = trim((string) get_post_meta($post_id, 'agencia_sol_cta_title_highlight', true));

        if (($title !== '' || $highlight !== '') && get_post_meta($post_id, 'agencia_sol_cta_heading', true) === '') {
            $lines = array_filter(array($title, $highlight !== '' ? '*' . $highlight . '*' : ''));
            update_post_meta($post_id, 'agencia_sol_cta_heading', implode("\n", $lines));
        }

        delete_post_meta($post_id, 'agencia_sol_cta_title');
        delete_post_meta($post_id, 'agencia_sol_cta_title_highlight');
    }

    update_option('agencia_sol_cta_heading_migrated', 1);
}

/**
 * Formulário do hero das Soluções: envia o contato por e-mail
 */
add_action('admin_post_nopriv_agencia_form_solucao', 'agencia_handle_form_solucao');
add_action('admin_post_agencia_form_solucao', 'agencia_handle_form_solucao');
function agencia_handle_form_solucao()
{
    $post_id  = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $redirect = $post_id ? get_permalink($post_id) : home_url('/');

    // Honeypot: robôs preenchem o campo escondido
    if (!empty($_POST['site'])) {
        wp_safe_redirect($redirect);
        exit;
    }

    if (!isset($_POST['agencia_form_nonce']) || !wp_verify_nonce($_POST['agencia_form_nonce'], 'agencia_form_solucao')) {
        wp_safe_redirect(add_query_arg('form', 'erro', $redirect) . '#form-solucao');
        exit;
    }

    $nome    = sanitize_text_field(wp_unslash($_POST['nome'] ?? ''));
    $tel     = sanitize_text_field(wp_unslash($_POST['telefone'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $empresa = sanitize_text_field(wp_unslash($_POST['empresa'] ?? ''));
    $modelo  = sanitize_text_field(wp_unslash($_POST['modelo'] ?? ''));
    $aceite  = !empty($_POST['aceite']) ? 'Sim' : 'Não';

    if (!$tel || !is_email($email) || !$empresa) {
        wp_safe_redirect(add_query_arg('form', 'erro', $redirect) . '#form-solucao');
        exit;
    }

    $email_key = get_post_type($post_id) === 'modelo_negocio' ? 'agencia_mod_hero_form_email' : 'agencia_sol_hero_form_email';
    $to        = get_post_meta($post_id, $email_key, true);
    if (!is_email($to)) {
        $to = get_option('admin_email');
    }

    $solucao = $post_id ? get_the_title($post_id) : '';
    $subject = sprintf('Novo contato - %s', $solucao ? $solucao : get_bloginfo('name'));
    $body    = "Solução: {$solucao}\n"
        . "Nome: {$nome}\n"
        . "Telefone: {$tel}\n"
        . "E-mail: {$email}\n"
        . "Empresa: {$empresa}\n"
        . "Modelo de Negócio: {$modelo}\n"
        . "Aceita receber comunicações: {$aceite}\n"
        . "Página: {$redirect}\n";

    $sent = wp_mail($to, $subject, $body, array('Reply-To: ' . $email));

    wp_safe_redirect(add_query_arg('form', $sent ? 'enviado' : 'erro', $redirect) . '#form-solucao');
    exit;
}

/**
 * Importa uma imagem do tema para a biblioteca de mídia (usado no seed)
 */
function agencia_seed_import_image($relative_path, $post_id = 0)
{
    $file = get_template_directory() . '/' . ltrim($relative_path, '/');
    if (!file_exists($file)) {
        return 0;
    }

    $upload = wp_upload_bits(basename($file), null, file_get_contents($file));
    if (!empty($upload['error'])) {
        return 0;
    }

    $filetype      = wp_check_filetype($upload['file']);
    $attachment_id = wp_insert_attachment(array(
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name(pathinfo($file, PATHINFO_FILENAME)),
        'post_status'    => 'inherit',
    ), $upload['file'], $post_id);

    if (is_wp_error($attachment_id) || !$attachment_id) {
        return 0;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

    return $attachment_id;
}

/**
 * Seed da Solução "Branding" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_branding');
function agencia_seed_solucao_branding()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 2;
    if (!is_admin() || (int) get_option('agencia_seed_branding_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('branding', 'Branding', 'Branding estratégico para fortalecer sua marca e gerar confiança.', 'Design');
    if (!$post_id) {
        return;
    }

    $defaults = array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Branding estratégico',
        'agencia_sol_hero_title'           => 'para fortalecer sua marca e gerar confiança',
        'agencia_sol_hero_text'            => 'Na Agência R8, o branding vai além do logotipo: criamos uma identidade sólida, consistente e memorável que diferencia sua empresa no mercado e impulsiona suas vendas.',
        'agencia_sol_hero_form_title'      => 'Comece já o seu branding estratégico e conquiste clientes com confiança',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Nossas entregas de Branding',
        'agencia_sol_entregas_text'  => 'Do branding ao funil de vendas previsível, oferecemos soluções integradas para empresas que querem escalar com performance.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Identidade visual completa', 'description' => 'Logotipo, paleta de cores, tipografia e elementos gráficos exclusivos.'),
            array('title' => 'Manual de marca', 'description' => 'Guia prático para garantir consistência em toda a comunicação.'),
            array('title' => 'Naming e posicionamento', 'description' => 'Definição de nome e propósito alinhados à essência do negócio.'),
            array('title' => 'Design de embalagens', 'description' => 'Soluções visuais que conectam produto e consumidor.'),
            array('title' => 'Aplicações práticas', 'description' => 'Cartões de visita, papelaria, materiais digitais e redes sociais.'),
            array('title' => 'Estratégia de comunicação visual', 'description' => 'Consistência em todos os pontos de contato com o cliente.'),
        ),

        // Galeria
        'agencia_sol_galeria_badge'    => 'Galeria',
        'agencia_sol_galeria_title'    => 'Branding que gera impacto',
        'agencia_sol_galeria_text'     => 'Do branding ao funil de vendas previsível, oferecemos soluções integradas para empresas que querem escalar com performance.',
        'agencia_sol_galeria_cta_text' => 'Confira nossos cases',

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo de Branding em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Briefing e Pesquisa', 'description' => 'Entendemos visão, valores e objetivos do negócio, analisamos mercado e concorrência.'),
            array('title' => 'Conceituação de Marca', 'description' => 'Criamos conceitos visuais e naming, alinhados à estratégia da empresa.'),
            array('title' => 'Design e Desenvolvimento', 'description' => 'Refinamos o logotipo e produzimos manual de marca completo.'),
            array('title' => 'Entrega Final', 'description' => 'Aplicações práticas, peças gráficas e diretrizes visuais prontas para uso.'),
        ),

        // FAQ
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Perguntas Frequentes sobre Branding',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que é Branding e por que é importante para minha empresa?',
                'answer'   => 'Branding é a gestão de tudo o que forma a percepção da sua marca: propósito, posicionamento, identidade visual, tom de voz e experiência. Uma marca bem construída gera reconhecimento, transmite confiança e facilita a decisão de compra do cliente.',
            ),
            array(
                'question' => 'Branding ajuda em vendas B2B e no digital?',
                'answer'   => 'Sim. No B2B o ciclo de venda é longo e envolve vários decisores, por isso credibilidade pesa muito. No digital, uma marca consistente melhora a taxa de cliques, a conversão das campanhas e reduz o custo de aquisição.',
            ),
            array(
                'question' => 'Qual a diferença entre identidade visual e branding?',
                'answer'   => 'A identidade visual é a parte gráfica da marca: logotipo, cores, tipografia e elementos. O branding é mais amplo e inclui a estratégia por trás dela, como posicionamento, propósito, mensagem e a forma como a marca se relaciona com o público.',
            ),
            array(
                'question' => 'Quanto tempo leva para ver resultados?',
                'answer'   => 'A entrega do projeto costuma levar algumas semanas, dependendo do escopo. Os resultados de percepção e reconhecimento são construídos com o uso consistente da marca ao longo dos meses em todos os pontos de contato.',
            ),
            array(
                'question' => 'Preciso ter uma empresa grande para investir em Branding?',
                'answer'   => 'Não. Empresas em início de operação ou em crescimento são as que mais se beneficiam, porque começam com uma base sólida e evitam retrabalho. O escopo do projeto é ajustado ao momento e ao orçamento do negócio.',
            ),
            array(
                'question' => 'Rebranding: quando é a hora certa?',
                'answer'   => 'Quando a marca não representa mais o que a empresa é, quando há mudança de público, mercado ou portfólio, após fusões, ou quando a comunicação ficou inconsistente e desatualizada em relação aos concorrentes.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'         => "Sua marca pronta para\n*crescer com autoridade*",
        'agencia_sol_cta_text'            => "Na R8, criamos marcas que inspiram confiança, atraem clientes e geram valor.\nSeja para começar do zero ou reposicionar sua empresa, desenvolvemos um branding estratégico que faz diferença.",
        'agencia_sol_cta_button_text'     => 'Quero fortalecer minha marca',
    );

    agencia_seed_solucao_meta($post_id, $defaults);

    agencia_seed_solucao_galeria($post_id, 'branding');

    update_option('agencia_seed_branding_done', $seed_version);
}

/**
 * Seed da Solução "UX e UI Design" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_uxui');
function agencia_seed_solucao_uxui()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_uxui_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('ux-ui-design', 'UX e UI Design', 'UX e UI Design para experiências digitais que convertem.', 'Design');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'UX e UI Design',
        'agencia_sol_hero_title'           => 'para experiências digitais que convertem',
        'agencia_sol_hero_text'            => 'Na Agência R8, desenvolvemos interfaces funcionais, bonitas e focadas em resultado. Garantimos que seu site, sistema ou e-commerce seja intuitivo, eficiente e preparado para escalar.',
        'agencia_sol_hero_form_title'      => 'Quer melhorar a experiência digital da sua marca?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Nossas entregas em UX e UI',
        'agencia_sol_entregas_text'  => 'Da pesquisa ao protótipo final, desenhamos experiências e interfaces intuitivas que transformam visitantes em leads qualificados.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Pesquisa e análise de usuários', 'description' => 'Entendemos jornada, necessidades e pontos de atrito.'),
            array('title' => 'Arquitetura da informação', 'description' => 'Fluxos claros de navegação para facilitar a experiência.'),
            array('title' => 'Wireframes e protótipos interativos', 'description' => 'Testes e validação antes do desenvolvimento.'),
            array('title' => 'Interface visual completa', 'description' => 'Aplicação de cores, tipografia, ícones e componentes responsivos.'),
            array('title' => 'Design System', 'description' => 'Padrões que garantem consistência e escalabilidade.'),
            array('title' => 'Otimização para SEO e performance', 'description' => 'Interfaces rápidas, acessíveis e indexáveis.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => "Nosso processo de\nUX/UI em 4 etapas",
        'agencia_sol_processo_group' => array(
            array('title' => 'Pesquisa e Imersão', 'description' => 'Reuniões de briefing, análise do público e benchmarking.'),
            array('title' => 'Estruturação e Prototipagem', 'description' => 'Mapas de navegação e wireframes navegáveis.'),
            array('title' => 'Interface Visual', 'description' => 'Aplicação de identidade visual, cores, tipografia e componentes.'),
            array('title' => 'Entrega Final', 'description' => 'Design system + arquivos prontos para integração com desenvolvimento.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Perguntas Frequentes sobre UX/UI',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Qual a diferença entre UX e UI?',
                'answer'   => 'UX (User Experience) é a experiência como um todo: como a pessoa navega, encontra o que precisa e conclui uma ação. UI (User Interface) é a camada visual dessa experiência: cores, tipografia, botões e componentes. Os dois trabalham juntos para criar interfaces bonitas e fáceis de usar.',
            ),
            array(
                'question' => 'UX/UI ajuda em vendas?',
                'answer'   => 'Sim. Uma navegação clara reduz o abandono, deixa a proposta de valor mais evidente e facilita o caminho até o contato ou a compra. Na prática, isso significa mais conversões com o mesmo volume de tráfego.',
            ),
            array(
                'question' => 'Preciso refazer meu site inteiro para aplicar UX/UI?',
                'answer'   => 'Nem sempre. Começamos analisando o que já existe e identificando os pontos de atrito. Em muitos casos, ajustes nas páginas e fluxos mais importantes já trazem ganhos relevantes; o redesign completo é indicado quando a base atual limita o crescimento.',
            ),
            array(
                'question' => 'UX/UI é importante só para sites e e-commerces?',
                'answer'   => 'Não. Sistemas, plataformas, aplicativos, landing pages e áreas de cliente também se beneficiam. Qualquer ponto de contato digital em que uma pessoa precisa entender, decidir ou executar uma tarefa depende de uma boa experiência.',
            ),
            array(
                'question' => 'Quanto tempo leva um projeto de UX/UI?',
                'answer'   => 'Depende do escopo e da quantidade de telas. Projetos de landing pages e sites institucionais costumam levar algumas semanas; sistemas e plataformas mais complexos podem levar alguns meses. O cronograma é definido logo após o briefing.',
            ),
            array(
                'question' => 'UX/UI tem impacto em SEO?',
                'answer'   => 'Sim. Interfaces rápidas, acessíveis, responsivas e bem estruturadas melhoram os sinais de experiência que o Google considera, como Core Web Vitals, além de aumentar o tempo de permanência e reduzir a taxa de rejeição.',
            ),
        ),
    ));

    update_option('agencia_seed_uxui_done', $seed_version);
}

/**
 * Seed da Solução "Suporte e manutenção" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_suporte');
function agencia_seed_solucao_suporte()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 2;
    if (!is_admin() || (int) get_option('agencia_seed_suporte_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('suporte-e-manutencao', 'Suporte e manutenção', 'Suporte e manutenção de sites e e-commerces para estabilidade e performance.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Suporte e manutenção',
        'agencia_sol_hero_title'           => 'de sites e e-commerces para estabilidade e performance',
        'agencia_sol_hero_text'            => 'Na Agência R8, oferecemos suporte técnico recorrente para WordPress, Tray e Nuvemshop. Somos parceiros Gold das principais plataformas e garantimos que seu site esteja sempre atualizado, seguro e otimizado.',
        'agencia_sol_hero_form_title'      => 'Precisa de suporte técnico confiável?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Serviços inclusos no pacote de suporte e manutenção',
        'agencia_sol_entregas_text'  => 'Da pesquisa ao protótipo final, desenhamos experiências e interfaces intuitivas que transformam visitantes em leads qualificados.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Horas técnicas mensais', 'description' => 'Até 3 horas para demandas técnicas (não acumuláveis).'),
            array('title' => 'Suporte a erros e bugs', 'description' => 'Correções que impactem usabilidade ou funcionamento.'),
            array('title' => 'Manutenção de segurança', 'description' => 'Atualização de plugins, temas e versão do WordPress.'),
            array('title' => 'Apoio ao servidor e infraestrutura', 'description' => 'Análise de desempenho, ajustes em PHP/MySQL.'),
            array('title' => 'Backups regulares', 'description' => 'Verificação e configuração de backups semanais automáticos.'),
            array('title' => 'Otimização de desempenho', 'description' => 'Cache, banco de dados e imagens otimizados.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso modelo de suporte e manutenção',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico inicial', 'description' => 'Análise do site e configuração do plano de manutenção.'),
            array('title' => 'Atendimento recorrente', 'description' => 'Até 3 horas técnicas mensais para ajustes e suporte.'),
            array('title' => 'Prevenção e monitoramento', 'description' => 'Atualizações de segurança, backups e otimização contínua.'),
            array('title' => 'Chamados adicionais', 'description' => 'Demandas extras tratadas como projetos ou horas avulsas.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Perguntas Frequentes sobre\nSuporte e manutenção de sites e e-commerces",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que está incluso no suporte mensal?',
                'answer'   => 'O pacote inclui até 3 horas técnicas por mês (não acumuláveis), correção de erros e bugs, atualizações de segurança de plugins, temas e WordPress, apoio ao servidor e infraestrutura, backups semanais automáticos e otimização de desempenho.',
            ),
            array(
                'question' => 'Posso contratar suporte apenas quando precisar?',
                'answer'   => 'Sim. Demandas pontuais podem ser atendidas como horas avulsas ou projetos. O plano mensal é indicado para quem quer prevenção contínua, com o site sempre atualizado, seguro e monitorado.',
            ),
            array(
                'question' => 'O suporte inclui melhorias de layout ou novas funcionalidades?',
                'answer'   => 'As horas mensais podem ser usadas em pequenos ajustes. Mudanças maiores de layout ou novas funcionalidades são avaliadas e orçadas à parte, como projeto ou horas avulsas.',
            ),
            array(
                'question' => 'Quanto custa hora extra além do pacote?',
                'answer'   => 'O valor da hora avulsa depende da demanda e do plano contratado. Entre em contato pelo formulário e enviamos uma proposta de acordo com a necessidade do seu site.',
            ),
            array(
                'question' => 'O suporte é só para empresas de Uberlândia?',
                'answer'   => 'Não. O suporte é feito de forma remota, então atendemos empresas de qualquer cidade.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Seu site* sempre seguro,\nrápido e atualizado",
        'agencia_sol_cta_text'        => "Com o suporte recorrente da R8, sua empresa tem estabilidade, segurança e evolução contínua.\nCuidamos da parte técnica para que você foque no crescimento do negócio.",
        'agencia_sol_cta_button_text' => 'Quero suporte técnico especializado',
    ));

    update_option('agencia_seed_suporte_done', $seed_version);
}

/**
 * Seed da Solução "Landing page e hotsites" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_landing');
function agencia_seed_solucao_landing()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_landing_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('landing-page-e-hotsites', 'Landing page e hotsites', 'Landing pages e hotsites prontos para gerar conversão.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Landing Pages e Hotsites',
        'agencia_sol_hero_title'           => 'prontos para gerar conversão',
        'agencia_sol_hero_text'            => 'Na Agência R8, desenvolvemos landing pages de alta performance e hotsites estratégicos para campanhas específicas. Criamos em WordPress ou diretamente no RD Station Marketing, integrados ao seu funil de vendas.',
        'agencia_sol_hero_form_title'      => 'Precisa de uma página que converte?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => "Nossas soluções para páginas\nde alta performance",
        'agencia_sol_entregas_text'  => 'Da estratégia de copy ao design responsivo, criamos páginas otimizadas para transformar tráfego qualificado em leads e vendas.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Landing pages no WordPress', 'description' => 'Páginas rápidas, responsivas e customizadas.'),
            array('title' => 'Landing pages no RD Station', 'description' => 'Integradas a automações, CRM e captação de leads.'),
            array('title' => 'Hotsites para campanhas', 'description' => 'Páginas exclusivas para lançamentos, eventos e promoções.'),
            array('title' => 'Design focado em conversão', 'description' => 'Copywriting, UX/UI e CTAs estratégicos.'),
            array('title' => 'Integração com ferramentas de marketing', 'description' => 'Formulários, automação, CRM, analytics.'),
            array('title' => 'Otimização para SEO e velocidade', 'description' => 'Páginas leves, indexáveis e performáticas.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Briefing e definição de objetivo', 'description' => 'Entendemos a campanha, público e oferta.'),
            array('title' => 'Wireframe e design UX/UI', 'description' => 'Criamos páginas com foco em conversão.'),
            array('title' => 'Implementação técnica', 'description' => 'No WordPress ou RD Station Marketing, com integrações.'),
            array('title' => 'Testes e publicação', 'description' => 'Validamos responsividade, velocidade e performance.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas mais comuns sobre landing pages',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Qual a diferença entre landing page e hotsite?',
                'answer'   => 'A landing page é uma página única com um objetivo específico, como captar leads ou vender uma oferta. O hotsite é um site temporário com algumas páginas, criado para uma campanha, lançamento ou evento, com mais espaço para conteúdo e experiência de marca.',
            ),
            array(
                'question' => 'Vocês fazem landing pages só em WordPress?',
                'answer'   => 'Não. Criamos em WordPress ou diretamente no RD Station Marketing, de acordo com a sua operação. Em ambos os casos, a página fica integrada ao seu funil de vendas.',
            ),
            array(
                'question' => 'Landing page ajuda em vendas B2B?',
                'answer'   => 'Sim. No B2B, a landing page é a porta de entrada do funil: capta o contato de quem demonstrou interesse, alimenta a automação de marketing e entrega ao time comercial leads mais qualificados.',
            ),
            array(
                'question' => 'O que preciso fornecer para criar uma landing page?',
                'answer'   => 'O objetivo da página, informações sobre a oferta e o público, além da identidade visual da marca (logo, cores e imagens). Se não houver textos prontos, a copy pode ser desenvolvida junto com o projeto.',
            ),
            array(
                'question' => 'Em quanto tempo uma landing page fica pronta?',
                'answer'   => 'O prazo depende do escopo, da quantidade de seções e das integrações necessárias. Ele é definido logo após o briefing, para alinhar a entrega ao calendário da sua campanha.',
            ),
            array(
                'question' => 'As páginas são otimizadas para SEO?',
                'answer'   => 'Sim. As páginas são desenvolvidas leves, rápidas, responsivas e indexáveis, com estrutura de títulos e metadados adequados para os mecanismos de busca.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Landing pages e hotsites* que\natraem, convertem e vendem",
        'agencia_sol_cta_text'        => "Seja para campanhas rápidas ou captação contínua de leads, criamos páginas que unem design, tecnologia e performance.\nSua estratégia digital começa aqui.",
        'agencia_sol_cta_button_text' => 'Quero uma página de alta conversão',
    ));

    update_option('agencia_seed_landing_done', $seed_version);
}

/**
 * Seed da Solução "Sites Institucionais" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_sites_institucionais');
function agencia_seed_solucao_sites_institucionais()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_sites_institucionais_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('sites-institucionais', 'Sites Institucionais', 'Criação de sites institucionais em WordPress para gerar autoridade e resultados.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Criação de sites institucionais',
        'agencia_sol_hero_title'           => 'em WordPress para gerar autoridade e resultados',
        'agencia_sol_hero_text'            => 'Na Agência R8, desenvolvemos sites modernos, responsivos e otimizados para SEO. Sua presença digital com a confiabilidade do WordPress e a performance que o seu negócio precisa.',
        'agencia_sol_hero_form_title'      => 'Quer um site institucional profissional?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Nossos diferenciais na criação de sites institucionais',
        'agencia_sol_entregas_text'  => 'Da arquitetura de conteúdo ao SEO avançado, desenvolvemos sites institucionais sob medida para consolidar sua marca e atrair novos clientes.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Sites institucionais completos', 'description' => 'Páginas institucionais, serviços, contatos e formulários.'),
            array('title' => 'WordPress personalizado', 'description' => 'Temas profissionais, com identidade visual da sua marca.'),
            array('title' => 'Responsividade garantida', 'description' => 'Perfeito em desktop, tablet e mobile.'),
            array('title' => 'Otimização SEO on-page', 'description' => 'Estrutura pensada para ranquear no Google.'),
            array('title' => 'Integrações inteligentes', 'description' => 'CRM, chat, WhatsApp, automações de marketing.'),
            array('title' => 'Hospedagem e manutenção', 'description' => 'Suporte contínuo para segurança e estabilidade.'),
        ),

        // Galeria
        'agencia_sol_galeria_badge'    => 'Galeria',
        'agencia_sol_galeria_title'    => "Sites que fortalecem marcas\ne geram credibilidade",
        'agencia_sol_galeria_cta_text' => 'Confira nossos cases',

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Briefing e imersão', 'description' => 'Entendemos o negócio, público-alvo e objetivos do site.'),
            array('title' => 'Arquitetura e layout UX/UI', 'description' => 'Definimos estrutura de páginas e design visual.'),
            array('title' => 'Desenvolvimento em WordPress', 'description' => 'Implementação técnica com integrações.'),
            array('title' => 'Entrega com treinamento', 'description' => 'Site publicado + orientações para gestão simples.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas mais comuns\nsobre sites institucionais",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Por que escolher WordPress para meu site institucional?',
                'answer'   => 'O WordPress é a plataforma mais usada no mundo para sites: é estável, seguro quando bem mantido, amigável para SEO e permite que a sua equipe atualize textos, imagens e páginas pelo painel, sem depender de programação.',
            ),
            array(
                'question' => 'O site será responsivo e otimizado para SEO?',
                'answer'   => 'Sim. Todos os sites são desenvolvidos para funcionar bem em desktop, tablet e celular, com estrutura de títulos, metadados, velocidade de carregamento e boas práticas de SEO on-page desde o início.',
            ),
            array(
                'question' => 'Vocês oferecem hospedagem e suporte após a entrega?',
                'answer'   => 'Sim. Oferecemos hospedagem de sites e planos de suporte e manutenção, com atualizações de segurança, backups e ajustes técnicos para manter o site estável depois da publicação.',
            ),
            array(
                'question' => 'Qual o prazo médio para entrega de um site institucional?',
                'answer'   => 'O prazo depende da quantidade de páginas, das integrações e da disponibilidade de conteúdo. O cronograma é definido logo após o briefing, com as etapas de layout, desenvolvimento e entrega bem claras.',
            ),
            array(
                'question' => 'Vocês atendem empresas fora de Uberlândia?',
                'answer'   => 'Sim. Todo o processo pode ser conduzido de forma remota, com reuniões online, então atendemos empresas de qualquer cidade.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Seu site pronto* para gerar\ncredibilidade e resultados",
        'agencia_sol_cta_text'        => "Mais do que presença digital, um site institucional é a porta de entrada do seu negócio.\nCom a R8, você garante design, tecnologia e SEO em um único projeto.",
        'agencia_sol_cta_button_text' => 'Quero uma página de alta conversão',
    ));

    agencia_seed_solucao_galeria($post_id, 'sites-institucionais');

    update_option('agencia_seed_sites_institucionais_done', $seed_version);
}

/**
 * Seed da Solução "E-commerce" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_ecommerce');
function agencia_seed_solucao_ecommerce()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_ecommerce_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('e-commerce', 'E-commerce', 'E-commerces prontos para vender em Tray e Nuvemshop.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'E-commerces',
        'agencia_sol_hero_title'           => 'prontos para vender em Tray e Nuvemshop',
        'agencia_sol_hero_text'            => 'Na Agência R8, criamos e-commerces de alta performance em Tray e Nuvemshop. Seja com tema pronto ou personalizado, configuramos sua loja com módulos de pagamento, envio e integrações para começar a vender rápido.',
        'agencia_sol_hero_form_title'      => 'Quer sua loja virtual pronta para vender?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas (título e texto iguais aos de Sites Institucionais no layout; revisar no painel)
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Nossos diferenciais na criação de sites institucionais',
        'agencia_sol_entregas_text'  => 'Da arquitetura de conteúdo ao SEO avançado, desenvolvemos sites institucionais sob medida para consolidar sua marca e atrair novos clientes.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Implementação em Tray e Nuvemshop', 'description' => 'Aceleramos suas vendas com a excelência de quem é parceiro Gold.'),
            array('title' => 'Criação com tema pronto ou exclusivo', 'description' => 'Escolha entre agilidade com temas prontos ou exclusividade sob medida.'),
            array('title' => 'ERPs & Marketplaces Conectados', 'description' => 'Automatize a gestão da sua loja virtual com integrações personalizadas.'),
            array('title' => 'Cadastro Inicial de Produtos', 'description' => 'Deixe a organização do seu catálogo pronto para vender por nossa conta.'),
            array('title' => 'Otimização para SEO e Velocidade', 'description' => 'Estruturação completa para destacar sua marca e acelerar o carregamento.'),
            array('title' => 'Lançamento Rápido', 'description' => 'Sua loja virtual pronta para vender no menor tempo do mercado.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Briefing e escolha da plataforma', 'description' => 'Definição entre Tray ou Nuvemshop conforme necessidade.'),
            array('title' => 'Definição do tema', 'description' => 'Escolha de tema pronto ou desenvolvimento de tema personalizado.'),
            array('title' => 'Configuração e integrações', 'description' => 'Módulos de pagamento, frete, checkout, ERP, marketplaces.'),
            array('title' => 'Publicação da loja', 'description' => 'Testes de compra e entrega de loja pronta para vender.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas mais comuns\nsobre criação de e-commerces",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Vocês só trabalham com Tray e Nuvemshop?',
                'answer'   => 'Tray e Nuvemshop são as plataformas em que somos especialistas e parceiros, e por isso concentramos nossos projetos de e-commerce nelas. No briefing, avaliamos a necessidade da sua loja para indicar a melhor opção.',
            ),
            array(
                'question' => 'Qual a diferença entre tema pronto e tema personalizado?',
                'answer'   => 'O tema pronto é ajustado com a identidade visual da sua marca e permite colocar a loja no ar mais rápido. O tema personalizado é desenvolvido sob medida, com layout exclusivo e mais liberdade para criar uma experiência de compra única.',
            ),
            array(
                'question' => 'Vocês fazem integrações com ERP e marketplaces?',
                'answer'   => 'Sim. Configuramos integrações com ERPs e marketplaces para automatizar estoque, pedidos e notas, além dos módulos de pagamento, frete e checkout.',
            ),
            array(
                'question' => 'Quanto tempo leva para colocar minha loja no ar?',
                'answer'   => 'Depende da escolha entre tema pronto ou personalizado, da quantidade de produtos e das integrações necessárias. O cronograma é definido logo após o briefing.',
            ),
            array(
                'question' => 'Vocês oferecem suporte após a entrega?',
                'answer'   => 'Sim. Oferecemos suporte e manutenção recorrentes para Tray e Nuvemshop, para manter sua loja atualizada, segura e funcionando bem depois do lançamento.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Sua loja virtual* pronta\npara vender com a R8",
        'agencia_sol_cta_text'        => "Com nossa expertise em Tray e Nuvemshop, entregamos e-commerces configurados e prontos para escalar.\nSeja com tema pronto ou personalizado, sua loja começa a vender mais rápido e com segurança.",
        'agencia_sol_cta_button_text' => 'Quero meu e-commerce pronto para vender',
    ));

    update_option('agencia_seed_ecommerce_done', $seed_version);
}

/**
 * Seed da Solução "Hospedagem de sites" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_hospedagem');
function agencia_seed_solucao_hospedagem()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_hospedagem_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('hospedagem-de-sites', 'Hospedagem de sites', 'Hospedagem WordPress segura, rápida e com suporte próximo.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero (título do formulário igual ao de E-commerce no layout; revisar no painel)
        'agencia_sol_hero_title_highlight' => 'Hospedagem WordPress',
        'agencia_sol_hero_title'           => 'segura, rápida e com suporte próximo',
        'agencia_sol_hero_text'            => 'Na Agência R8, você não contrata só um servidor: tem ao lado um time de especialistas em WordPress, pronto para manter seu site estável, seguro e performando.',
        'agencia_sol_hero_form_title'      => 'Quer sua loja virtual pronta para vender?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Diferenciais da nossa hospedagem',
        'agencia_sol_entregas_text'  => 'Do certificado SSL aos backups diários, oferecemos um ambiente de hospedagem robusto para que você foque apenas no crescimento do seu negócio.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Performance para WordPress', 'description' => 'Servidores otimizados para velocidade e SEO.'),
            array('title' => 'Segurança reforçada', 'description' => 'Imunify360, firewall e varredura contra malwares.'),
            array('title' => 'SSL grátis', 'description' => 'Cadeado ativado em todos os sites hospedados.'),
            array('title' => 'Backups semanais', 'description' => 'Automáticos, com suporte na restauração.'),
            array('title' => 'cPanel completo', 'description' => 'Gestão fácil de arquivos, e-mails e banco de dados.'),
            array('title' => 'Suporte especializado', 'description' => 'Atendimento humano via WhatsApp e time de dev interno.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico Inicial', 'description' => 'Avaliamos o consumo do seu site e todas as necessidades técnicas da sua operação.'),
            array('title' => 'Configuração & Segurança', 'description' => 'Preparamos a infraestrutura com instalação completa, certificado SSL, backups e políticas de segurança.'),
            array('title' => 'Migração & Go-Live', 'description' => 'Realizamos a migração e fazemos o apontamento correto do DNS para colocar sua loja no ar.'),
            array('title' => 'Suporte & Monitoramento Contínuo', 'description' => 'Acompanhamos a performance da sua hospedagem com monitoramento constante.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas comuns sobre\nnossa hospedagem",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'É só para WordPress?',
                'answer'   => 'Nossa infraestrutura é otimizada para WordPress, que é onde temos mais especialização. Se o seu site usa outra tecnologia, fale com a gente para avaliarmos a compatibilidade.',
            ),
            array(
                'question' => 'SSL é realmente gratuito?',
                'answer'   => 'Sim. O certificado SSL é ativado sem custo adicional em todos os sites hospedados, garantindo o cadeado de segurança no navegador.',
            ),
            array(
                'question' => 'Vocês fazem backup automático?',
                'answer'   => 'Sim. Os backups são automáticos e, se for preciso, nossa equipe ajuda na restauração do site.',
            ),
            array(
                'question' => 'Posso aumentar os GB depois?',
                'answer'   => 'Sim. Se o seu site crescer e precisar de mais espaço, o plano pode ser ajustado. Fale com o nosso time para avaliar a melhor opção.',
            ),
            array(
                'question' => 'Vocês ajudam na migração de outro provedor?',
                'answer'   => 'Sim. Fazemos a migração do seu site e o apontamento correto do DNS para colocar tudo no ar na nova hospedagem.',
            ),
            array(
                'question' => 'Qual a diferença de contratar com vocês em vez de um provedor comum?',
                'answer'   => 'Além do servidor, você tem um time de especialistas em WordPress ao seu lado: atendimento humano via WhatsApp, time de desenvolvimento interno, monitoramento e ajuda com segurança, backups e performance.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Hospedagem premium* para sites\nque não podem parar",
        'agencia_sol_cta_text'        => 'Segurança, estabilidade e suporte próximo: a R8 cuida da infraestrutura e você foca no crescimento.',
        'agencia_sol_cta_button_text' => 'Quero hospedar meu site na R8',
    ));

    update_option('agencia_seed_hospedagem_done', $seed_version);
}

/**
 * Seed da Solução "E-mail Profissional" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_email');
function agencia_seed_solucao_email()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_email_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('e-mail-profissional', 'E-mail Profissional', 'E-mail profissional com domínio da sua empresa.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'E-mail profissional',
        'agencia_sol_hero_title'           => 'com domínio da sua empresa',
        'agencia_sol_hero_text'            => 'Comunique-se com credibilidade e segurança. Na R8, você cria endereços como nome@suaempresa.com.br, com planos flexíveis e suporte próximo.',
        'agencia_sol_hero_form_title'      => 'Quer criar seu e-mail profissional agora?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Vantagens do e-mail corporativo',
        'agencia_sol_entregas_text'  => 'Da configuração do domínio à migração sem interrupções, garantimos a segurança e o suporte técnico que sua comunicação corporativa precisa.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Autoridade & Credibilidade', 'description' => 'Transmita o profissionalismo que a sua marca merece em cada mensagem.'),
            array('title' => 'Proteção e Segurança', 'description' => 'Defesa avançada contra fraudes, phishing e acessos não autorizados.'),
            array('title' => 'Fortalecimento da Marca', 'description' => 'Reforce seu domínio e sua identidade visual em todas as comunicações.'),
            array('title' => 'Organização Sob Medida', 'description' => 'Filtros inteligentes, pastas personalizadas e assinaturas exclusivas.'),
            array('title' => 'Acesso onde estiver', 'description' => 'Conectividade total via web, celular ou seus aplicativos favoritos.'),
            array('title' => 'Alta Capacidade & Desempenho', 'description' => 'Armazenamento amplo e ferramentas de busca rápida para manter sua rotina ágil.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Definição de Domínio', 'description' => 'Seleção ou validação do domínio oficial da sua marca.'),
            array('title' => 'Dimensionamento de Plano', 'description' => 'Escolha da capacidade de armazenamento e número de contas para a sua equipe.'),
            array('title' => 'Setup Técnico', 'description' => 'Configuração dos servidores, filtros antispam e políticas de proteção.'),
            array('title' => 'Conectividade Total', 'description' => 'Entrega dos acessos para uso imediato via web, celular ou seus apps favoritos.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Tire suas dúvidas',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Qual o mínimo de caixas que posso contratar?',
                'answer'   => 'O plano é dimensionado de acordo com o tamanho da sua equipe. Fale com o nosso time para montarmos a quantidade de contas e o armazenamento ideais para a sua empresa.',
            ),
            array(
                'question' => 'Posso migrar meus e-mails atuais?',
                'answer'   => 'Sim. Ajudamos na migração das mensagens do provedor atual para o novo e-mail profissional, com o mínimo de interrupção na sua comunicação.',
            ),
            array(
                'question' => 'E se eu precisar de mais espaço depois?',
                'answer'   => 'Os planos são flexíveis: é possível aumentar o armazenamento ou o número de contas conforme a sua empresa cresce.',
            ),
            array(
                'question' => 'É possível criar e-mails diferentes para setores?',
                'answer'   => 'Sim. Você pode criar endereços por setor, como comercial@, financeiro@ e contato@, além das contas individuais da equipe.',
            ),
            array(
                'question' => 'Funciona em celular e aplicativos?',
                'answer'   => 'Sim. O e-mail pode ser acessado pelo navegador, pelo celular ou pelos aplicativos de e-mail que você já usa.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Profissionalize* sua\ncomunicação agora mesmo",
        'agencia_sol_cta_text'        => 'Mostre mais credibilidade para clientes e parceiros. Contrate seu e-mail profissional com a R8 e ganhe suporte próximo e especializado.',
        'agencia_sol_cta_button_text' => 'Quero meu e-mail profissional',
    ));

    update_option('agencia_seed_email_done', $seed_version);
}

/**
 * Seed da Solução "Certificado Digital" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_certificado');
function agencia_seed_solucao_certificado()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_certificado_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('certificado-digital', 'Certificado Digital', 'Certificado Digital A1 com agilidade e suporte próximo.', 'Tecnologia');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Certificado Digital',
        'agencia_sol_hero_title'           => 'A1 com agilidade e suporte próximo',
        'agencia_sol_hero_text'            => 'Na Agência R8, emitimos seu Certificado Digital A1 para CPF (R$150) e CNPJ (R$200) com rapidez, segurança e atendimento humano.',
        'agencia_sol_hero_form_title'      => 'Precisa do seu certificado digital agora?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Por que emitir seu Certificado Digital conosco?',
        'agencia_sol_entregas_text'  => 'Da videoconferência ao suporte técnico: emissão ágil, sem burocracia e com acompanhamento humano do início ao fim.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Transparência de Valores', 'description' => 'Preços justos, competitivos e sem custos escondidos.'),
            array('title' => 'Atendimento Multicanal', 'description' => 'Suporte direto e humanizado via WhatsApp, telefone ou e-mail.'),
            array('title' => 'Emissão 100% Digital', 'description' => 'Validação rápida por videoconferência sem filas ou burocracia.'),
            array('title' => 'Parceria Oficial Qualitycert', 'description' => 'A garantia e o respaldo de uma autoridade certificadora líder.'),
            array('title' => 'Acompanhamento Completo', 'description' => 'Nossa equipe ao seu lado, da documentação à instalação final.'),
            array('title' => 'Validade Jurídica', 'description' => 'Assine contratos, emita notas e acesse portais do governo com segurança.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => "Seu certificado pronto\nem poucos passos",
        'agencia_sol_processo_group' => array(
            array('title' => 'Envio de Documentos', 'description' => 'Escolha a opção (e-CPF ou e-CNPJ) e envie a documentação necessária online.'),
            array('title' => 'Agendamento', 'description' => 'Escolha o melhor dia e horário para a sua sessão de atendimento.'),
            array('title' => 'Videoconferência', 'description' => 'Valide seus dados em uma chamada de vídeo rápida pelo computador ou celular.'),
            array('title' => 'Emissão & Utilização', 'description' => 'Baixe seu certificado digital (válido por 1 ano) e comece a assinar e acessar portais.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas mais comuns',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que é um Certificado Digital A1?',
                'answer'   => 'É uma identidade eletrônica instalada no computador, que permite assinar documentos com validade jurídica, emitir notas fiscais e acessar portais do governo com segurança. Pode ser emitido para pessoa física (e-CPF) ou para empresa (e-CNPJ).',
            ),
            array(
                'question' => 'Qual a validade do certificado?',
                'answer'   => 'O Certificado Digital A1 é válido por 1 ano a partir da emissão. Antes do vencimento, você pode fazer a renovação com a gente.',
            ),
            array(
                'question' => 'Preciso ir até a R8 para emitir?',
                'answer'   => 'Não. A emissão é 100% digital: você envia os documentos online e valida seus dados em uma videoconferência rápida, pelo computador ou celular.',
            ),
            array(
                'question' => 'Quais documentos preciso apresentar?',
                'answer'   => 'A documentação depende do tipo de certificado (e-CPF ou e-CNPJ). Ao escolher a opção, nossa equipe informa a lista completa e acompanha o envio para evitar retrabalho.',
            ),
            array(
                'question' => 'Posso renovar com vocês se já tiver certificado anterior?',
                'answer'   => 'Sim. Você pode renovar seu Certificado Digital com a R8, mesmo que o anterior tenha sido emitido por outra empresa.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Seu Certificado Digital* emitido\ncom segurança e rapidez",
        'agencia_sol_cta_text'        => 'Evite burocracia. Com a R8, você emite ou renova seu Certificado Digital em minutos, com suporte próximo e preços acessíveis.',
        'agencia_sol_cta_button_text' => 'Emitir meu Certificado agora',
    ));

    update_option('agencia_seed_certificado_done', $seed_version);
}

/**
 * Seed da Solução "Automação de marketing" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_automacao');
function agencia_seed_solucao_automacao()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_automacao_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('automacao-de-marketing', 'Automação de marketing', 'Automação de Marketing para relacionar, nutrir e vender mais.', 'Marketing');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Automação de Marketing',
        'agencia_sol_hero_title'           => 'para relacionar, nutrir e vender mais',
        'agencia_sol_hero_text'            => 'Na Agência R8, criamos fluxos inteligentes dentro do RD Station Marketing, que conectam e-mail, WhatsApp e SMS para transformar contatos em clientes e clientes em promotores da sua marca.',
        'agencia_sol_hero_form_title'      => 'Quer automações para otimizar suas vendas?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas (título e texto iguais aos de Certificado Digital no layout; revisar no painel)
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Por que emitir seu Certificado Digital conosco?',
        'agencia_sol_entregas_text'  => 'Da videoconferência ao suporte técnico: emissão ágil, sem burocracia e com acompanhamento humano do início ao fim.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Fluxos de relacionamento', 'description' => 'Boas-vindas, onboarding e engajamento inicial.'),
            array('title' => 'Nutrição de leads', 'description' => 'Conteúdos segmentados para avançar no funil.'),
            array('title' => 'Follow-up automatizado', 'description' => 'Lembretes e interações comerciais integradas.'),
            array('title' => 'Pós-venda automatizado', 'description' => 'Pesquisas de satisfação, recompra e fidelização.'),
            array('title' => 'E-mail marketing inteligente', 'description' => 'Segmentado e baseado em comportamento.'),
            array('title' => 'WhatsApp Marketing', 'description' => 'Mensagens automáticas para campanhas e follow-ups.'),
            array('title' => 'SMS Marketing', 'description' => 'Notificações rápidas e de alto alcance.'),
            array('title' => 'Integrações com CRM e mídia paga', 'description' => 'Leads fluindo direto para vendas.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Planejamento do funil', 'description' => 'Mapeamos jornadas e pontos de contato do cliente.'),
            array('title' => 'Construção no RD Station', 'description' => 'Criamos fluxos automatizados de acordo com a estratégia.'),
            array('title' => 'Integração de canais', 'description' => 'E-mail, WhatsApp, SMS e CRM conectados.'),
            array('title' => 'Otimização contínua', 'description' => 'Relatórios de abertura, clique, conversão e ROI.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas comuns sobre automação',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Automação substitui a equipe de marketing?',
                'answer'   => 'Não. A automação assume as tarefas repetitivas, como envios, lembretes e follow-ups, para que a equipe tenha mais tempo para estratégia, conteúdo e relacionamento.',
            ),
            array(
                'question' => 'Preciso ter RD Station para usar automação?',
                'answer'   => 'Nossos fluxos são construídos dentro do RD Station Marketing. Se a sua empresa ainda não usa a ferramenta, ajudamos a avaliar o plano mais adequado e a fazer a implantação.',
            ),
            array(
                'question' => 'Vocês fazem apenas e-mail marketing?',
                'answer'   => 'Não. Integramos e-mail, WhatsApp, SMS e CRM em jornadas automatizadas, para falar com o cliente no canal certo e no momento certo.',
            ),
            array(
                'question' => 'Automação funciona só para B2B?',
                'answer'   => 'Não. A automação funciona tanto para B2B quanto para B2C: muda a jornada, mas o objetivo é o mesmo, relacionar, nutrir e converter contatos em clientes.',
            ),
            array(
                'question' => 'Posso começar com automações simples e evoluir depois?',
                'answer'   => 'Sim. É comum começar com fluxos essenciais, como boas-vindas e nutrição, e evoluir para jornadas mais completas conforme os resultados aparecem.',
            ),
            array(
                'question' => 'Quais métricas acompanham?',
                'answer'   => 'Acompanhamos taxas de abertura, clique, conversão e o ROI das automações, com relatórios que orientam a otimização contínua dos fluxos.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Fluxos inteligentes* que\ntrabalham para sua empresa 24/7",
        'agencia_sol_cta_text'        => 'Com automações no RD Station, seu marketing não para. Criamos jornadas que encantam clientes, reduzem esforço manual e aumentam conversões.',
        'agencia_sol_cta_button_text' => 'Quero automatizar meu marketing',
    ));

    update_option('agencia_seed_automacao_done', $seed_version);
}

/**
 * Seed da Solução "Audiovisual" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_audiovisual');
function agencia_seed_solucao_audiovisual()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_audiovisual_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('audiovisual', 'Audiovisual', 'Audiovisual estratégico para campanhas digitais e redes sociais.', 'Marketing');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Audiovisual estratégico',
        'agencia_sol_hero_title'           => 'para campanhas digitais e redes sociais',
        'agencia_sol_hero_text'            => 'Na Agência R8, produzimos vídeos e fotos no formato filmmaker, feitos em Uberlândia e região. Não somos uma produtora de filmes: somos uma agência 360, que cria conteúdo audiovisual integrado às suas campanhas de marketing e vendas.',
        'agencia_sol_hero_form_title'      => "Precisa de vídeos profissionais\npara suas campanhas?",
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => "Soluções audiovisuais\npara o digital",
        'agencia_sol_entregas_text'  => 'Da ideia criativa às telas do seu cliente, aliamos a agilidade do formato filmmaker à estratégia de campanhas 360 para gerar engajamento e conversão.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Captação de vídeos profissionais', 'description' => 'Câmeras de alta qualidade, iluminação e captação de áudio.'),
            array('title' => 'Sessões fotográficas corporativas', 'description' => 'Fotos para redes sociais, sites e campanhas.'),
            array('title' => 'Vídeos para redes sociais', 'description' => 'Reels, stories, TikTok, YouTube, shorts e anúncios.'),
            array('title' => 'Edição e finalização', 'description' => 'Cortes dinâmicos, legendas, trilha sonora, cor e áudio.'),
            array('title' => 'Peças para campanhas digitais', 'description' => 'Institucionais, depoimentos, making of, bastidores.'),
            array('title' => 'Entrega ágil e estratégica', 'description' => 'Materiais prontos para redes sociais, anúncios e apresentações.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 3 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Briefing e planejamento', 'description' => 'Entendemos objetivos de campanha e roteirizamos conteúdo.'),
            array('title' => 'Captação de conteúdo', 'description' => 'Gravações em campo, sessões de foto e filmagens no formato filmmaker.'),
            array('title' => 'Edição e entrega final', 'description' => 'Cortes prontos para redes sociais e campanhas digitais, já otimizados.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas comuns sobre\nAudiovisual para marketing",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Vocês são uma produtora de vídeo?',
                'answer'   => 'Não. Somos uma agência 360 que produz vídeos e fotos no formato filmmaker, sempre integrados às suas campanhas de marketing e vendas.',
            ),
            array(
                'question' => 'Atendem apenas em Uberlândia?',
                'answer'   => 'As captações são feitas em Uberlândia e região. Para gravações em outras cidades, fale com a gente para avaliarmos a demanda.',
            ),
            array(
                'question' => 'Que tipo de vídeos vocês produzem?',
                'answer'   => 'Vídeos para redes sociais (Reels, stories, TikTok, YouTube e shorts), anúncios, institucionais, depoimentos, making of e bastidores.',
            ),
            array(
                'question' => 'Vocês fazem captação de áudio e fotografia também?',
                'answer'   => 'Sim. Trabalhamos com captação de áudio, iluminação e sessões fotográficas corporativas para redes sociais, sites e campanhas.',
            ),
            array(
                'question' => 'Qual a diferença entre contratar a R8 e uma produtora tradicional?',
                'answer'   => 'Na R8, o audiovisual nasce da estratégia: o conteúdo é planejado junto com as suas campanhas de marketing e vendas e entregue pronto para redes sociais e anúncios, com a agilidade do formato filmmaker.',
            ),
            array(
                'question' => 'Em quanto tempo recebo os vídeos editados?',
                'answer'   => 'O prazo depende da quantidade de peças e da complexidade da edição. Ele é combinado no briefing, de acordo com o calendário da sua campanha.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Conteúdo audiovisual*\nque engaja e converte",
        'agencia_sol_cta_text'        => "Na R8, o audiovisual é pensado como parte da sua estratégia digital.\nProduzimos vídeos e fotos que fortalecem sua marca, engajam o público e geram resultados reais.",
        'agencia_sol_cta_button_text' => 'Quero vídeos estratégicos para meu marketing',
    ));

    update_option('agencia_seed_audiovisual_done', $seed_version);
}

/**
 * Seed da Solução "Inbound Marketing" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_inbound');
function agencia_seed_solucao_inbound()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_inbound_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('inbound-marketing', 'Inbound Marketing', 'Inbound Marketing para atrair, engajar e converter clientes.', 'Marketing');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Inbound Marketing',
        'agencia_sol_hero_title'           => 'para atrair, engajar e converter clientes',
        'agencia_sol_hero_text'            => 'Na Agência R8, estruturamos estratégias completas de marketing de atração: conteúdo, mídia paga, automação e relatórios inteligentes. Somos parceiros Gold RD Station e entregamos resultados mensuráveis para empresas de todos os portes.',
        'agencia_sol_hero_form_title'      => 'Quer atrair mais leads qualificados?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Soluções completas para seu funil de marketing',
        'agencia_sol_entregas_text'  => 'Da atração de leads à análise de métricas, estruturamos fluxos inteligentes e mídia paga com a expertise de uma agência Gold RD Station.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Gestão de redes sociais', 'description' => 'Conteúdos criativos, calendário editorial e análise de engajamento.'),
            array('title' => 'Produção de conteúdo para blogs', 'description' => 'SEO + autoridade de marca.'),
            array('title' => 'Campanhas de mídia paga', 'description' => 'Google Ads, Meta Ads, TikTok Ads e LinkedIn Ads.'),
            array('title' => 'Materiais ricos e landing pages', 'description' => 'Geração de leads e oportunidades de venda.'),
            array('title' => 'Dashboard exclusivo da R8', 'description' => 'Acompanhamento em tempo real de indicadores.'),
            array('title' => 'Relatórios mensais de performance', 'description' => 'Insights estratégicos e próximos passos.'),
        ),

        // Processo ("Erodução" no layout corrigido para "Produção")
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico e planejamento', 'description' => 'Entendemos o negócio, ICP e metas.'),
            array('title' => 'Execução contínua', 'description' => 'Produção de conteúdo, gestão de redes e mídia paga integrada.'),
            array('title' => 'Automação e nutrição', 'description' => 'Fluxos no RD Station Marketing, e-mails e segmentação de leads.'),
            array('title' => 'Análise e otimização', 'description' => 'Relatórios mensais + dashboard R8 em tempo real.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas comuns sobre Inbound',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Qual a diferença entre Inbound e Marketing de Conteúdo?',
                'answer'   => 'O marketing de conteúdo é uma das peças do Inbound. O Inbound é a estratégia completa de atração: conteúdo, mídia paga, automação, nutrição de leads e análise de resultados, conectados ao time de vendas.',
            ),
            array(
                'question' => 'Em quanto tempo vejo resultados?',
                'answer'   => 'Mídia paga costuma gerar leads mais rápido, enquanto conteúdo e SEO constroem resultados de forma consistente ao longo dos meses. Acompanhamos tudo em relatórios mensais e no dashboard da R8.',
            ),
            array(
                'question' => 'Vocês trabalham só com redes sociais?',
                'answer'   => 'Não. Além da gestão de redes sociais, trabalhamos com conteúdo para blogs, mídia paga, materiais ricos, landing pages, automação e relatórios de performance.',
            ),
            array(
                'question' => 'Vocês usam quais ferramentas?',
                'answer'   => 'Somos parceiros Gold RD Station e usamos o RD Station Marketing para automação e nutrição, além das plataformas de mídia paga (Google, Meta, TikTok e LinkedIn Ads) e do dashboard exclusivo da R8.',
            ),
            array(
                'question' => 'Vocês atendem só empresas de Uberlândia?',
                'answer'   => 'Não. As estratégias de Inbound são conduzidas de forma remota, então atendemos empresas de qualquer cidade.',
            ),
            array(
                'question' => 'Posso contratar só redes sociais ou só mídia paga?',
                'answer'   => 'Sim. Os serviços podem ser contratados separadamente, mas os melhores resultados aparecem quando conteúdo, mídia paga e automação trabalham juntos no mesmo funil.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Transforme marketing* em\ncrescimento previsível com a R8",
        'agencia_sol_cta_text'        => "Na R8, o Inbound Marketing é integrado a vendas: conteúdo, mídia paga e automação em um só fluxo.\nNossa meta não é curtida — é lead qualificado e venda fechada.",
        'agencia_sol_cta_button_text' => 'Quero atrair e converter mais clientes',
    ));

    update_option('agencia_seed_inbound_done', $seed_version);
}

/**
 * Seed da Solução "Mídia e performance" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_midia');
function agencia_seed_solucao_midia()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_midia_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('midia-e-performance', 'Mídia e performance', 'Mídia paga com foco em performance real, não em métricas de vaidade.', 'Marketing');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Mídia paga',
        'agencia_sol_hero_title'           => 'com foco em performance real, não em métricas de vaidade',
        'agencia_sol_hero_text'            => 'Somos Google Partners e especialistas em campanhas digitais. Gerenciamos Google Ads, Meta Ads, LinkedIn Ads e TikTok Ads com dashboards exclusivos e atendimento direto do analista responsável.',
        'agencia_sol_hero_form_title'      => 'Quer campanhas que entregam resultado de verdade?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Gestão de mídia paga completa e transparente',
        'agencia_sol_entregas_text'  => 'Da escolha dos canais à análise diária do ROI, aliamos inteligência de dados e atendimento direto com o analista para acelerar seu retorno.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Gestão de Tráfego Pago Multicanal', 'description' => 'Estratégias de anúncios de alta performance no Google, Meta, LinkedIn e TikTok.'),
            array('title' => 'Parceiro Google Partner', 'description' => 'Reconhecimento oficial de expertise e resultados.'),
            array('title' => 'Dashboards exclusivos R8', 'description' => 'Análise em tempo real dos principais indicadores.'),
            array('title' => 'Relatórios periódicos com análise técnica', 'description' => 'Insights e recomendações estratégicas.'),
            array('title' => 'Analistas especializados', 'description' => 'Atendimento direto com o responsável da sua conta.'),
            array('title' => 'Checkpoints semanais', 'description' => 'Acompanhamento de performance em ciclos curtos.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico inicial', 'description' => 'Análise do negócio, funil e histórico de campanhas.'),
            array('title' => 'Planejamento e setup', 'description' => 'Definição de canais, orçamento e estrutura de campanhas.'),
            array('title' => 'Gestão contínua', 'description' => 'Otimização diária baseada em dados, não em métricas de vaidade.'),
            array('title' => 'Análise e relatórios', 'description' => 'Checkpoints semanais (sob consulta) + relatórios técnicos mensais.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas comuns sobre mídia paga',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'Vocês são certificados pelo Google?',
                'answer'   => 'Sim. A R8 é Google Partner, um reconhecimento oficial do Google para agências com expertise e resultados comprovados em campanhas.',
            ),
            array(
                'question' => 'Vocês gerenciam apenas Google Ads?',
                'answer'   => 'Não. Gerenciamos campanhas no Google Ads, Meta Ads, LinkedIn Ads e TikTok Ads, escolhendo os canais de acordo com o seu público e objetivo.',
            ),
            array(
                'question' => 'Vocês entregam relatórios detalhados?',
                'answer'   => 'Sim. Você acompanha os indicadores em tempo real no dashboard exclusivo da R8 e recebe relatórios técnicos mensais com análise e recomendações estratégicas.',
            ),
            array(
                'question' => 'Vocês também criam os criativos das campanhas?',
                'answer'   => 'Fale com a gente sobre a sua necessidade: a criação dos criativos pode ser incluída no escopo do projeto, integrada ao planejamento das campanhas.',
            ),
            array(
                'question' => 'Posso contratar só mídia paga, sem inbound?',
                'answer'   => 'Sim. A gestão de mídia paga pode ser contratada separadamente, e também pode ser integrada a uma estratégia de Inbound quando fizer sentido para o seu negócio.',
            ),
            array(
                'question' => 'Como é o contato com a equipe de mídia?',
                'answer'   => 'O atendimento é direto com o analista responsável pela sua conta, com checkpoints semanais (sob consulta) para acompanhar a performance em ciclos curtos.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Campanhas inteligentes* para\ngerar leads e vendas de verdade",
        'agencia_sol_cta_text'        => "Como Google Partner, a R8 garante estratégias de mídia paga que priorizam performance real.\nMais leads, mais clientes e mais vendas para o seu negócio.",
        'agencia_sol_cta_button_text' => 'Quero campanhas de alta performance',
    ));

    update_option('agencia_seed_midia_done', $seed_version);
}

/**
 * Seed da Solução "SEO" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_seo');
function agencia_seed_solucao_seo()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_seo_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('seo', 'SEO', 'SEO estratégico para aumentar sua presença no Google.', 'Marketing');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'SEO estratégico',
        'agencia_sol_hero_title'           => 'para aumentar sua presença no Google',
        'agencia_sol_hero_text'            => 'Na Agência R8, implementamos SEO on-page, criamos estratégias de conteúdo e alimentamos blogs com foco em resultados. Usamos Ubersuggest para análise contínua e relatórios claros.',
        'agencia_sol_hero_form_title'      => 'Quer aparecer no topo do Google?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Nossas soluções de otimização de sites',
        'agencia_sol_entregas_text'  => 'Do SEO on-page à gestão de blog, alimentamos sua estrutura digital com palavras-chave estratégicas e análises contínuas de mercado.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Implementação de SEO on-page', 'description' => 'Títulos, meta descriptions, heading tags, links internos.'),
            array('title' => 'Auditoria técnica', 'description' => 'Análise de velocidade, indexação, responsividade e SEO técnico.'),
            array('title' => 'Estratégias de conteúdo', 'description' => 'Definição de pautas com base em palavras-chave relevantes.'),
            array('title' => 'Alimentação de blog', 'description' => 'Produção e publicação de artigos otimizados.'),
            array('title' => 'Relatórios mensais com Ubersuggest', 'description' => 'Acompanhamento de posições e evolução.'),
            array('title' => 'Dashboard personalizado R8', 'description' => 'Visão clara dos resultados.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Auditoria inicial', 'description' => 'Diagnóstico completo do site (técnico + conteúdo).'),
            array('title' => 'Implementação de SEO on-page', 'description' => 'Ajustes técnicos e de relevância.'),
            array('title' => 'Criação de conteúdo estratégico', 'description' => 'Artigos e páginas otimizadas para Google.'),
            array('title' => 'Acompanhamento contínuo', 'description' => 'Relatórios mensais via Ubersuggest + recomendações.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas comuns sobre SEO',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que é SEO e por que é importante?',
                'answer'   => 'SEO (Search Engine Optimization) é o conjunto de técnicas que ajuda o seu site a aparecer nas primeiras posições do Google de forma orgânica, sem pagar por clique. Isso gera tráfego qualificado, autoridade de marca e oportunidades de venda contínuas.',
            ),
            array(
                'question' => 'Em quanto tempo vejo resultados de SEO?',
                'answer'   => 'SEO é uma estratégia de médio e longo prazo. Os primeiros sinais costumam aparecer após alguns meses de trabalho consistente, e a evolução é acompanhada nos relatórios mensais.',
            ),
            array(
                'question' => 'Vocês cuidam só da parte técnica ou também do conteúdo?',
                'answer'   => 'Dos dois. Fazemos auditoria e SEO técnico, implementação on-page e também a estratégia de conteúdo, com definição de pautas e produção de artigos otimizados.',
            ),
            array(
                'question' => 'Qual ferramenta vocês usam para acompanhar?',
                'answer'   => 'Usamos o Ubersuggest para análise contínua e relatórios mensais de posições, além de um dashboard personalizado da R8 com a visão clara dos resultados.',
            ),
            array(
                'question' => 'Vocês produzem os artigos para blog?',
                'answer'   => 'Sim. Produzimos e publicamos artigos otimizados para o seu blog, com pautas definidas a partir de palavras-chave relevantes para o seu negócio.',
            ),
            array(
                'question' => 'Posso contratar SEO separado de outras soluções?',
                'answer'   => 'Sim. O SEO pode ser contratado separadamente ou integrado a outras soluções, como Inbound Marketing e mídia paga, para potencializar os resultados.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Alcance o topo do Google*\ncom SEO estratégico",
        'agencia_sol_cta_text'        => 'Com o SEO da R8, sua empresa ganha autoridade digital, aumenta o tráfego orgânico e conquista mais oportunidades.',
        'agencia_sol_cta_button_text' => 'Quero otimizar meu site',
    ));

    update_option('agencia_seed_seo_done', $seed_version);
}

/**
 * Seed da Solução "Implementação e Integração" de RD CRM (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_crm');
function agencia_seed_solucao_crm()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_crm_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('implementacao-e-integracao', 'Implementação e Integração', 'Implementação de RD CRM com integração completa ao marketing.', 'Vendas');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Implementação de RD CRM',
        'agencia_sol_hero_title'           => 'com integração completa ao marketing',
        'agencia_sol_hero_text'            => 'Na Agência R8, somos parceiros certificados RD Station CRM. Configuramos, personalizamos e integramos o CRM ao marketing digital para garantir mais controle, produtividade e previsibilidade comercial.',
        'agencia_sol_hero_form_title'      => 'Quer implementar o RD CRM na sua empresa?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Implementação e integração do RD CRM sob medida',
        'agencia_sol_entregas_text'  => 'Do primeiro contato à assinatura do contrato: implementação de RD CRM pensada para escalar a eficiência e o controle da sua operação.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Implantação de RD CRM', 'description' => 'Configuração inicial pronta para uso.'),
            array('title' => 'Personalização de pipelines e etapas', 'description' => 'Adaptados ao seu processo comercial.'),
            array('title' => 'Integração com RD Station Marketing', 'description' => 'Leads fluindo direto para vendas.'),
            array('title' => 'Treinamento de equipe', 'description' => 'Capacitação prática para uso eficiente do CRM.'),
            array('title' => 'Dashboards de vendas', 'description' => 'Relatórios completos para tomada de decisão.'),
            array('title' => 'Suporte e acompanhamento', 'description' => 'Evolução contínua do uso do RD CRM.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico comercial', 'description' => 'Mapeamos o processo atual de vendas.'),
            array('title' => 'Configuração do RD CRM', 'description' => 'Pipelines, permissões e automações básicas.'),
            array('title' => 'Integração com marketing digital', 'description' => 'Conexão com RD Station Marketing e campanhas.'),
            array('title' => 'Treinamento e acompanhamento', 'description' => 'Equipe pronta para usar e relatórios ativos.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => 'Dúvidas comuns sobre RD CRM',
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que é o RD CRM?',
                'answer'   => 'O RD Station CRM é uma ferramenta de gestão de vendas que organiza contatos, negociações e etapas do funil comercial, dando mais controle e previsibilidade para o time de vendas.',
            ),
            array(
                'question' => 'Por que implementar com a R8?',
                'answer'   => 'Somos parceiros certificados RD Station CRM: configuramos o CRM de acordo com o seu processo comercial, integramos ao marketing digital, treinamos a equipe e acompanhamos a evolução do uso.',
            ),
            array(
                'question' => 'Posso usar o RD CRM mesmo sem RD Marketing?',
                'answer'   => 'Sim. O RD CRM pode ser usado de forma independente. A integração com o RD Station Marketing é recomendada para que os leads fluam direto para vendas, mas não é obrigatória.',
            ),
            array(
                'question' => 'Vocês treinam minha equipe para usar o CRM?',
                'answer'   => 'Sim. O treinamento faz parte da implementação: capacitamos a equipe de forma prática para usar o CRM com eficiência no dia a dia.',
            ),
            array(
                'question' => 'Qual o prazo de implementação?',
                'answer'   => 'O prazo depende da complexidade do processo comercial e das integrações necessárias. Ele é definido após o diagnóstico comercial.',
            ),
            array(
                'question' => 'Vocês oferecem suporte após a implementação?',
                'answer'   => 'Sim. Oferecemos suporte e acompanhamento para a evolução contínua do uso do RD CRM na sua empresa.',
            ),
        ),

        // CTA
        'agencia_sol_cta_heading'     => "*Estruture seu funil* com o RD CRM\ne aumente suas vendas",
        'agencia_sol_cta_text'        => "Com a R8, parceira certificada RD CRM, sua empresa ganha um processo de vendas claro,\nintegrado ao marketing e preparado para escalar com previsibilidade.",
        'agencia_sol_cta_button_text' => 'Quero implementar o RD CRM',
    ));

    update_option('agencia_seed_crm_done', $seed_version);
}

/**
 * Seed da Solução "Playbook de vendas" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_playbook');
function agencia_seed_solucao_playbook()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_playbook_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('playbook-de-vendas', 'Playbook de vendas', 'Playbook de Vendas para estruturar e escalar seu processo comercial.', 'Vendas');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Playbook de Vendas',
        'agencia_sol_hero_title'           => 'para estruturar e escalar seu processo comercial',
        'agencia_sol_hero_text'            => 'Na Agência R8, ajudamos sua empresa a documentar processos de vendas, estruturar funis e criar um manual prático que aumenta conversão e previsibilidade.',
        'agencia_sol_hero_form_title'      => 'Quer organizar seu time de vendas?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Estrutura comercial sob medida para sua empresa',
        'agencia_sol_entregas_text'  => 'Do mapeamento da jornada ao alinhamento da equipe, desenhamos processos comerciais inteligentes para acelerar o ciclo de vendas da sua empresa.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Perfil de Cliente Ideal (ICP)', 'description' => 'Identificação precisa do seu público e persona compradora para atrair os melhores leads.'),
            array('title' => 'Jornada do Cliente', 'description' => 'Mapeamento completo de todos os pontos de contato e decisão de compra.'),
            array('title' => 'Funil de Vendas Estruturado', 'description' => 'Etapas objetivas e bem definidas para direcionar o cliente da atração ao fechamento.'),
            array('title' => 'Roteiros de Abordagem & Script', 'description' => 'Scripts de prospecção, acompanhamento e fechamento para padronizar o discurso.'),
            array('title' => 'Quebra de Objeções', 'description' => 'Mapeamento de barreira de vendas e respostas padronizadas para a equipe.'),
            array('title' => 'Indicadores & Métricas (KPIs)', 'description' => 'Acompanhamento de metas e dados em tempo real para tomada de decisão.'),
            array('title' => 'Rotinas & Cadência Comercial', 'description' => 'Ritmo contínuo de contatos, checkpoints e alinhamentos de performance do time.'),
            array('title' => 'Integração com RD Station CRM', 'description' => 'Implementação prática do funil diretamente na sua ferramenta de CRM.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Diagnóstico inicial', 'description' => 'Análise do processo de vendas atual.'),
            array('title' => 'Entrevistas e imersão', 'description' => 'Coleta de informações com gestores e equipe comercial.'),
            array('title' => 'Construção do Playbook', 'description' => 'Documento com ICP, jornada, funil, scripts e rotinas.'),
            array('title' => 'Entrega e treinamento', 'description' => 'Apresentação e capacitação da equipe para aplicar no dia a dia.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas comuns sobre\nPlaybook de Vendas",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que é um Playbook de Vendas?',
                'answer'   => 'É um manual prático que documenta como a sua empresa vende: perfil de cliente ideal, jornada, etapas do funil, scripts, quebra de objeções, rotinas e indicadores. Ele padroniza o processo e facilita a escala do time comercial.',
            ),
            array(
                'question' => 'Por que minha empresa precisa de um Playbook?',
                'answer'   => 'Com o processo documentado, o time vende de forma consistente, novos vendedores entram mais rápido no ritmo e a gestão ganha previsibilidade sobre metas e resultados.',
            ),
            array(
                'question' => 'Vocês integram o Playbook ao CRM?',
                'answer'   => 'Sim. O funil definido no Playbook é implementado na prática no RD Station CRM, para que o processo saia do papel e seja aplicado no dia a dia.',
            ),
            array(
                'question' => 'O Playbook serve só para B2B?',
                'answer'   => 'Não. Qualquer empresa com um time comercial se beneficia de um processo de vendas documentado, seja no B2B ou no B2C.',
            ),
            array(
                'question' => 'Quanto tempo leva para criar um Playbook?',
                'answer'   => 'Depende do tamanho do time e da complexidade do processo comercial. O prazo é definido após o diagnóstico inicial.',
            ),
            array(
                'question' => 'Vocês treinam minha equipe para aplicar?',
                'answer'   => 'Sim. A entrega inclui a apresentação do Playbook e a capacitação da equipe para aplicar o processo no dia a dia.',
            ),
        ),

        // CTA (botão igual ao da página de RD CRM no layout; revisar no painel)
        'agencia_sol_cta_heading'     => "*Venda mais e melhor* com um processo\ncomercial estruturado",
        'agencia_sol_cta_text'        => "Com o Playbook de Vendas da R8, sua empresa ganha clareza, previsibilidade e escala no processo de vendas.\nDo ICP ao fechamento, tudo mapeado em um manual prático e aplicado no CRM.",
        'agencia_sol_cta_button_text' => 'Quero implementar o RD CRM',
    ));

    update_option('agencia_seed_playbook_done', $seed_version);
}

/**
 * Seed da Solução "Automações" de vendas (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_solucao_automacoes_vendas');
function agencia_seed_solucao_automacoes_vendas()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_automacoes_vendas_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_solucao_post('automacoes-de-vendas', 'Automações de Vendas','Automações de Vendas que integram marketing e comercial.', 'Vendas');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_sol_hero_title_highlight' => 'Automações de Vendas',
        'agencia_sol_hero_title'           => 'que integram marketing e comercial',
        'agencia_sol_hero_text'            => 'Na Agência R8, estruturamos automações no RD CRM e RD Station Marketing para qualificação de leads, follow-ups, pós-venda e muito mais. Menos processos manuais, mais eficiência e resultados.',
        'agencia_sol_hero_form_title'      => 'Quer vender mais com menos esforço manual?',
        'agencia_sol_hero_form_button'     => 'Começar agora',

        // Entregas
        'agencia_sol_entregas_badge' => 'O que entregamos',
        'agencia_sol_entregas_title' => 'Fluxos inteligentes que aumentam conversão',
        'agencia_sol_entregas_text'  => 'Da qualificação de contatos ao gatilho no CRM, conectamos suas ferramentas de marketing e vendas para criar jornadas de compra fluida e eficiente.',
        'agencia_sol_entregas_group' => array(
            array('title' => 'Qualificação automática de leads', 'description' => 'Integração com marketing e funil comercial.'),
            array('title' => 'Follow-up automatizado', 'description' => 'Lembretes e notificações para equipe de vendas.'),
            array('title' => 'Nutrição e engajamento', 'description' => 'E-mails, WhatsApp e SMS conectados ao funil.'),
            array('title' => 'Pós-venda automatizado', 'description' => 'Pesquisas, recompra, cross-sell e fidelização.'),
            array('title' => "Integração com\nRD CRM", 'description' => 'Automações ligadas ao pipeline de vendas.'),
            array('title' => 'Integração com RD Station Marketing', 'description' => 'Leads nutridos chegam prontos para vendas.'),
        ),

        // Processo
        'agencia_sol_processo_badge' => 'Como funciona',
        'agencia_sol_processo_title' => 'Nosso processo em 4 etapas',
        'agencia_sol_processo_group' => array(
            array('title' => 'Mapeamento do funil de vendas', 'description' => 'Diagnóstico do processo atual.'),
            array('title' => 'Definição de fluxos automáticos', 'description' => 'Nutrição, follow-up e pós-venda.'),
            array('title' => 'Implantação Técnica RD Station', 'description' => 'Configuração e parametrização completa de fluxos no RD CRM e RD Marketing.'),
            array('title' => 'Testes e otimização', 'description' => 'Ajustes contínuos para aumentar conversão.'),
        ),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_sol_faq_badge' => 'FAQ',
        'agencia_sol_faq_title' => "Dúvidas comuns sobre\nautomação comercial",
        'agencia_sol_faq_group' => array(
            array(
                'question' => 'O que são automações de vendas?',
                'answer'   => 'São fluxos que executam tarefas comerciais de forma automática, como qualificar leads, enviar follow-ups, notificar o vendedor e fazer o pós-venda, conectando marketing e comercial sem depender de processos manuais.',
            ),
            array(
                'question' => 'Vocês implementam automações em qual ferramenta?',
                'answer'   => 'Trabalhamos com o RD Station CRM e o RD Station Marketing, configurando e parametrizando os fluxos nas duas ferramentas.',
            ),
            array(
                'question' => 'Automação substitui o vendedor?',
                'answer'   => 'Não. A automação cuida das tarefas repetitivas para que o vendedor tenha mais tempo para conversar com os clientes certos e fechar negócios.',
            ),
            array(
                'question' => 'Quais fluxos podem ser automatizados?',
                'answer'   => 'Qualificação de leads, follow-ups, lembretes para a equipe, nutrição por e-mail, WhatsApp e SMS, além de pós-venda com pesquisas, recompra e cross-sell.',
            ),
            array(
                'question' => 'Funciona só em B2B?',
                'answer'   => 'Não. As automações de vendas funcionam tanto no B2B quanto no B2C: o que muda são os fluxos e os gatilhos de cada jornada.',
            ),
            array(
                'question' => 'Preciso já ter o RD CRM para usar?',
                'answer'   => 'Não é preciso ter o RD CRM antes de começar: também fazemos a implementação e integração do RD CRM, deixando tudo pronto para as automações.',
            ),
        ),

        // CTA (botão igual ao da página de RD CRM no layout; revisar no painel)
        'agencia_sol_cta_heading'     => "*Vendas mais rápidas* e eficientes\ncom automações inteligentes",
        'agencia_sol_cta_text'        => 'Na R8, unimos marketing e vendas com fluxos automatizados que qualificam, nutrem e fecham negócios com mais previsibilidade.',
        'agencia_sol_cta_button_text' => 'Quero implementar o RD CRM',
    ));

    update_option('agencia_seed_automacoes_vendas_done', $seed_version);
}

/**
 * Seed: cria (se não existir) o post da Solução e associa à área. Retorna o ID ou 0.
 */
function agencia_seed_solucao_post($slug, $title, $excerpt, $area)
{
    $term = term_exists($area, 'area_solucao');
    if (!$term) {
        $term = wp_insert_term($area, 'area_solucao');
    }

    $post = get_page_by_path($slug, OBJECT, 'solucao');
    if ($post) {
        $post_id = $post->ID;
    } else {
        $post_id = wp_insert_post(array(
            'post_type'    => 'solucao',
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_excerpt' => $excerpt,
        ));
    }

    if (!$post_id || is_wp_error($post_id)) {
        return 0;
    }

    if (!is_wp_error($term) && !has_term('', 'area_solucao', $post_id)) {
        wp_set_object_terms($post_id, (int) $term['term_id'], 'area_solucao');
    }

    return $post_id;
}

/**
 * Seed: importa as imagens de assets/seed/{pasta}/ para a galeria da Solução (só se a galeria estiver vazia)
 */
function agencia_seed_solucao_galeria($post_id, $folder)
{
    if (!empty(get_post_meta($post_id, 'agencia_sol_galeria_images', true))) {
        return;
    }

    $images = array();
    foreach (glob(get_template_directory() . '/assets/seed/' . $folder . '/*.webp') as $file) {
        $attachment_id = agencia_seed_import_image('assets/seed/' . $folder . '/' . basename($file), $post_id);
        if ($attachment_id) {
            $images[$attachment_id] = wp_get_attachment_url($attachment_id);
        }
    }

    if ($images) {
        update_post_meta($post_id, 'agencia_sol_galeria_images', $images);
    }
}

/**
 * Seed: grava os campos da Solução sem sobrescrever o que já foi preenchido no painel
 */
function agencia_seed_solucao_meta($post_id, $defaults)
{
    foreach ($defaults as $key => $value) {
        $existing = get_post_meta($post_id, $key, true);
        if ($existing === '' || $existing === array()) {
            update_post_meta($post_id, $key, $value);
        }
    }
}
