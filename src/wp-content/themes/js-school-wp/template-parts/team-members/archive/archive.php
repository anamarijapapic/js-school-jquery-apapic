<?php

/** @var WP_Query $query */
$query = $args['query'];

?>

<div class="container">
    <?php if ( $query->have_posts() ) : ?>
        <div class="row">
            <?php $cnt = 0; ?>
			<?php foreach ( $query->posts as $post ) : ?>
                <?php
                $cnt++;
                $position = get_field( 'js_school_wp_team_member_settings_position', $post->ID );
                $photo = get_field( 'js_school_wp_team_member_settings_photo', $post->ID );
                ?>
				<div class="col-lg-3">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo esc_url( $photo['url']); ?>" class="card-img-top" alt="Team member photo">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo esc_html( get_the_title( $post ) ); ?></h5>
                            <p class="card-text text-muted"><?php echo esc_html( $position ); ?></p>
                        </div>
                    </div>
                </div>
                <?php if ( $cnt == 4 ) : ?>
                    <? $cnt = 0; ?>
        </div>
        <div class="row">
                <? endif; ?>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</div>