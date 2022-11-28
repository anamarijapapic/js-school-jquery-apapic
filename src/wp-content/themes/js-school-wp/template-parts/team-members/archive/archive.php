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
        <div class="row text-center">
            <div class="mt-5 w-auto ms-auto">
                <div class="btn-group" role="group" aria-label="Options">
                    <button class="btn btn-outline-secondary variant1 active" type="button">
                        Variant 1 (Infinite scroll)
                    </button>
                    <button class="btn btn-outline-secondary variant2" type="button">
                        Variant 2 (Load more)
                    </button>
                </div>
            </div>
            <div class="col-sm-10 mx-auto my-5">
                <p class="lead px-5">
                    Our team members represent the spirit of the markets we serve: driven, committed, and acutely aware of how
                    education improves lives. We go to great lengths to identify self-starters with diverse experience and skill sets to
                    help curious minds achieve great things.
                </p>
            </div>
        </div>

        <div class="row js-team-member-archive">
            <div class="col-sm-10 mx-auto mb-5">
                <?php if ( $query->have_posts() ) : ?>
                    <div class="row row-cols-auto justify-content-center gy-3 js-team-member-archive__row">
                        <?php foreach ( $query->posts as $post ) {
                            echo render( 'template-parts/team-members/archive/loop-item', [ 'post' => $post ] );
                        } ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( $query->found_posts > $query->post_count ) : ?>
                <div class="col-sm-12 mb-5 d-none text-center js-team-member-archive__load-more-wrapper">
                    <button type="button" class="btn btn-outline-secondary text-uppercase js-team-member-archive__load-more">
                        Load more
                    </button>
                </div>
                <div class="d-none mb-5 justify-content-center js-team-member-archive__load-more-loading">
                    <div class="spinner-border text-secondary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

echo render( 'template-parts/team-members/archive/page-footer' );
