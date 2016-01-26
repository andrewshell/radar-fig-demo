<!DOCTYPE html>
<html>
<head>
    <title>DisplaySinglePost</title>
</head>
<body>
<?php if (isset($data) && isset($data['post'])): ?>
    <h1><?= htmlentities($data['post']->getTitle()); ?></h1>
    <p><?= nl2br(htmlentities($data['post']->getContent())); ?></p>
<?php endif; ?>
    <p><a href="/">Go back...</a></p>
</body>
</html>
