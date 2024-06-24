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
    <div class="centered-container">
        <h1 class="welcome-text">Welcome, {{ application()->user->getUsername() }}!</h1>

        <div class="search-container">
            <input type="text" id="book-search" placeholder="Search books...">
            <i class="fa fa-search search-icon"></i>
        </div>
    </div>

    <div class="grid">
        <div class="row" id="book-list">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 book-item" data-book-title="<?= htmlspecialchars($book->getFilename()) ?>">
                    <div class="card book" style="margin-bottom: 1rem; position: relative;">
                        <?php if (application()->user->getUsername() === $book->getAuthor()): ?>
                            <button type="button" class="close-button" data-book-id="<?= $book->getId() ?>">
                                &times;
                            </button>
                        <?php endif; ?>
                        <div class="card-body">
                            <?= htmlspecialchars($book->getFilename()) ?>
                            <br>
                            <small><?= number_format($book->getSize()) ?> bytes</small>
                        </div>
                        <div class="card-footer">
                            <span>Author: <strong data-book-author="<?= htmlspecialchars($book->getAuthor()) ?>"><?= htmlspecialchars($book->getAuthor()) ?></strong></span>
                            <span>Uploaded: <strong><?= htmlspecialchars($book->getUploadedDate()) ?></strong></span>
                            <div class="card-actions" style="margin-top: 1rem;">
                                <button type="button" class="button-primary" data-book-id="<?= $book->getId() ?>">
                                    <i class="fa fa-fw fa-bookmark"></i> Borrow
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
{% endblock %}

{% block javascript %}
    <script type="module" src="assets/js/home.js"></script>
{% endblock %}
