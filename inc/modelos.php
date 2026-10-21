<?php

/**
 * Single de Modelos de Negócio: campos CMB2 e seed da página B2B
 *
 * Hero (com formulário), FAQ e CTA usam os mesmos template-parts das Soluções (template-parts/sol-*.php).
 */

/**
 * Cria uma caixa de campos do Modelo de Negócio
 */
function agencia_mod_box($id, $title)
{
    return new_cmb2_box(array(
        'id'           => 'agencia_mod_' . $id . '_metabox',
        'title'        => $title,
        'object_types' => array('modelo_negocio'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));
}

/**
 * Cria um repeater (group) dentro de uma caixa
 */
function agencia_mod_group($cmb, $id, $description, $item_label)
{
    return $cmb->add_field(array(
        'id'          => $id,
        'type'        => 'group',
        'description' => $description,
        'options'     => array(
            'group_title'    => $item_label . ' {#}',
            'add_button'     => 'Adicionar ' . $item_label,
            'remove_button'  => 'Remover ' . $item_label,
            'sortable'       => true,
            'closed'         => true,
            'remove_confirm' => esc_html__('Tem certeza?', 'agencia'),
        ),
    ));
}

/**
 * Campos de cabeçalho de seção (badge + título com quebra de linha + texto opcional)
 */
function agencia_mod_header_fields($cmb, $prefix, $with_text = false)
{
    $cmb->add_field(array(
        'name' => esc_html__('Badge da Seção', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Título da Seção', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => $prefix . 'title',
        'type' => 'textarea_small',
    ));

    if ($with_text) {
        $cmb->add_field(array(
            'name' => esc_html__('Texto da Seção', 'agencia'),
            'id'   => $prefix . 'text',
            'type' => 'textarea_small',
        ));
    }
}

add_action('cmb2_admin_init', 'agencia_register_modelo_metaboxes');
function agencia_register_modelo_metaboxes()
{
    // Hero
    $prefix = 'agencia_mod_hero_';
    $cmb    = agencia_mod_box('hero', esc_html__('Hero (Dobra Inicial)', 'agencia'));

    $cmb->add_field(array(
        'name' => esc_html__('Badge', 'agencia'),
        'desc' => esc_html__('Texto pequeno acima do título. Ex: Acelere suas vendas', 'agencia'),
        'id'   => $prefix . 'badge',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Título - parte em destaque (amarelo)', 'agencia'),
        'id'   => $prefix . 'title_highlight',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Título - continuação (branco)', 'agencia'),
        'desc' => esc_html__('Se o título ficar todo vazio, usa o título do post.', 'agencia'),
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

    // Desafios
    $prefix = 'agencia_mod_desafios_';
    $cmb    = agencia_mod_box('desafios', esc_html__('Seção "Desafios"', 'agencia'));
    agencia_mod_header_fields($cmb, $prefix);
    $group = agencia_mod_group($cmb, $prefix . 'group', esc_html__('Lista de desafios', 'agencia'), 'Desafio');
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Texto', 'agencia'),
        'id'   => 'text',
        'type' => 'text',
    ));

    // Como a R8 ajuda
    $prefix = 'agencia_mod_ajuda_';
    $cmb    = agencia_mod_box('ajuda', esc_html__('Seção "Como a R8 ajuda"', 'agencia'));
    agencia_mod_header_fields($cmb, $prefix, true);
    $group = agencia_mod_group($cmb, $prefix . 'group', esc_html__('Cards', 'agencia'), 'Card');
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha (Enter) vira uma nova linha no site.', 'agencia'),
        'id'   => 'title',
        'type' => 'textarea_small',
    ));
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));

    // Metodologia
    $prefix = 'agencia_mod_metodologia_';
    $cmb    = agencia_mod_box('metodologia', esc_html__('Seção "Como funciona" (etapas)', 'agencia'));
    agencia_mod_header_fields($cmb, $prefix);
    $group = agencia_mod_group($cmb, $prefix . 'group', esc_html__('Etapas (numeradas automaticamente)', 'agencia'), 'Etapa');
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Título', 'agencia'),
        'id'   => 'title',
        'type' => 'text',
    ));
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Descrição', 'agencia'),
        'id'   => 'description',
        'type' => 'textarea_small',
    ));

    // Resultados (cases)
    $prefix = 'agencia_mod_resultados_';
    $cmb    = agencia_mod_box('resultados', esc_html__('Seção "Resultados" (cases)', 'agencia'));
    agencia_mod_header_fields($cmb, $prefix);
    $group = agencia_mod_group($cmb, $prefix . 'group', esc_html__('Cada linha tem um case grande (logo, texto e 2 números) e um destaque menor (logo, número e legenda). As linhas pares invertem a ordem e usam o fundo amarelo.', 'agencia'), 'Linha');
    $fields = array(
        array('logo', 'Case grande - logo', 'file'),
        array('text', 'Case grande - texto', 'textarea_small'),
        array('n1_valor', 'Case grande - número 1 (ex: 180%)', 'text'),
        array('n1_texto', 'Case grande - legenda do número 1', 'text'),
        array('n2_valor', 'Case grande - número 2', 'text'),
        array('n2_texto', 'Case grande - legenda do número 2', 'text'),
        array('destaque_logo', 'Destaque - logo', 'file'),
        array('destaque_valor', 'Destaque - número (ex: 30x)', 'text'),
        array('destaque_texto', 'Destaque - legenda', 'text'),
    );
    foreach ($fields as $field) {
        $args = array(
            'name' => $field[1],
            'id'   => $field[0],
            'type' => $field[2],
        );
        if ($field[2] === 'file') {
            $args['options']      = array('url' => false);
            $args['preview_size'] = 'thumbnail';
            $args['query_args']   = array('type' => 'image');
        }
        $cmb->add_group_field($group, $args);
    }

    // FAQ
    $prefix = 'agencia_mod_faq_';
    $cmb    = agencia_mod_box('faq', esc_html__('Seção "Perguntas Frequentes"', 'agencia'));
    agencia_mod_header_fields($cmb, $prefix);
    $group = agencia_mod_group($cmb, $prefix . 'group', esc_html__('Perguntas e respostas', 'agencia'), 'Pergunta');
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Pergunta', 'agencia'),
        'id'   => 'question',
        'type' => 'text',
    ));
    $cmb->add_group_field($group, array(
        'name' => esc_html__('Resposta', 'agencia'),
        'id'   => 'answer',
        'type' => 'textarea',
    ));

    // CTA
    $prefix = 'agencia_mod_cta_';
    $cmb    = agencia_mod_box('cta', esc_html__('Seção "CTA" (antes do rodapé)', 'agencia'));
    $cmb->add_field(array(
        'name' => esc_html__('Número de empresas', 'agencia'),
        'desc' => esc_html__('Aparece com as fotos acima do título. Ex: +100', 'agencia'),
        'id'   => $prefix . 'empresas_numero',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Legenda do número', 'agencia'),
        'desc' => esc_html__('Ex: Empresas impactadas', 'agencia'),
        'id'   => $prefix . 'empresas_texto',
        'type' => 'text',
    ));
    $cmb->add_field(array(
        'name' => esc_html__('Título', 'agencia'),
        'desc' => esc_html__('Cada quebra de linha vira uma nova linha no site. Coloque entre *asteriscos* o trecho em amarelo. Se vazio, exibe o CTA padrão do site.', 'agencia'),
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
 * Seed: cria (se não existir) o post do Modelo de Negócio. Retorna o ID ou 0.
 */
function agencia_seed_modelo_post($slug, $title, $excerpt)
{
    $post = get_page_by_path($slug, OBJECT, 'modelo_negocio');
    if ($post) {
        return $post->ID;
    }

    $post_id = wp_insert_post(array(
        'post_type'    => 'modelo_negocio',
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_excerpt' => $excerpt,
    ));

    return ($post_id && !is_wp_error($post_id)) ? $post_id : 0;
}

/**
 * Seed: logo dos cases do layout. Reaproveita a imagem se já estiver na biblioteca de mídia.
 */
function agencia_seed_modelo_logo($name, $post_id)
{
    $existing = get_posts(array(
        'post_type'      => 'attachment',
        'name'           => $name,
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    return $existing ? $existing[0] : agencia_seed_import_image('assets/seed/b2b/' . $name . '.webp', $post_id);
}

/**
 * Seed: linhas de cases do layout (os mesmos números de exemplo em todos os modelos; revisar no painel)
 */
function agencia_seed_modelo_resultados($post_id)
{
    $cafezale = agencia_seed_modelo_logo('cafezale', $post_id);
    $linhas   = array();

    foreach (array('viagastro', 'btm') as $destaque) {
        $destaque_id = agencia_seed_modelo_logo($destaque, $post_id);
        $linhas[]    = array(
            'logo_id'          => $cafezale,
            'logo'             => wp_get_attachment_url($cafezale),
            'text'             => 'Em dois meses, houve +200% de crescimento em seguidores no Instagram, taxa de cliques de 6,5% nos anúncios e aumento de 40% nas vendas online.',
            'n1_valor'         => '180%',
            'n1_texto'         => 'No faturamento em 6 meses',
            'n2_valor'         => '180%',
            'n2_texto'         => 'No faturamento em 6 meses',
            'destaque_logo_id' => $destaque_id,
            'destaque_logo'    => wp_get_attachment_url($destaque_id),
            'destaque_valor'   => '30x',
            'destaque_texto'   => 'Leads qualificados',
        );
    }

    return $linhas;
}

/**
 * Seed do Modelo de Negócio "B2B" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_modelo_b2b');
function agencia_seed_modelo_b2b()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_modelo_b2b_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_modelo_post('b2b', 'B2B', 'Agência de Marketing B2B para geração de demanda e vendas entre empresas.');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero (título do formulário igual ao de Branding no layout; revisar no painel)
        'agencia_mod_hero_badge'           => 'Acelere suas vendas',
        'agencia_mod_hero_title_highlight' => 'Agência de Marketing B2B',
        'agencia_mod_hero_title'           => 'para geração de demanda e vendas entre empresas',
        'agencia_mod_hero_text'            => 'Na Agência R8, ajudamos indústrias, distribuidoras, construtoras e empresas de serviços a vender mais para outras empresas. Do marketing ao CRM, entregamos soluções completas para escalar negócios B2B.',
        'agencia_mod_hero_form_title'      => 'Comece já o seu branding estratégico e conquiste clientes com confiança',
        'agencia_mod_hero_form_button'     => 'Começar agora',

        // Desafios
        'agencia_mod_desafios_title' => 'Os principais desafios das empresas B2B',
        'agencia_mod_desafios_group' => array(
            array('text' => 'Ciclos de vendas longos e complexos'),
            array('text' => 'Geração de leads desqualificados.'),
            array('text' => 'Pouca previsibilidade nas oportunidades.'),
            array('text' => 'Falta de integração entre marketing e comercial.'),
            array('text' => 'Necessidade de processos digitais para escalar vendas.'),
        ),

        // Como a R8 ajuda
        'agencia_mod_ajuda_badge' => 'O que entregamos',
        'agencia_mod_ajuda_title' => "Como a R8 ajuda\nempresas B2B a crescer",
        'agencia_mod_ajuda_text'  => 'Do branding ao funil de vendas previsível, oferecemos soluções integradas para empresas que querem escalar com performance.',
        'agencia_mod_ajuda_group' => array(
            array('title' => 'Sites institucionais e landing pages B2B', 'description' => 'Presença digital profissional e geração de leads.'),
            array('title' => 'E-commerce B2B', 'description' => 'Plataformas integradas para vendas recorrentes entre empresas.'),
            array('title' => 'Inbound Marketing e SEO', 'description' => 'Atração de decisores e autoridade digital.'),
            array('title' => 'Gestão de mídia paga (Google, LinkedIn, Meta, TikTok Ads)', 'description' => 'Geração de demanda segmentada.'),
            array('title' => 'Implementação e integração de CRM (RD CRM)', 'description' => 'Funil de vendas estruturado.'),
            array('title' => 'Automações de marketing e vendas', 'description' => 'Nutrição, follow-up e pós-venda automáticos.'),
            array('title' => 'Dashboards personalizados', 'description' => 'Indicadores em tempo real para decisões ágeis.'),
        ),

        // Metodologia (etapas iguais às de Branding no layout; revisar no painel)
        'agencia_mod_metodologia_badge' => 'Como funciona',
        'agencia_mod_metodologia_title' => 'Nosso jeito de estruturar marketing e vendas B2B',
        'agencia_mod_metodologia_group' => array(
            array('title' => 'Briefing e Pesquisa', 'description' => 'Entendemos visão, valores e objetivos do negócio, analisamos mercado e concorrência.'),
            array('title' => 'Conceituação de Marca', 'description' => 'Criamos conceitos visuais e naming, alinhados à estratégia da empresa.'),
            array('title' => 'Design e Desenvolvimento', 'description' => 'Refinamos o logotipo e produzimos manual de marca completo.'),
            array('title' => 'Entrega Final', 'description' => 'Aplicações práticas, peças gráficas e diretrizes visuais prontas para uso.'),
        ),

        // Resultados (números do layout; revisar no painel)
        'agencia_mod_resultados_badge' => 'Cases',
        'agencia_mod_resultados_title' => 'Resultados reais com empresas B2B',
        'agencia_mod_resultados_group' => agencia_seed_modelo_resultados($post_id),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_mod_faq_badge' => 'FAQ',
        'agencia_mod_faq_title' => 'Dúvidas comuns de empresas B2B',
        'agencia_mod_faq_group' => array(
            array(
                'question' => 'Vocês atendem só marketing B2B ou também tecnologia?',
                'answer'   => 'Os dois. Além do marketing, desenvolvemos sites institucionais, landing pages e e-commerces B2B, e implementamos CRM e automações, conectando todas as frentes em um único funil de vendas.',
            ),
            array(
                'question' => 'Quais canais funcionam melhor no B2B?',
                'answer'   => 'Depende do perfil do seu cliente, mas os resultados costumam vir da combinação de SEO e conteúdo para atrair decisores, mídia paga segmentada (como Google e LinkedIn Ads) e automações para nutrir os leads até a venda.',
            ),
            array(
                'question' => 'Como o CRM ajuda no B2B?',
                'answer'   => 'No B2B a venda passa por várias etapas e decisores. O CRM organiza o funil, registra cada negociação e dá visibilidade sobre as oportunidades, trazendo mais controle e previsibilidade para o time comercial.',
            ),
            array(
                'question' => 'Vocês conseguem ajudar a reduzir o ciclo de vendas?',
                'answer'   => 'Sim. Com leads mais qualificados, nutrição automatizada e um funil estruturado no CRM, o time comercial conversa com quem está mais perto da decisão, o que ajuda a encurtar o ciclo de vendas.',
            ),
            array(
                'question' => 'Marketing digital realmente funciona para indústrias e distribuidoras?',
                'answer'   => 'Sim. Compradores B2B pesquisam online antes de falar com um vendedor. Uma presença digital forte, aliada a conteúdo, mídia segmentada e CRM, gera oportunidades qualificadas também para indústrias e distribuidoras.',
            ),
        ),

        // CTA
        'agencia_mod_cta_empresas_numero' => '+100',
        'agencia_mod_cta_empresas_texto'  => 'Empresas impactadas',
        'agencia_mod_cta_heading'         => "Crescimento previsível\n*para empresas B2B*",
        'agencia_mod_cta_text'            => 'Na R8, cada entrega é parte de um processo contínuo para gerar resultados mensuráveis, reduzir CAC e aumentar o ROI da sua empresa.',
        'agencia_mod_cta_button_text'     => 'Quero acelerar meu crescimento',
    ));

    update_option('agencia_seed_modelo_b2b_done', $seed_version);
}

/**
 * Seed do Modelo de Negócio "Agro" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_modelo_agro');
function agencia_seed_modelo_agro()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_modelo_agro_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_modelo_post('agro', 'Agro', 'Marketing digital para o agronegócio com foco em resultados reais.');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_mod_hero_badge'           => 'Acelere suas vendas',
        'agencia_mod_hero_title_highlight' => 'Marketing digital para o agronegócio',
        'agencia_mod_hero_title'           => 'com foco em resultados reais',
        'agencia_mod_hero_text'            => 'Na Agência R8, ajudamos empresas do agro, cooperativas, indústrias, distribuidores e agtechs a gerar demanda, integrar marketing e vendas e escalar seus resultados.',
        'agencia_mod_hero_form_title'      => 'Quer impulsionar seu negócio no agro?',
        'agencia_mod_hero_form_button'     => 'Começar agora',

        // Desafios
        'agencia_mod_desafios_title' => 'Os principais desafios do setor agro',
        'agencia_mod_desafios_group' => array(
            array('text' => 'Ciclos de vendas sazonais e dependentes de safra.'),
            array('text' => 'Dificuldade em digitalizar canais de vendas.'),
            array('text' => 'Pouca previsibilidade no funil comercial.'),
            array('text' => 'Falta de integração entre marketing e comercial.'),
            array('text' => 'Baixa utilização de dados para decisões estratégicas.'),
        ),

        // Como a R8 ajuda
        'agencia_mod_ajuda_badge' => 'O que entregamos',
        'agencia_mod_ajuda_title' => "Como a R8 apoia empresas\ndo agronegócio",
        'agencia_mod_ajuda_text'  => 'Soluções digitais sob medida para conectar cooperativas, revendas e marcas agro ao mercado moderno.',
        'agencia_mod_ajuda_group' => array(
            array('title' => 'E-commerce B2B e B2C', 'description' => 'Plataformas para distribuidores, cooperativas e revendas.'),
            array('title' => 'Sites institucionais e landing pages', 'description' => 'Presença digital profissional para marcas agro.'),
            array('title' => 'Inbound Marketing e SEO', 'description' => 'Geração de autoridade em nichos técnicos e captação de leads.'),
            array('title' => 'Gestão de mídia paga segmentada', 'description' => 'Campanhas no Google, Facebook e LinkedIn Ads, segmentadas por região/estado.'),
            array('title' => 'Implementação de CRM (RD CRM)', 'description' => 'Controle de funil, previsibilidade e integração com marketing.'),
            array('title' => 'Automação de marketing e vendas', 'description' => 'Fluxos de nutrição, follow-up e pós-venda.'),
            array('title' => 'Dashboards personalizados', 'description' => 'Análise em tempo real da performance comercial e regional.'),
        ),

        // Metodologia
        'agencia_mod_metodologia_badge' => 'Como funciona',
        'agencia_mod_metodologia_title' => 'Nosso jeito de transformar marketing e vendas no agronegócio',
        'agencia_mod_metodologia_group' => array(
            array('title' => 'Imersão no negócio agro', 'description' => 'Mapeamento de operação, público e sazonalidades.'),
            array('title' => 'Planejamento estratégico', 'description' => 'Definição de canais digitais e metas comerciais.'),
            array('title' => 'Execução 360', 'description' => 'Marketing, CRM e vendas integrados.'),
            array('title' => 'Acompanhamento contínuo', 'description' => 'Dashboards em tempo real e relatórios mensais.'),
        ),

        // Resultados (números do layout; revisar no painel)
        'agencia_mod_resultados_badge' => 'Cases',
        'agencia_mod_resultados_title' => 'Resultados reais com empresas do agronegócio',
        'agencia_mod_resultados_group' => agencia_seed_modelo_resultados($post_id),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_mod_faq_badge' => 'FAQ',
        'agencia_mod_faq_title' => 'Dúvidas comuns do agronegócio',
        'agencia_mod_faq_group' => array(
            array(
                'question' => 'Marketing digital funciona para o agro?',
                'answer'   => 'Sim. Produtores, revendas e cooperativas pesquisam online antes de comprar. Com conteúdo técnico, mídia segmentada por região e um funil bem estruturado, o marketing digital gera demanda qualificada também no agronegócio.',
            ),
            array(
                'question' => 'Vocês fazem e-commerce B2B para agro?',
                'answer'   => 'Sim. Desenvolvemos e-commerces B2B e B2C para distribuidores, cooperativas e revendas, integrados ao marketing e ao processo comercial.',
            ),
            array(
                'question' => 'Qual a diferença entre marketing agro e outros setores?',
                'answer'   => 'O agro tem ciclos de venda sazonais e dependentes de safra, públicos técnicos e forte peso regional. Por isso, a estratégia considera o calendário do campo, a segmentação por região e conteúdos que falam a linguagem do setor.',
            ),
            array(
                'question' => 'Vocês atendem empresas fora de Uberlândia?',
                'answer'   => 'Sim. O trabalho pode ser conduzido de forma remota, com reuniões online, então atendemos empresas do agro em diferentes regiões.',
            ),
            array(
                'question' => 'Vocês também estruturam CRM para equipes comerciais do agro?',
                'answer'   => 'Sim. Implementamos o RD CRM para organizar o funil, dar previsibilidade às oportunidades e integrar o time comercial ao marketing.',
            ),
        ),

        // CTA
        'agencia_mod_cta_empresas_numero' => '+100',
        'agencia_mod_cta_empresas_texto'  => 'Empresas impactadas',
        'agencia_mod_cta_heading'         => "Marketing e vendas digitais *para o*\n*agronegócio escalar resultados*",
        'agencia_mod_cta_text'            => "Na R8, unimos tecnologia, marketing e vendas para transformar a realidade de empresas do agro.\nMais demanda, mais previsibilidade e mais performance para o seu negócio.",
        'agencia_mod_cta_button_text'     => 'Quero impulsionar meu negócio Agro',
    ));

    update_option('agencia_seed_modelo_agro_done', $seed_version);
}

/**
 * Seed do Modelo de Negócio "Saúde" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_modelo_saude');
function agencia_seed_modelo_saude()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_modelo_saude_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_modelo_post('saude', 'Saúde', 'Marketing para saúde: gere pacientes e fortaleça sua marca local.');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_mod_hero_badge'           => 'Acelere suas vendas',
        'agencia_mod_hero_title_highlight' => 'Marketing para saúde:',
        'agencia_mod_hero_title'           => 'gere pacientes e fortaleça sua marca local',
        'agencia_mod_hero_text'            => 'Na Agência R8, ajudamos clínicas, consultórios e empresas de saúde a se destacarem no mercado local, atraindo pacientes e construindo autoridade com estratégias digitais e presenciais.',
        'agencia_mod_hero_form_title'      => 'Quer mais pacientes e autoridade para sua clínica?',
        'agencia_mod_hero_form_button'     => 'Começar agora',

        // Desafios
        'agencia_mod_desafios_title' => 'Desafios comuns para clínicas e consultórios',
        'agencia_mod_desafios_group' => array(
            array('text' => 'Dificuldade em atrair pacientes novos com consistência.'),
            array('text' => 'Dependência de indicações e boca a boca.'),
            array('text' => 'Baixa presença digital frente à concorrência local.'),
            array('text' => 'Necessidade de construir autoridade e reputação.'),
            array('text' => 'Pouca clareza nos resultados das ações de marketing.'),
        ),

        // Como a R8 ajuda
        'agencia_mod_ajuda_badge' => 'O que entregamos',
        'agencia_mod_ajuda_title' => "Como a R8 apoia clínicas,\nconsultórios e laboratórios",
        'agencia_mod_ajuda_text'  => 'Estratégias digitais e de branding sob medida para acelerar a presença de mercado da sua instituição de saúde.',
        'agencia_mod_ajuda_group' => array(
            array('title' => 'Audiovisual', 'description' => 'Vídeos institucionais, depoimentos e campanhas humanizadas.'),
            array('title' => 'Presença digital', 'description' => 'Sites, redes sociais e campanhas de mídia paga.'),
            array('title' => 'Gestão de mídia paga', 'description' => 'Captação de pacientes locais segmentados através do Google, Meta, TikTok e outros.'),
            array('title' => 'Inbound Marketing e SEO local', 'description' => 'Atração orgânica com blog, conteúdos e palavras-chave da cidade/região.'),
            array('title' => 'Branding local', 'description' => 'Fortalecimento de marca em campanhas digitais e até mídia offline (outdoors, rádio, TV).'),
            array('title' => 'Endomarketing', 'description' => 'Comunicação interna e fortalecimento da equipe.'),
            array('title' => 'Dashboards e relatórios', 'description' => 'Resultados claros em geração de leads e presença de marca.'),
        ),

        // Metodologia
        'agencia_mod_metodologia_badge' => 'Como funciona',
        'agencia_mod_metodologia_title' => 'Nosso jeito de fazer marketing para saúde',
        'agencia_mod_metodologia_group' => array(
            array('title' => 'Imersão no negócio', 'description' => 'Análise de público, especialidades e diferenciais da clínica.'),
            array('title' => 'Planejamento estratégico', 'description' => 'Definição de canais digitais e offline para atrair pacientes e fortalecer marca.'),
            array('title' => 'Execução integrada', 'description' => 'Audiovisual, mídia paga, inbound e branding local.'),
            array('title' => 'Análise e otimização', 'description' => 'Relatórios mensais e dashboards para acompanhamento contínuo.'),
        ),

        // Resultados (números do layout; revisar no painel)
        'agencia_mod_resultados_badge' => 'Cases',
        'agencia_mod_resultados_title' => 'Resultados reais com clientes da saúde',
        'agencia_mod_resultados_group' => agencia_seed_modelo_resultados($post_id),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_mod_faq_badge' => 'FAQ',
        'agencia_mod_faq_title' => 'Dúvidas comuns de clínicas e consultórios',
        'agencia_mod_faq_group' => array(
            array(
                'question' => 'Marketing digital funciona para clínicas locais?',
                'answer'   => 'Sim. A maioria dos pacientes pesquisa no Google e nas redes sociais antes de escolher uma clínica. Com presença digital, SEO local e mídia segmentada por região, sua clínica aparece para quem está procurando atendimento perto de você.',
            ),
            array(
                'question' => 'Vocês só fazem digital ou também offline?',
                'answer'   => 'Os dois. Além do digital, trabalhamos o branding local em mídias offline, como outdoors, rádio e TV, integrando todas as ações na mesma estratégia.',
            ),
            array(
                'question' => 'Vocês produzem vídeos para clínicas?',
                'answer'   => 'Sim. Produzimos vídeos institucionais, depoimentos e campanhas humanizadas, pensados para redes sociais, site e anúncios.',
            ),
            array(
                'question' => 'Como funciona o SEO local para saúde?',
                'answer'   => 'O SEO local trabalha o site, o blog e os conteúdos com palavras-chave da sua cidade e região, para que a clínica apareça nas buscas de pacientes que procuram atendimento por perto.',
            ),
            array(
                'question' => 'Vocês atendem apenas Uberlândia?',
                'answer'   => 'Não. Boa parte do trabalho pode ser conduzida de forma remota, então atendemos clínicas e consultórios de outras cidades. Fale com a gente para avaliarmos a sua necessidade.',
            ),
        ),

        // CTA
        'agencia_mod_cta_empresas_numero' => '+100',
        'agencia_mod_cta_empresas_texto'  => 'Empresas impactadas',
        'agencia_mod_cta_heading'         => "Mais pacientes e mais autoridade\n*para sua clínica ou consultório*",
        'agencia_mod_cta_text'            => "Na R8, unimos marketing digital, audiovisual e estratégias locais para transformar a\npresença da sua clínica em autoridade e gerar novos pacientes com previsibilidade.",
        'agencia_mod_cta_button_text'     => 'Quero impulsionar minha clínica com a R8',
    ));

    update_option('agencia_seed_modelo_saude_done', $seed_version);
}

/**
 * Seed do Modelo de Negócio "E-commerce" (layout do Figma). Só preenche campos vazios.
 */
add_action('admin_init', 'agencia_seed_modelo_ecommerce');
function agencia_seed_modelo_ecommerce()
{
    // Versão do seed: aumente ao adicionar campos novos (só preenche o que estiver vazio)
    $seed_version = 1;
    if (!is_admin() || (int) get_option('agencia_seed_modelo_ecommerce_done') >= $seed_version) {
        return;
    }

    $post_id = agencia_seed_modelo_post('e-commerce', 'E-commerce', 'Marketing para e-commerce com foco em ROAS e crescimento sustentável.');
    if (!$post_id) {
        return;
    }

    agencia_seed_solucao_meta($post_id, array(
        // Hero
        'agencia_mod_hero_badge'           => 'Acelere suas vendas',
        'agencia_mod_hero_title_highlight' => 'Marketing para e-commerce',
        'agencia_mod_hero_title'           => 'com foco em ROAS e crescimento sustentável',
        'agencia_mod_hero_text'            => 'Na Agência R8, unimos gestão de mídia paga, automações, criativos e suporte técnico para que seu e-commerce venda mais com previsibilidade. Também somos parceiros Tray e Nuvemshop para implementação de novas lojas.',
        'agencia_mod_hero_form_title'      => 'Quer vender mais no seu e-commerce?',
        'agencia_mod_hero_form_button'     => 'Começar agora',

        // Desafios
        'agencia_mod_desafios_title' => 'Os principais desafios de quem vende online',
        'agencia_mod_desafios_group' => array(
            array('text' => 'Dificuldade em manter um ROAS saudável.'),
            array('text' => 'Falta de gestão profissional de campanhas.'),
            array('text' => 'Pouca previsibilidade nas vendas.'),
            array('text' => 'Falta de suporte técnico e atualizações da loja.'),
            array('text' => 'Baixa retenção e relacionamento com clientes.'),
        ),

        // Como a R8 ajuda
        'agencia_mod_ajuda_badge' => 'O que entregamos',
        'agencia_mod_ajuda_title' => "Como a R8 ajuda sua loja\nvirtual a vender mais",
        'agencia_mod_ajuda_text'  => 'Soluções completas de tecnologia, mídia e automação para escalar as vendas e a rentabilidade do seu e-commerce.',
        'agencia_mod_ajuda_group' => array(
            array('title' => 'Gestão de mídia paga', 'description' => 'Google Ads, Meta Ads, TikTok Ads, LinkedIn Ads.'),
            array('title' => 'Implementação de e-commerce', 'description' => 'Parceiros Gold Tray e Nuvemshop.'),
            array('title' => 'Suporte e manutenção contínua', 'description' => 'Troca de banners, atualizações e ajustes.'),
            array('title' => 'Criação de criativos', 'description' => 'Peças visuais otimizadas para campanhas de performance.'),
            array('title' => 'Fluxos de marketing (RD Station)', 'description' => 'Recuperação de carrinho, recompra e fidelização.'),
            array('title' => 'Relacionamento com base de clientes', 'description' => 'E-mail marketing, fluxos e segmentações.'),
            array('title' => 'SEO para e-commerce', 'description' => 'Otimização técnica e de conteúdo para produtos e categorias.'),
        ),

        // Metodologia
        'agencia_mod_metodologia_badge' => 'Como funciona',
        'agencia_mod_metodologia_title' => 'Nosso jeito de gerar performance para lojas virtuais',
        'agencia_mod_metodologia_group' => array(
            array('title' => 'Diagnóstico inicial', 'description' => 'Análise da loja, métricas atuais e funil de vendas.'),
            array('title' => 'Planejamento de mídia e automações', 'description' => 'Definição de estratégias para ROAS positivo.'),
            array('title' => 'Execução e suporte', 'description' => 'Gestão de tráfego, manutenção da loja e criação de criativos.'),
            array('title' => 'Análise e otimização', 'description' => 'Relatórios periódicos + dashboards personalizados em tempo real.'),
        ),

        // Resultados (números do layout; revisar no painel)
        'agencia_mod_resultados_badge' => 'Cases',
        'agencia_mod_resultados_title' => 'Resultados reais com lojas virtuais',
        'agencia_mod_resultados_group' => agencia_seed_modelo_resultados($post_id),

        // FAQ (o layout traz só as perguntas; respostas iniciais para revisar no painel)
        'agencia_mod_faq_badge' => 'FAQ',
        'agencia_mod_faq_title' => 'Dúvidas comuns de lojistas virtuais',
        'agencia_mod_faq_group' => array(
            array(
                'question' => 'Vocês só fazem gestão de tráfego para e-commerce?',
                'answer'   => 'Não. Além da gestão de mídia paga, implementamos lojas, damos suporte e manutenção, criamos criativos, estruturamos fluxos de automação e trabalhamos SEO para e-commerce.',
            ),
            array(
                'question' => 'Quais plataformas vocês implementam?',
                'answer'   => 'Somos parceiros Gold Tray e Nuvemshop e implementamos novas lojas nessas plataformas, com tema pronto ou personalizado.',
            ),
            array(
                'question' => 'Vocês também criam banners e criativos?',
                'answer'   => 'Sim. Criamos peças visuais otimizadas para campanhas de performance e cuidamos da troca de banners e ajustes da loja no suporte contínuo.',
            ),
            array(
                'question' => 'Vocês trabalham automação para e-commerce?',
                'answer'   => 'Sim. Estruturamos fluxos no RD Station para recuperação de carrinho, recompra e fidelização, além de e-mail marketing e segmentações da base de clientes.',
            ),
            array(
                'question' => 'Como vocês acompanham resultados?',
                'answer'   => 'Com relatórios periódicos e dashboards personalizados em tempo real, acompanhando ROAS, vendas e os principais indicadores da loja.',
            ),
        ),

        // CTA
        'agencia_mod_cta_empresas_numero' => '+100',
        'agencia_mod_cta_empresas_texto'  => 'Empresas impactadas',
        'agencia_mod_cta_heading'         => "*Seu e-commerce com ROAS positivo*\ne vendas em escala",
        'agencia_mod_cta_text'            => "Com a R8, sua loja virtual não depende de achismos: trabalhamos com performance real,\nrelatórios claros e estratégias que aumentam vendas e reduzem CAC.",
        'agencia_mod_cta_button_text'     => 'Quero performance no meu e-commerce',
    ));

    update_option('agencia_seed_modelo_ecommerce_done', $seed_version);
}