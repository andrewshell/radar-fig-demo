<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>An Error Occured</h1>
<?php if (isset($data) && isset($data['message'])): ?>
    <p><?= htmlentities($data['message']); ?></p>
<?php endif; ?>
    <p><a href="/">Go home...</a></p>
</body>
</html>
