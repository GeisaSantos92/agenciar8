<?php

/**
 * Hero com formulário (singles de Soluções e Modelos de Negócio)
 *
 * Args: badge, highlight, title, text, form_title, form_button, form_shortcode, modelo_atual
 */

$args = wp_parse_args($args, array(
    'badge'          => '',
    'highlight'      => '',
    'title'          => '',
    'text'           => '',
    'form_title'     => '',
    'form_button'    => '',
    'form_shortcode' => '',
    'modelo_atual'   => '',
));

$post_id     = get_the_ID();
$img_dir     = get_template_directory_uri() . '/assets/images/solucoes';
$form_button = $args['form_button'] ? $args['form_button'] : 'Começar agora';
$has_form    = $args['form_title'] || $args['form_shortcode'];
$form_status = isset($_GET['form']) ? sanitize_key($_GET['form']) : '';
?>

<section class="hero-solucao<?php echo $has_form ? '' : ' hero-solucao--sem-form'; ?>">
    <div class="hero-solucao__brilho" aria-hidden="true">
        <img src="<?php echo esc_url($img_dir . '/brilho.svg'); ?>" alt="" width="1606" height="1205">
    </div>
    <div class="container">
        <div class="hero-solucao__grid">
            <div class="hero-solucao__txt">
                <?php if ($args['badge']) : ?>
                    <div class="badge-section hero-solucao__badge">
                        <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="3" cy="3" r="3" fill="#FFE700" />
                        </svg>
                        <?php echo esc_html($args['badge']); ?>
                    </div>
                <?php endif; ?>
                <h1>
                    <?php if ($args['highlight'] || $args['title']) : ?>
                        <?php if ($args['highlight']) : ?><span class="text-yellow"><?php echo agencia_sem_quebra_hifen(esc_html($args['highlight'])); ?></span><?php endif; ?>
                        <?php echo agencia_sem_quebra_hifen(esc_html($args['title'])); ?>
                    <?php else : ?>
                        <?php the_title(); ?>
                    <?php endif; ?>
                </h1>
                <?php if ($args['text']) : ?>
                    <p><?php echo wp_kses_post($args['text']); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>

            <?php if ($has_form) : ?>
                <div class="form-solucao" id="form-solucao">
                    <?php if ($args['form_title']) : ?>
                        <p class="form-solucao__titulo"><?php echo agencia_solucao_titulo_html($args['form_title']); ?></p>
                    <?php endif; ?>

                    <?php if ($args['form_shortcode']) : ?>
                        <?php echo do_shortcode($args['form_shortcode']); ?>
                    <?php else : ?>

                        <?php if ($form_status === 'enviado') : ?>
                            <p class="form-solucao__aviso form-solucao__aviso--ok" role="status">Recebemos seu contato! Em breve nossa equipe vai falar com você.</p>
                        <?php elseif ($form_status === 'erro') : ?>
                            <p class="form-solucao__aviso form-solucao__aviso--erro" role="alert">Não foi possível enviar. Confira os campos obrigatórios e tente novamente.</p>
                        <?php endif; ?>

                        <?php
                        $modelos = get_posts(array(
                            'post_type'      => 'modelo_negocio',
                            'posts_per_page' => -1,
                            'orderby'        => array('menu_order' => 'ASC', 'title' => 'ASC'),
                        ));
                        ?>
                        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                            <input type="hidden" name="action" value="agencia_form_solucao">
                            <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                            <?php wp_nonce_field('agencia_form_solucao', 'agencia_form_nonce'); ?>
                            <div class="form-solucao__hp" aria-hidden="true">
                                <label for="fs-site">Site</label>
                                <input type="text" id="fs-site" name="site" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="form-solucao__campo">
                                <label for="fs-nome">Nome</label>
                                <input type="text" id="fs-nome" name="nome" autocomplete="name">
                            </div>

                            <div class="form-solucao__duplo">
                                <div class="form-solucao__campo">
                                    <label for="fs-telefone">Telefone*</label>
                                    <input type="tel" id="fs-telefone" name="telefone" autocomplete="tel" required>
                                </div>
                                <div class="form-solucao__campo">
                                    <label for="fs-email">E-mail*</label>
                                    <input type="email" id="fs-email" name="email" autocomplete="email" required>
                                </div>
                            </div>

                            <div class="form-solucao__campo">
                                <label for="fs-empresa">Nome da empresa*</label>
                                <input type="text" id="fs-empresa" name="empresa" autocomplete="organization" required>
                            </div>

                            <?php if ($modelos) : ?>
                                <div class="form-solucao__campo form-solucao__campo--select">
                                    <label for="fs-modelo">Modelo de Negócio</label>
                                    <select id="fs-modelo" name="modelo" style="background-image:url('<?php echo esc_url($img_dir . '/icone-select.svg'); ?>')">
                                        <option value="">Selecione</option>
                                        <?php foreach ($modelos as $modelo) : ?>
                                            <option value="<?php echo esc_attr($modelo->post_title); ?>" <?php selected($args['modelo_atual'], $modelo->post_title); ?>><?php echo esc_html($modelo->post_title); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <button type="submit" class="btn-primary form-solucao__botao"><?php echo esc_html($form_button); ?></button>

                            <label class="form-solucao__aceite">
                                <input type="checkbox" name="aceite" value="1">
                                <span>Ao enviar, concordo em receber comunicações da Agência R8</span>
                            </label>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
