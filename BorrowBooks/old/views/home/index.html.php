<?php
/**
 * @var File[] $books
 */

use Bookstore\Models\File;

?>

{% extends views/layout.html.php %}

{% block toolbar %}
    <header>Home</header>
{% endblock %}

{% block content %}
    <h1>Greetings, {{ application()->user->getUsername() }}!</h1>

    <ul>
        <?php foreach ($books as $book): ?>
            <li><?= $book->getFilename() ?> by <?= $book->getAuthor() ?></li>
        <?php endforeach; ?>
    </ul>
{% endblock %}

{% block javascript %}
{% endblock %}
