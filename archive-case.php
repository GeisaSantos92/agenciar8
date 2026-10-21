<?php
get_header();

$img_dir   = get_template_directory_uri() . '/assets/images';
$hero_text = agencia_cases_opcao('hero_text');
$ver_mais  = agencia_cases_opcao('hero_ver_mais');

// Filtros: todas as áreas de Soluções (como no layout), na ordem do menu
$filtros = array();
$areas   = get_terms(array('taxonomy' => 'area_solucao', 'hide_empty' => true));
if (!is_wp_error($areas)) {
    foreach ($areas as $area) {
        $filtros[$area->slug] = $area->name;
    }
}
$filtros = agencia_ordenar_areas($filtros);
?>

<section class="hero-cases">
    <div class="hero-solucao__brilho" aria-hidden="true">
        <img src="<?php echo esc_url($img_dir . '/solucoes/brilho.svg'); ?>" alt="" width="1606" height="1205">
    </div>
    <div class="container">
        <?php if (agencia_cases_opcao('hero_badge')) : ?>
            <div class="badge-section">
                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="3" cy="3" r="3" fill="#FFE700" />
                </svg>
                <?php echo esc_html(agencia_cases_opcao('hero_badge')); ?>
            </div>
        <?php endif; ?>
        <h1>
            <?php if (agencia_cases_opcao('hero_title')) :
                echo agencia_solucao_cta_heading_html(agencia_cases_opcao('hero_title'));
            else :
                post_type_archive_title();
            endif; ?>
        </h1>
        <?php if ($hero_text) : ?>
            <p><?php echo nl2br(esc_html($hero_text)); ?></p>
        <?php endif; ?>
        <?php if ($ver_mais) : ?>
            <a href="#lista-cases" class="hero-cases__ver-mais">
                <?php echo esc_html($ver_mais); ?>
                <img src="<?php echo esc_url($img_dir . '/cases/seta-baixo.svg'); ?>" alt="" width="24" height="24">
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="lista-cases" id="lista-cases">
    <div class="grafismo grafismo--esquerda" aria-hidden="true">
        <span></span>
        <img src="<?php echo esc_url($img_dir . '/solucoes/linhas-esquerda.svg'); ?>" alt="" loading="lazy">
        <span></span>
    </div>
    <div class="container">
        <?php if (have_posts()) : ?>

            <?php if ($filtros) : ?>
                <div class="filtro-cases" role="group" aria-label="Filtrar cases por área">
                    <button type="button" class="filtro-cases__chip is-active" data-filtro="" aria-pressed="true">Todos</button>
                    <?php foreach ($filtros as $slug => $nome) : ?>
                        <button type="button" class="filtro-cases__chip" data-filtro="<?php echo esc_attr($slug); ?>" aria-pressed="false"><?php echo esc_html($nome); ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="grid-cases">
                <?php while (have_posts()) : the_post();
                    get_template_part('template-parts/card-case');
                endwhile; ?>
            </div>
            <p class="lista-cases__vazio" id="filtro-cases-vazio" hidden>Ainda não temos cases publicados nesta área.</p>

        <?php else : ?>
            <p class="lista-cases__vazio">Em breve, novos cases por aqui.</p>
        <?php endif; ?>
    </div>
    <div class="grafismo grafismo--direita" aria-hidden="true">
        <span></span>
        <img src="<?php echo esc_url($img_dir . '/solucoes/linhas-direita.svg'); ?>" alt="" loading="lazy">
        <span></span>
    </div>
</section>

<?php
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

get_footer();
