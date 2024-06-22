<?php
/**
 * @var UserFile[] $books
 */

use Bookstore\Models\UserFile;
?>

{% extends views/layout.html.php %}

{% block toolbar %}
    <header>Borrowed</header>
{% endblock %}

{% block content %}
    <div class="centered-container">
        <div class="search-container">
            <input type="text" id="book-search" placeholder="Search borrowed books...">
            <i class="fa fa-search search-icon"></i>
        </div>
    </div>

    <div class="grid">
        <div class="row" id="book-list">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 book-item" data-book-title="<?= htmlspecialchars($book->getFile()->getFilename()) ?>">
                    <div class="card book" style="margin-bottom: 1rem;">
                        <div class="card-body">
                            <?= htmlspecialchars($book->getFile()->getFilename()) ?>
                        </div>
                        <div class="card-body">
                            <p>Author: <strong><?= htmlspecialchars($book->getFile()->getAuthor()) ?></strong></p>
                            <?php $color = time() > $book->getReturnDate()->getTimestamp() ? 'red': 'inherit' ?>
                            <span class="return-date" data-return-date="<?= $book->getReturnDate()->format('Y-m-d') ?>" style="margin-right: auto; color: <?= $color ?>;">
                                Return on <?= $book->getReturnDate()->format('d/m/Y') ?>
                            </span>
                            <span class="countdown" style="color: purple; font-size: smaller;"></span>
                        </div>
                        <div class="card-footer">
                            <div class="card-actions">
                                <button type="button" class="button-primary button-read" data-book-id="<?= $book->getFile()->getId() ?>">
                                    <i class="mdi mdi-fw mdi-book-open"></i> Read
                                </button>
                                <button type="button" class="button-primary button-return" data-book-id="<?= $book->getFile()->getId() ?>">
                                    <i class="fa fa-fw fa-share"></i> Return
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
    <script type="module" src="assets/js/borrowed.js"></script>
{% endblock %}
