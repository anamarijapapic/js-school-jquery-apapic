<?php

/** @var WP_Post $post */
$post = $args['post'];

$tags = get_the_terms( $post, 'post_tag' ) ? get_the_terms( $post, 'post_tag' ) : [];

?>

<div class="row my-5">
    <div class="col-xs-12">
        <h2><?php echo esc_html( get_the_title( $post ) ); ?></h2>
        <hr/>
    </div>
    <div class="col-md-9">
        <p class="lh-lg"><?php echo get_the_content( null, false, $post ); ?></p>
        <?php if ( $tags ) : ?>
            <div class="hstack gap-2">
                <?php foreach ( $tags as $tag ) :?>
                    <a 
                        href="<?php echo esc_url( get_term_link( $tag ) ); ?>" 
                        class="text-decoration-none"
                    >
                        <div 
                            class="bg-primary bg-opacity-25 border link-primary px-1" 
                            data-tag="<?php echo esc_html( $tag->name ) ?>" 
                            data-bs-toggle="popover"
                        >
                            <?php echo esc_html( $tag->name ); ?>
                        </div>
                    </a>
                <? endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between">
            <div class="hstack gap-2 py-3">
                <a href="#" class="text-decoration-none text-muted"><div>share</div></a>
                <a href="#" class="text-decoration-none text-muted"><div>improve this question</div></a>
            </div>
            <div class="py-3">
                <a href="#" class="text-decoration-none small link-primary">
                    <span>edited</span> 
                    <?php echo get_post_datetime( $post, 'modified', 'local' )->format('M d, Y \a\t H:i'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 border-start small">
        <p>
            <span class="text-muted">asked</span> 
            <?php echo get_post_datetime( $post, 'date', 'local' )->format('M d, Y \a\t H:i'); ?>
        </p>
    </div>
</div>
