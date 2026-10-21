<?php
/*
* Template Name: A Agencia

*/

get_header();

$prefix = 'agencia_pag_';
$post_id = get_the_ID();

// Buscar campos do CMB2 com fallback para os culturaes do Seed (garante que não fique vazio)
$badge       = get_post_meta($post_id, $prefix . 'badge', true);
if (empty($badge)) {
    $badge = 'A Agência';
}

$title       = get_post_meta($post_id, $prefix . 'title', true);
if (empty($title)) {
    $title = 'Muito além de uma agência <br> de marketing digital';
}

$subtitle    = get_post_meta($post_id, $prefix . 'subtitle', true);
if (empty($subtitle)) {
    $subtitle = 'Unimos pessoas, tecnologia e processos para impulsionar o crescimento dos nossos clientes. Criamos estratégias inteligentes, transparentes e orientadas a resultados que fortalecem marcas e constroem relações duradouras.';
}

// Seção O Que Nos Move
$move_prefix = 'agencia_pag_move_';
$move_title = get_post_meta($post_id, $move_prefix . 'title', true);
if (empty($move_title)) {
    $move_title = 'O que nos move';
}

$move_items = get_post_meta($post_id, $move_prefix . 'itens_grupo', true);
if (empty($move_items) || !is_array($move_items)) {
    $move_items = array(
        array('texto' => 'Transformar pessoas e empresas com relações verdadeiras e colaboração real.'),
        array('texto' => 'Unir Pessoas, Tecnologia e Processos para potencializar resultados.'),
        array('texto' => 'Construir parcerias duradouras, guiadas por confiança e propósito.'),
        array('texto' => 'Ampliar a visão dos clientes sobre o potencial dos seus negócios.'),
        array('texto' => 'Criar estratégias sob medida que elevam marcas e impulsionam crescimento.'),
        array('texto' => 'Entregar impacto sustentável, combinando inovação, clareza e performance.')
    );
}

// Seção Impulsionar Banner
$imp_prefix = 'agencia_pag_impulsionar_';
$imp_title = get_post_meta($post_id, $imp_prefix . 'title', true);
if (empty($imp_title)) {
    $imp_title = 'Impulsionamos Negócios B2B e e-commerce com Marketing e Tecnologia Inteligentes';
}

$imp_subtitle = get_post_meta($post_id, $imp_prefix . 'subtitle', true);
if (empty($imp_subtitle)) {
    $imp_subtitle = 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável';
}

$imp_cta_text = get_post_meta($post_id, $imp_prefix . 'cta_text', true);
if (empty($imp_cta_text)) {
    $imp_cta_text = 'Quero gerar mais resultados';
}

$imp_cta_link = get_post_meta($post_id, $imp_prefix . 'cta_link', true);
if (empty($imp_cta_link)) {
    $imp_cta_link = '#';
}

$imp_image_id = get_post_meta($post_id, $imp_prefix . 'image_id', true);
$imp_image_url = '';
$imp_width = '';
$imp_height = '';
if ($imp_image_id) {
    $imp_image_url = wp_get_attachment_image_url($imp_image_id, 'full');
    $meta = wp_get_attachment_metadata($imp_image_id);
    if ($meta) {
        $imp_width = isset($meta['width']) ? $meta['width'] : '';
        $imp_height = isset($meta['height']) ? $meta['height'] : '';
    }
}

$imp_dim_attr = '';
if ($imp_width && $imp_height) {
    $imp_dim_attr = ' width="' . esc_attr($imp_width) . '" height="' . esc_attr($imp_height) . '"';
}

// Seção Certificações (buscando dados da Home)
$home_id = get_option('page_on_front');
if (!$home_id) {
    $home_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-home.php',
        'number'     => 1
    ));
    if (!empty($home_pages)) {
        $home_id = $home_pages[0]->ID;
    }
}

