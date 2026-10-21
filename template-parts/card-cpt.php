<?php
/**
 * Card de listagem dos CPTs (relacionados e arquivos)
 */
?>
<a href="<?php the_permalink(); ?>" class="card-cpt">
    <div class="card-cpt__image">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium_large', array(
                'loading'  => 'lazy',
                'decoding' => 'async',
                'alt'      => esc_attr(get_the_title()),
            )); ?>
        <?php endif; ?>
    </div>
    <div class="card-cpt__txt">
        <h3><?php the_title(); ?></h3>
        <?php if (has_excerpt()) : ?>
            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
        <?php endif; ?>
        <span class="card-cpt__link">Saiba mais
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M13.4793 10.8335H3.3335V9.16683H13.4793L8.81266 4.50016L10.0002 3.3335L16.6668 10.0002L10.0002 16.6668L8.81266 15.5002L13.4793 10.8335Z" fill="currentColor" />
            </svg>
        </span>
    </div>
</a>
