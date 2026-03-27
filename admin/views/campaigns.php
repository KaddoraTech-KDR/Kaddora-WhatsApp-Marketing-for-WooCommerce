<div class="wrap">
    <h1>Campaigns</h1>

    <?php if (isset($_GET['sent'])): ?>
        <div class="notice notice-success">
            <p>Campaign sent successfully!</p>
        </div>
    <?php endif; ?>

    <h2>Create Campaign</h2>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="kwm_send_campaign">

        <table class="form-table">
            <tr>
                <th>Message</th>
                <td>
                    <textarea name="message" rows="5" cols="50" required></textarea>
                </td>
            </tr>
        </table>

        <?php submit_button('Send Campaign'); ?>
    </form>
</div>