<?php

/** @var WP_Post $post */
$post = $args['post'];

$position = get_field( 'js_school_wp_team_member_settings_position', $post->ID );
$photo = get_field( 'js_school_wp_team_member_settings_photo', $post->ID );

?>

<div class="col">
    <div class="card" style="width: 15rem;">
        <img 
            src="<?php echo esc_url( $photo['url']); ?>" 
            class="card-img-top" alt="Team member photo"
        >
        <div class="card-body">
            <h5 class="card-title"><?php echo esc_html( get_the_title( $post ) ); ?></h5>
            <p class="card-text text-muted"><?php echo esc_html( $position ); ?></p>
        </div>
    </div>
</div>
