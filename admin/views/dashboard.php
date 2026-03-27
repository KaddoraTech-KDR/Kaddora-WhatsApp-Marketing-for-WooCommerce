<div class="wrap">
    <h1>Kaddora WhatsApp Dashboard</h1>

    <?php if (isset($_GET['sent'])): ?>
        <div class="notice notice-success is-dismissible">
            <p>Campaign sent successfully!</p>
        </div>
    <?php endif; ?>

    <h2>Send Campaign</h2>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="kwm_send_campaign">

        <textarea name="message" rows="5" cols="50" placeholder="Enter message"></textarea>

        <br><br>
        <button type="submit" class="button button-primary">Send</button>
    </form>
</div>