$prefix_cert = 'agencia_certificacoes_';
$cert_title = get_post_meta($home_id, $prefix_cert . 'title', true);
if (empty($cert_title)) {
    $cert_title = 'Parcerias e certificações que fortalecem nossa entrega';
}
$cert_logos = get_post_meta($home_id, $prefix_cert . 'logos', true);

// Seção Essência
$ess_prefix = 'agencia_pag_essencia_';
$ess_badge = get_post_meta($post_id, $ess_prefix . 'badge', true);
if (empty($ess_badge)) {
    $ess_badge = 'Por que R8';
}

$ess_title = get_post_meta($post_id, $ess_prefix . 'title', true);
if (empty($ess_title)) {
    $ess_title = 'A essência por trás do nosso nome';
}

$ess_desc = get_post_meta($post_id, $ess_prefix . 'description', true);
if (empty($ess_desc)) {
    $ess_desc = 'O R representa nossos dois pilares — Resultados e Relacionamentos, que orientam nosso jeito de trabalhar. Já o 8 simboliza o elo infinito entre agência e cliente, refletindo nossa visão de parceria contínua. R8 sintetiza, em um único nome, nossa cultura, nosso propósito e a forma como construímos cada projeto.';
}

$ess_image_id = get_post_meta($post_id, $ess_prefix . 'image_id', true);
$ess_image_url = '';
$ess_width = '';
$ess_height = '';
if ($ess_image_id) {
    $ess_image_url = wp_get_attachment_image_url($ess_image_id, 'full');
    $meta = wp_get_attachment_metadata($ess_image_id);
    if ($meta) {
        $ess_width = isset($meta['width']) ? $meta['width'] : '';
        $ess_height = isset($meta['height']) ? $meta['height'] : '';
    }
}

$ess_dim_attr = '';
if ($ess_width && $ess_height) {
    $ess_dim_attr = ' width="' . esc_attr($ess_width) . '" height="' . esc_attr($ess_height) . '"';
}

// Seção Estrutura
$est_prefix = 'agencia_pag_estrutura_';
$est_badge = get_post_meta($post_id, $est_prefix . 'badge', true);
if (empty($est_badge)) {
    $est_badge = 'Nossa Estrutura';
}

$est_title = get_post_meta($post_id, $est_prefix . 'title', true);
if (empty($est_title)) {
    $est_title = 'Onde ideias viram performance';
}

$est_desc = get_post_meta($post_id, $est_prefix . 'description', true);
if (empty($est_desc)) {
    $est_desc = 'Nosso espaço foi pensado para integrar criatividade, estratégia e dados. Aqui, nossa equipe conecta marketing, tecnologia and vendas em um ambiente colaborativo e focado em resultados.';
}

$est_image_id = get_post_meta($post_id, $est_prefix . 'image_id', true);
$est_image_url = '';
$est_width = '';
$est_height = '';
if ($est_image_id) {
    $est_image_url = wp_get_attachment_image_url($est_image_id, 'full');
    $meta = wp_get_attachment_metadata($est_image_id);
    if ($meta) {
        $est_width = isset($meta['width']) ? $meta['width'] : '';
        $est_height = isset($meta['height']) ? $meta['height'] : '';
    }
}

$est_dim_attr = '';
if ($est_width && $est_height) {
    $est_dim_attr = ' width="' . esc_attr($est_width) . '" height="' . esc_attr($est_height) . '"';
}

// Seção Propósito
$prop_prefix = 'agencia_pag_proposito_';
$prop_badge = get_post_meta($post_id, $prop_prefix . 'badge', true);
if (empty($prop_badge)) {
    $prop_badge = 'Nosso Propósito';
}

$prop_title = get_post_meta($post_id, $prop_prefix . 'title', true);
if (empty($prop_title)) {
    $prop_title = 'Transformar negócios em histórias de crescimento';
}

$prop_desc = get_post_meta($post_id, $prop_prefix . 'description', true);
if (empty($prop_desc)) {
    $prop_desc = 'Nosso propósito é transformar pessoas e empresas por meio de três pilares: Pessoas, Tecnologia e Processos. Cada estratégia é feita sob medida para garantir resultados mensuráveis e sustentáveis.';
}

