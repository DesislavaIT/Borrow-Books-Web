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
    <h1>Welcome, {{ application()->user->getUsername() }}!</h1>

    <div class="grid">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card book" style="margin-bottom: 1rem;">
                        <div class="card-body">
                            <?= $book->getFilename() ?>
                            <br>
                            <small><?= number_format($book->getSize()) ?> bytes</small>
                        </div>
                        <div class="card-footer">
                            <span>By <strong><?= $book->getAuthor() ?></strong></span>
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
