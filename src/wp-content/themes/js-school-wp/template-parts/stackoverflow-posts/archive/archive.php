<?php

use function JsSchoolWp\Inc\Shared\render;

/** @var WP_Query $query */
$query = $args['query'];

echo render( 'template-parts/stackoverflow-posts/archive/page-nav' );
echo render( 'template-parts/stackoverflow-posts/archive/page-header' );

?>

<div class="container-fluid">
    <div class="container">
        <?php if ( $query->have_posts() ) : ?>
            <?php foreach ( $query->posts as $post ) {
                echo render( 'template-parts/stackoverflow-posts/archive/loop-item', [ 'post' => $post ] );
            } ?>
        <?php endif; ?>
    </div>
</div>

<?php

echo render( 'template-parts/stackoverflow-posts/archive/page-footer' );