$prop_image_id = get_post_meta($post_id, $prop_prefix . 'image_id', true);
$prop_image_url = '';
$prop_width = '';
$prop_height = '';
if ($prop_image_id) {
    $prop_image_url = wp_get_attachment_image_url($prop_image_id, 'full');
    $meta = wp_get_attachment_metadata($prop_image_id);
    if ($meta) {
        $prop_width = isset($meta['width']) ? $meta['width'] : '';
        $prop_height = isset($meta['height']) ? $meta['height'] : '';
    }
}

$prop_dim_attr = '';
if ($prop_width && $prop_height) {
    $prop_dim_attr = ' width="' . esc_attr($prop_width) . '" height="' . esc_attr($prop_height) . '"';
}

// Seção Nossa Cultura
$cult_prefix = 'agencia_pag_cultura_';
$cult_badge = get_post_meta($post_id, $cult_prefix . 'badge', true);
if (empty($cult_badge)) {
    $cult_badge = 'Nossa Cultura';
}

$cult_title = get_post_meta($post_id, $cult_prefix . 'title', true);
if (empty($cult_title)) {
    $cult_title = 'Como pensamos e trabalhamos';
}

$cult_desc = get_post_meta($post_id, $cult_prefix . 'description', true);
if (empty($cult_desc)) {
    $cult_desc = 'Soluções completas de marketing, vendas, tecnologia e design que geram resultados mensuráveis e escalam negócios de forma sustentável';
}

