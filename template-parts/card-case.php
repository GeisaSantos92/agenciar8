<?php

/**
 * Card da listagem de Cases
 */

$post_id    = get_the_ID();
$areas      = agencia_case_areas($post_id);
$segmento   = get_post_meta($post_id, 'agencia_case_segmento', true);
$icone_id   = get_post_meta($post_id, 'agencia_case_icone_id', true);
$resultados = get_post_meta($post_id, 'agencia_case_resultados', true);
$resultados = is_array($resultados) ? array_slice(array_filter($resultados, function ($r) {
    return !empty($r['number']);
}), 0, 3) : array();
$img_dir = get_template_directory_uri() . '/assets/images/cases';
?>

<a href="<?php the_permalink(); ?>" class="card-case" data-areas="<?php echo esc_attr(implode(' ', array_keys($areas))); ?>">
    <div class="card-case__imagem">
        <?php if (has_post_thumbnail()) :
            the_post_thumbnail('medium_large', array('loading' => 'lazy', 'sizes' => '(max-width: 640px) 100vw, 420px'));
        endif; ?>
        <?php if ($areas) : ?>
            <span class="card-case__tag"><?php echo esc_html(reset($areas)); ?></span>
        <?php endif; ?>
    </div>

    <div class="card-case__txt">
        <?php if ($segmento) : ?>
            <div class="card-case__segmento">
                <span class="card-case__icone">
                    <?php if ($icone_id) :
                        echo wp_get_attachment_image($icone_id, 'thumbnail', false, array('alt' => '', 'loading' => 'lazy', 'width' => 16, 'height' => 16));
                    else : ?>
                        <img class="card-case__icone-padrao" src="<?php echo esc_url($img_dir . '/icone-segmento.svg'); ?>" alt="" width="16" height="16" loading="lazy">
                    <?php endif; ?>
                </span>
                <?php echo esc_html($segmento); ?>
            </div>
        <?php endif; ?>

        <h2 class="card-case__titulo"><?php echo agencia_sem_quebra_hifen(esc_html(get_the_title())); ?></h2>

        <?php if (has_excerpt()) : ?>
            <p class="card-case__resumo"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php endif; ?>

        <?php if ($resultados) : ?>
            <div class="card-case__numeros">
                <?php foreach ($resultados as $resultado) : ?>
                    <div>
                        <strong><?php echo esc_html($resultado['number']); ?></strong>
                        <?php if (!empty($resultado['label'])) : ?><span><?php echo esc_html($resultado['label']); ?></span><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</a>
