<?php
global $wpdb;
$table = $wpdb->prefix . 'kwm_logs';
$logs = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC LIMIT 50");
?>

<div class="wrap">
    <h1>WhatsApp Logs</h1>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($logs): ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo $log->id; ?></td>
                        <td><?php echo esc_html($log->phone); ?></td>
                        <td><?php echo esc_html($log->message); ?></td>
                        <td><?php echo esc_html($log->type); ?></td>
                        <td><?php echo esc_html($log->status); ?></td>
                        <td><?php echo $log->created_at; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>