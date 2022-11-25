<?php

use function JsSchoolWp\Inc\Shared\render;

/** @var WP_Query $query */
$query = $args['query'];

echo render( 'template-parts/team-members/archive/page-nav' );

?>

<header class="py-3 border-bottom bg-secondary">
    <div class="container d-flex flex-wrap">
        <span class="d-flex me-auto px-2 link-light fs-4">Our Team</span>
        <ul class="nav">
            <li class="nav-item"><a href="#" class="nav-link link-light px-2">Home</a></li>
            <li class="nav-item divider"><span class="nav-link text-light px-2">></span></li>
            <li class="nav-item"><a href="#" class="nav-link link-light px-2 fw-bold active" aria-current="page">Our Team</a></li>
        </ul>
    </div>
</header>

<div class="container-fluid bg-secondary bg-opacity-10">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 mx-auto my-5">
                <p class="lead px-5">
                    Our team members represent the spirit of the markets we serve: driven, committed, and acutely aware of how
                    education improves lives. We go to great lengths to identify self-starters with diverse experience and skill sets to
                    help curious minds achieve great things.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10 mx-auto mb-5">
                <?php if ( $query->have_posts() ) : ?>
                    <div class="row row-cols-auto justify-content-center gy-3">
                        <?php foreach ( $query->posts as $post ) {
                            echo render( 'template-parts/team-members/archive/loop-item', ['post' => $post] );
                        } ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php

echo render( 'template-parts/team-members/archive/page-footer' );
