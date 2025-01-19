<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board</title>
    <!--Add css location-->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="container">
    <img class="image" src="/assets/images/logo.png" alt="Logo"> <!-- Image -->
    <h1>Message Board</h1>
    <form method="POST" onsubmit="showAlert()">
        <textarea name="content" placeholder="Write your message here..."></textarea>
        <button type="submit">Submit</button>
    </form>

    <!-- Alert box for JavaScript -->
    <div class="message" id="alertMessage" style="display:none;">Your message has been submitted successfully!</div>

    <?php if (!empty($messages_box)): ?>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Content</th>
                <th>Timestamp</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($messages_box as $message): ?>
                <tr>
                    <td><?= htmlspecialchars($message->id) ?></td>
                    <td><?= htmlspecialchars($message->content) ?></td>
                    <td><?= htmlspecialchars($message->created_at) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<!-- Add js location -->
<script src="/assets/js/script.js"></script>
</body>
</html>
