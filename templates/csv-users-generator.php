<?php
if ( !current_user_can( 'manage_options' ) ) {
    return;
}
?>

<div class="wrap">
    <h1><?php _e( 'CSV Users Generator', CUG_TEXT_DOMAIN ); ?></h1>
</div>
