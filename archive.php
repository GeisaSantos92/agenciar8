<?php
get_header();

$archive_title = is_post_type_archive() ? post_type_archive_title('', false) : single_term_title('', false);
$archive_desc  = get_the_archive_description();
?>

<section class="hero-single hero-archive">
    <div class="container">
        <div class="hero-txt">
            <h1><?php echo esc_html($archive_title); ?></h1>
            <?php if ($archive_desc) : ?>
                <?php echo wp_kses_post($archive_desc); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="single-relacionados archive-lista">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="grid-cpt">
                <?php while (have_posts()) : the_post();
                    get_template_part('template-parts/card-cpt');
                endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'prev_text' => 'Anterior',
                'next_text' => 'Próxima',
            )); ?>
        <?php else : ?>
            <p class="archive-vazio">Nenhum conteúdo publicado ainda.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
