<?php
if ( !current_user_can( 'manage_options' ) ) {
    return;
}
?>

<div class="wrap">
    <h1><?php _e( 'CSV Users Generator', CUG_TEXT_DOMAIN ); ?></h1>
    
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
        <input type="hidden" name="action" value="csv_users_generator">
        <?php wp_nonce_field( 'csv_users_nonce', 'cug_nonce' ); ?>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="csv_users"><?php _e( 'Upload CSV', CUG_TEXT_DOMAIN ); ?></label>
                    </th>
                    <td>
                        <input type="file" name="csv_users" id="csv_users">
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Import Users">
        </p>
    </form>
</div>
