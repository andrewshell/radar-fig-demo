<!DOCTYPE html>
<html>
<head>
    <title>ListAllPosts</title>
</head>
<body>
<form method="post">
    <p><input type="text" name="title" placeholder="Title" size="100"></p>
    <p><textarea name="content" placeholder="Content" cols="100" rows="10"></textarea></p>
    <p><textarea name="excerpt" placeholder="Excerpt (optional)" cols="100" rows="2"></textarea></p>
    <p><button type="submit">Save Post</button>
</form>
<?php if (isset($data) && isset($data['posts']) && is_array($data['posts'])): ?>
<?php foreach ($data['posts'] as $post): ?>
    <h2><?= htmlentities($post->getTitle()); ?></h2>
    <p><?= htmlentities($post->getExcerpt()); ?></p>
    <?php if ($post->hasId()): ?>
    <p><a href="/<?= $post->getId(); ?>/">Read more...</a></p>
    <?php endif; ?>
    <hr>
<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
