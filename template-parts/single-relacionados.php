<?php
/**
 * Outros itens do mesmo CPT
 *
 * $args['title']     — título da seção
 * $args['tax_query'] — tax_query opcional para priorizar itens da mesma área
 */

$query_args = array(
    'post_type'           => get_post_type(),
    'posts_per_page'      => 3,
    'post__not_in'        => array(get_the_ID()),
    'orderby'             => array('menu_order' => 'ASC', 'date' => 'DESC'),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
);

if (!empty($args['tax_query'])) {
    $query_args['tax_query'] = $args['tax_query'];
}

$relacionados = new WP_Query($query_args);

// Sem itens na mesma área: busca qualquer item do CPT
if (!$relacionados->have_posts() && !empty($args['tax_query'])) {
    unset($query_args['tax_query']);
    $relacionados = new WP_Query($query_args);
}

if ($relacionados->have_posts()) : ?>
    <section class="single-relacionados">
        <div class="container">
            <div class="title-section title-white">
                <h2><?php echo esc_html($args['title']); ?></h2>
            </div>
            <div class="grid-cpt">
                <?php while ($relacionados->have_posts()) : $relacionados->the_post();
                    get_template_part('template-parts/card-cpt');
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
