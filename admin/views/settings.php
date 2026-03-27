<div class="wrap">
    <h1>Settings</h1>

    <form method="post" action="options.php">
        <?php settings_fields('kwm_settings_group'); ?>
        <?php $options = get_option('kwm_settings'); ?>

        <table class="form-table">
            <tr>
                <th>API Key</th>
                <td>
                    <input type="text" name="kwm_settings[api_key]" value="<?php echo esc_attr($options['api_key'] ?? ''); ?>">
                </td>
            </tr>

            <tr>
                <th>Phone Number</th>
                <td>
                    <input type="text" name="kwm_settings[phone_number]" value="<?php echo esc_attr($options['phone_number'] ?? ''); ?>">
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>