$cult_items = get_post_meta($post_id, $cult_prefix . 'itens_grupo', true);
if (empty($cult_items) || !is_array($cult_items)) {
    $cult_items = array(
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
}

// Seção Soluções
$sol_prefix = 'agencia_pag_solucoes_';
$sol_title = get_post_meta($post_id, $sol_prefix . 'title', true);
if (empty($sol_title)) {
    $sol_title = '360° de verdade!';
}

$sol_desc = get_post_meta($post_id, $sol_prefix . 'description', true);
if (empty($sol_desc)) {
    $sol_desc = 'Temos soluções completas para gerar resultados reais';
}

$sol_items = get_post_meta($post_id, $sol_prefix . 'itens_grupo', true);
if (empty($sol_items) || !is_array($sol_items)) {
    $sol_items = array(
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
}
?>

<section class="hero hero-agencia">
    <div class="hero-agencia-bg">
        <svg width="1350" height="907" viewBox="0 0 1350 907" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M608.786 527.906C237.918 271.329 -33.1731 20.6111 3.28632 -32.0891C39.7458 -84.7893 369.95 80.485 740.817 337.061C1111.68 593.638 1382.78 844.356 1346.32 897.056C1309.86 949.756 979.653 784.482 608.786 527.906Z" fill="white" fill-opacity="0.21" />
        </svg>
    </div>
    <div class="container">
        <div class="badge-section">
            <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="3" cy="3" r="3" fill="#FFE700" />
            </svg>
            <?php echo esc_html($badge); ?>
        </div>
        <div class="hero-txt">
            <h1><?php echo wp_kses_post($title); ?></h1>
            <p><?php echo esc_html($subtitle); ?></p>
            <div class="btn-hero">
                <a href="" class="click">
                    Ver mais
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_13507_1498" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="6" y="4" width="12" height="16">
                            <path d="M18 14L12 20L6 14L7.45 12.6L11 16.15L11 4L13 4L13 16.15L16.55 12.6L18 14Z" fill="#1C1B1F" />
                        </mask>
                        <g mask="url(#mask0_13507_1498)">
                            <rect width="24" height="24" fill="#D9D9D9" />
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="hero-image">
            <div class="mosaico-agencia">
                <?php
                $mosaico_imagens = get_post_meta($post_id, $prefix . 'mosaico_grupo', true);
                if (!empty($mosaico_imagens) && is_array($mosaico_imagens)) :
                    $counter = 1;
                    foreach ($mosaico_imagens as $item) :
                        // Tenta obter o URL diretamente
                        $image_url = isset($item['imagem']) ? $item['imagem'] : '';

                        // Caso o banco guarde apenas o ID (de salvamentos anteriores)
                        if (is_numeric($image_url)) {
                            $image_id = $image_url;
                            $image_url = wp_get_attachment_image_url($image_id, 'full');
                        } else {
                            $image_id = isset($item['imagem_id']) ? $item['imagem_id'] : 0;
                        }

                        if ($image_url) :
                            $width = '';
                            $height = '';
                            if ($image_id) {
                                $meta = wp_get_attachment_metadata($image_id);
                                if ($meta) {
                                    $width = isset($meta['width']) ? $meta['width'] : '';
                                    $height = isset($meta['height']) ? $meta['height'] : '';
                                }
                            }

                            $dim_attr = '';
                            if ($width && $height) {
                                $dim_attr = ' width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"';
                            }

                            $args_str = 'class="mosaico-img-' . $counter . '" decoding="async"';

                            // Foco em PageSpeed: A dobra inicial (LCP) precisa carregar imediatamente (eager) e com alta prioridade
                            if ($counter <= 2) {
                                $args_str .= ' loading="eager" fetchpriority="high"';
                            } else {
                                $args_str .= ' loading="lazy"';
                            }

                            echo '<img src="' . esc_url($image_url) . '"' . $dim_attr . agencia_srcset_attr($image_id) . ' ' . $args_str . ' alt="">';
                        endif;
                        $counter++;
                    endforeach;
                else:
                    // Exibe tags vazias com o contador na classe como fallback (sementes padrão)
                    for ($i = 1; $i <= 4; $i++) :
                        echo '<img src="" class="mosaico-img-' . $i . '" alt="" decoding="async">';
                    endfor;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<section class="move">
    <div class="container">
        <h2><?php echo esc_html($move_title); ?></h2>
    </div>

    <div class="container">
        <div class="move-grid">
            <?php foreach ($move_items as $item) :
                $texto = isset($item['texto']) ? $item['texto'] : '';
                $image_id = isset($item['imagem']) ? $item['imagem'] : 0;

                // Trata caso de o banco guardar a URL string ao invés de ID
                if ($image_id && !is_numeric($image_id)) {
                    $image_id = attachment_url_to_postid($image_id);
                }

                $image_url = '';
                $width = '';
                $height = '';

                if ($image_id) {
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    $meta = wp_get_attachment_metadata($image_id);
                    if ($meta) {
                        $width = isset($meta['width']) ? $meta['width'] : '';
                        $height = isset($meta['height']) ? $meta['height'] : '';
                    }
                }

                $dim_attr = '';
                if ($width && $height) {
                    $dim_attr = ' width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"';
                }

                if ($texto || $image_url) :
            ?>
                    <div class="move-item">
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" <?php echo $dim_attr . agencia_srcset_attr($image_id); ?> alt="" decoding="async" loading="lazy">
                        <?php else : ?>
                            <img src="" alt="" decoding="async" loading="lazy">
                        <?php endif; ?>

                        <?php if ($texto) : ?>
                            <p><?php echo esc_html($texto); ?></p>
                        <?php endif; ?>
                    </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
</section>

<section class="impulsionar-banner">
    <div class="container">
        <div class="box-impulsionar-banner">
            <div class="left-img-impulsionar">
                <div class="img-banner-impulsionar">
                    <?php if ($imp_image_url) : ?>
                        <img src="<?php echo esc_url($imp_image_url); ?>" <?php echo $imp_dim_attr . agencia_srcset_attr($imp_image_id); ?> alt="<?php echo esc_attr(wp_strip_all_tags($imp_title)); ?>" decoding="async" loading="lazy">
                    <?php else : ?>
                        <img src="" alt="" decoding="async" loading="lazy">
                    <?php endif; ?>
                </div>
            </div>
            <div class="right-txt-impulsionar">
                <div class="title-section title-white">
                    <h2><?php echo wp_kses_post($imp_title); ?></h2>
                    <p><?php echo esc_html($imp_subtitle); ?></p>
                </div>
                <div class="btn-impulsionar-banner">
                    <a href="<?php echo esc_url($imp_cta_link); ?>" class="btn-primary btn-black">
                        <?php echo esc_html($imp_cta_text); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_13507_3307" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="14" height="14">
                                <path d="M13.4793 10.8333H3.3335V9.16665H13.4793L8.81266 4.49998L10.0002 3.33331L16.6668 9.99998L10.0002 16.6666L8.81266 15.5L13.4793 10.8333Z" fill="#1C1B1F" />
                            </mask>
                            <g mask="url(#mask0_13507_3307)">
                                <rect width="20" height="20" fill="#EDECE6" />
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="certificacoes">
    <div class="container">
        <?php if ($cert_title) : ?>
            <div class="title-section title-white">
                <h2><?php echo esc_html($cert_title); ?></h2>
            </div>
        <?php endif; ?>
        <?php if (!empty($cert_logos)) : ?>
            <div class="box-logos-brand">
                <?php foreach ($cert_logos as $logo_id => $logo_url) : ?>
                    <?php
                    echo wp_get_attachment_image($logo_id, 'full', false, array(
                        'loading' => 'lazy',
                        'alt'     => '',
                    ));
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="essencia">
    <div class="container">
        <div class="box-txt-essencia">
            <div class="box left-essencia">
                <?php if ($ess_badge) : ?>
                    <div class="badge-section badge-white">
                        <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="3" cy="3" r="3" fill="#FFE700" />
                        </svg>
                        <?php echo esc_html($ess_badge); ?>
                    </div>
                <?php endif; ?>
                <div class="title-section title-white">
                    <?php if ($ess_title) : ?><h2><?php echo esc_html($ess_title); ?></h2><?php endif; ?>
                    <?php if ($ess_desc) : ?><p><?php echo wp_kses_post($ess_desc); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="box right-essencia">
                <?php if ($ess_image_url) : ?>
                    <img src="<?php echo esc_url($ess_image_url); ?>" <?php echo $ess_dim_attr . agencia_srcset_attr($ess_image_id); ?> alt="<?php echo esc_attr($ess_title); ?>" decoding="async" loading="lazy">
                <?php else : ?>
                    <img src="" alt="" decoding="async" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="estrutura essencia">
    <div class="container">
        <div class="box-txt-essencia">
            <div class="box right-essencia">
                <?php if ($est_image_url) : ?>
                    <img src="<?php echo esc_url($est_image_url); ?>" <?php echo $est_dim_attr . agencia_srcset_attr($est_image_id); ?> alt="<?php echo esc_attr($est_title); ?>" decoding="async" loading="lazy">
                <?php else : ?>
                    <img src="" alt="" decoding="async" loading="lazy">
                <?php endif; ?>
            </div>
            <div class="box left-essencia">
                <?php if ($est_badge) : ?>
                    <div class="badge-section badge-white">
                        <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="3" cy="3" r="3" fill="white" />
                        </svg>
                        <?php echo esc_html($est_badge); ?>
                    </div>
                <?php endif; ?>

                <div class="title-section title-white">
                    <?php if ($est_title) : ?><h2><?php echo esc_html($est_title); ?></h2><?php endif; ?>
                    <?php if ($est_desc) : ?><p><?php echo wp_kses_post($est_desc); ?></p><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="essencia proposito">
    <div class="container">
        <div class="box-txt-essencia">
            <div class="box left-essencia">
                <?php if ($prop_badge) : ?>
                    <div class="badge-section badge-white">
                        <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="3" cy="3" r="3" fill="#FFE700" />
                        </svg>
                        <?php echo esc_html($prop_badge); ?>
                    </div>
                <?php endif; ?>

                <div class="title-section title-white">
                    <?php if ($prop_title) : ?><h2><?php echo esc_html($prop_title); ?></h2><?php endif; ?>
                    <?php if ($prop_desc) : ?><p><?php echo wp_kses_post($prop_desc); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="box right-essencia">
                <?php if ($prop_image_url) : ?>
                    <img src="<?php echo esc_url($prop_image_url); ?>" <?php echo $prop_dim_attr . agencia_srcset_attr($prop_image_id); ?> alt="<?php echo esc_attr($prop_title); ?>" decoding="async" loading="lazy">
                <?php else : ?>
                    <img src="" alt="" decoding="async" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="nossa-cultura">
    <div class="container">
        <?php if ($cult_badge) : ?>
            <div class="badge-section badge-white">
                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="3" cy="3" r="3" fill="#FFE700" />
                </svg>
                <?php echo esc_html($cult_badge); ?>
            </div>
        <?php endif; ?>

        <div class="title-section title-white">
            <?php if ($cult_title) : ?><h2><?php echo esc_html($cult_title); ?></h2><?php endif; ?>
            <?php if ($cult_desc) : ?><p><?php echo esc_html($cult_desc); ?></p><?php endif; ?>
        </div>

        <?php if (!empty($cult_items)) : ?>
            <div class="box-items-cultura">
                <?php foreach ($cult_items as $item) :
                    $titulo = isset($item['titulo']) ? $item['titulo'] : '';
                    $descricao = isset($item['descricao']) ? $item['descricao'] : '';
                    if ($titulo || $descricao) :
                ?>
                        <div class="cultura-item">
                            <div class="cultura-icon">
                                <svg width="78" height="78" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M75.6102 49.0083C75.0824 50.953 58.127 48.0046 37.7718 42.4287C17.4165 36.8528 1.3182 30.7469 1.846 28.8022C2.3738 26.8576 19.3291 29.806 39.6844 35.3819C60.0397 40.9577 76.138 47.0637 75.6102 49.0083Z" stroke="#FFE700" />
                                    <path d="M71.7507 58.2538C70.1673 60.9814 54.0843 54.5258 35.8591 43.8472C17.634 33.1687 4.12223 22.2841 5.7057 19.5565C7.28917 16.829 23.3722 23.2846 41.5973 33.9631C59.8225 44.6417 73.3342 55.5263 71.7507 58.2538Z" stroke="#FFE700" />
                                    <path d="M63.1719 68.4336C59.7125 71.3238 45.9504 60.4389 32.4598 44.1422C18.9693 27.8455 10.8249 12.2671 14.2843 9.37689C17.7437 6.48665 31.5058 17.3715 44.9964 33.6683C58.4869 49.965 66.6313 65.5433 63.1719 68.4336Z" stroke="#FFE700" />
                                    <path d="M51.6449 75.0516C46.8049 76.7972 37.087 62.0173 29.9582 42.0681C22.8294 22.1188 20.9712 4.5043 25.8113 2.7587C30.6514 1.0131 40.3693 15.793 47.4981 35.7422C54.6269 55.6915 56.485 73.306 51.6449 75.0516Z" stroke="#FFE700" />
                                    <path d="M38.561 77.3095C33.4294 77.287 29.3382 60.0595 29.4306 38.8639C29.523 17.6682 33.7642 0.477437 38.8959 0.500022C44.0276 0.522607 48.1187 17.7501 48.0263 38.9457C47.9339 60.1413 43.6927 77.3321 38.561 77.3095Z" stroke="#FFE700" />
                                    <path d="M25.4952 74.936C20.6706 73.1477 22.6829 55.5503 29.9861 35.6648C37.2893 15.7793 47.1362 1.08589 51.9608 2.87419C56.7854 4.66249 54.7731 22.2599 47.4699 42.1454C40.1667 62.0309 30.3198 76.7243 25.4952 74.936Z" stroke="#FFE700" />
                                    <path d="M14.0267 68.2163C10.5927 65.2956 18.8732 49.7898 32.5059 33.613C46.1387 17.4361 59.9956 6.67325 63.4295 9.59394C66.8635 12.5146 58.583 28.0204 44.9503 44.1973C31.3175 60.3742 17.4607 71.137 14.0267 68.2163Z" stroke="#FFE700" />
                                    <path d="M5.53737 57.9612C3.97784 55.2198 17.5844 44.455 35.9023 33.9379C54.2203 23.4208 70.3592 17.1076 71.9187 19.849C73.4782 22.5905 59.8717 33.3553 41.5537 43.8724C23.2358 54.3894 7.09689 60.7027 5.53737 57.9612Z" stroke="#FFE700" />
                                    <path d="M1.75891 48.6817C1.24815 46.7325 17.3993 40.7691 37.8026 35.3733C58.2059 29.9775 75.1864 27.1791 75.6971 29.1283C76.2079 31.0775 60.0567 37.041 39.6534 42.4367C19.2502 47.8325 2.26966 50.6309 1.75891 48.6817Z" stroke="#FFE700" />
                                    <path d="M76.9564 39.0741C76.9561 39.1357 59.8259 39.1102 38.7277 39.017C17.6295 38.9238 0.499731 38.7978 0.5 38.7363C0.500269 38.6748 17.6305 38.7002 38.7287 38.7935C59.8269 38.8867 76.9567 39.0127 76.9564 39.0741Z" stroke="#FFE700" />
                                </svg>
                            </div>
                            <div class="cultura-content">
                                <?php if ($titulo) : ?><h3><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                                <?php if ($descricao) : ?><p><?php echo esc_html($descricao); ?></p><?php endif; ?>
                            </div>
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="solucoes">
    <div class="container">
        <div class="title-section title-white ">
            <?php if ($sol_title) : ?><h2><?php echo esc_html($sol_title); ?></h2><?php endif; ?>
            <?php if ($sol_desc) : ?><p><?php echo esc_html($sol_desc); ?></p><?php endif; ?>
        </div>

        <?php if (!empty($sol_items)) : ?>
            <div class="modelo-grid">
                <?php foreach ($sol_items as $item) : 
                    $titulo = isset($item['titulo']) ? $item['titulo'] : '';
                    $descricao = isset($item['descricao']) ? $item['descricao'] : '';
                    if ($titulo || $descricao) :
                ?>
                    <div class="modelo-card">
                        <div class="modelo-icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_12230_2115" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2" y="2" width="36" height="36">
                                    <path d="M5 25V27.5H10.7325L2.5 35.7325L4.2675 37.5L12.5 29.2675V35H15V25H5Z" fill="black" />
                                    <path d="M30.0001 26.25H32.5001V32.5H30.0001V26.25Z" fill="black" />
                                    <path d="M25.0001 20H27.5001V32.5H25.0001V20Z" fill="black" />
                                    <path d="M20 22.5H22.5V32.5H20V22.5Z" fill="black" />
                                    <path d="M35 2.5H5C4.33716 2.50066 3.70166 2.76427 3.23296 3.23296C2.76427 3.70166 2.50066 4.33716 2.5 5V20H5V16.25H35.0012L35.0025 35H20V37.5H35C35.6628 37.4991 36.2981 37.2354 36.7668 36.7668C37.2354 36.2981 37.4991 35.6628 37.5 35V5C37.4992 4.33719 37.2356 3.70175 36.7669 3.23307C36.2982 2.7644 35.6628 2.50076 35 2.5ZM15 13.75H5V5H15V13.75ZM17.5 13.75V5H35L35.0009 13.75H17.5Z" fill="black" />
                                </mask>
                                <g mask="url(#mask0_12230_2115)">
                                    <path d="M0 0H40V40H0V0Z" fill="#292928" />
                                </g>
                            </svg>
                        </div>
                        <?php if ($titulo) : ?><h3><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                        <?php if ($descricao) : ?><p><?php echo esc_html($descricao); ?></p><?php endif; ?>
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>