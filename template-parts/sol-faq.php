<?php

/**
 * FAQ em acordeão + schema FAQPage (singles de Soluções e Modelos de Negócio)
 *
 * Args: badge, title, items (array de question/answer)
 */

$args = wp_parse_args($args, array(
    'badge' => '',
    'title' => '',
    'items' => array(),
));

$faq_items = is_array($args['items']) ? array_filter($args['items'], function ($f) {
    return !empty($f['question']) && !empty($f['answer']);
}) : array();

if (!$faq_items) {
    return;
}

$img_dir = get_template_directory_uri() . '/assets/images/solucoes';
?>

<section class="faq-solucao">
    <div class="container">
        <?php if ($args['badge']) : ?>
            <div class="badge-section badge-white">
                <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="3" cy="3" r="3" fill="#FFE700" />
                </svg>
                <?php echo esc_html($args['badge']); ?>
            </div>
        <?php endif; ?>
        <?php if ($args['title']) : ?>
            <div class="title-section title-white">
                <h2><?php echo agencia_solucao_titulo_html($args['title']); ?></h2>
            </div>
        <?php endif; ?>

        <div class="lista-faq">
            <?php foreach ($faq_items as $faq) : ?>
                <details class="faq-item">
                    <summary>
                        <h3><?php echo esc_html($faq['question']); ?></h3>
                        <img src="<?php echo esc_url($img_dir . '/faq-chevron.svg'); ?>" alt="" width="24" height="24">
                    </summary>
                    <div class="faq-item__resposta">
                        <?php echo wpautop(esc_html($faq['answer'])); ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script type="application/ld+json">
    <?php
    $faq_schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array(),
    );
    foreach ($faq_items as $faq) {
        $faq_schema['mainEntity'][] = array(
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ),
        );
    }
    echo wp_json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>
</script>
