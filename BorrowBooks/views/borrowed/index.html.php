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
    <div class="grid">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card book" style="margin-bottom: 1rem;">
                        <div class="card-body">
                            <?= $book->getFile()->getFilename() ?>
                        </div>
                        <div class="card-body">
                            <p>By <strong><?= $book->getFile()->getAuthor() ?></strong></p>
                            <?php $color = time() > $book->getReturnDate()->getTimestamp() ? 'red': 'inherit' ?>
                            <span style="margin-right: auto; color: <?= $color ?>;">
                                Return on <?= $book->getReturnDate()->format('d/m/Y') ?>
                            </span>
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
