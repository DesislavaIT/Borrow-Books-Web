<?php
/**
 * @var UserHistory[] $userHistory
 */

use Bookstore\Models\UserHistory;
?>

{% extends 'views/layout.html.php' %}

{% block stylesheets %}
    <link rel="stylesheet" href="assets/css/history.css" />
{% endblock %}

{% block toolbar %}
<header>History</header>
{% endblock %}

{% block content %}
<div class="centered-container">
    <div class="search-container">
        <input type="text" id="book-search" placeholder="Search for books...">
        <i class="fa fa-search search-icon"></i>
    </div>
</div>

<div class="centered-container">
    <ul class="book-list">
        <?php foreach ($books as $book): ?>
            <li class="book-item">
                <div class="book-details">
                    <span class="book-title"><?= htmlspecialchars($book->getFile()->getFilename()) ?> - </span>
                    <span class="book-author"><?= htmlspecialchars($book->getFile()->getAuthor()) ?></span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
{% endblock %}

{% block javascript %}
    <script type="module" src="assets/js/history.js"></script>
{% endblock %}
