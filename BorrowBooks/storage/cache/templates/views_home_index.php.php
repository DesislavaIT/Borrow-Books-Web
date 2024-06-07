<?php class_exists('Core\Web\Template') or exit; ?>
<?php
/**
 * @var File[] $books
 */

use Bookstore\Models\File;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="assets/css/global.css" />
        

        <style type="text/css">
            .fa {
                display: inline-block;
                font: normal normal normal 16px/1 "FontAwesome";
                font-size: inherit;
                text-rendering: auto;
                line-height: inherit;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .mdi:before, .mdi-set {
                display: inline-block;
                font: normal normal normal 16px/1 "Material Design Icons";
                font-size: inherit;
                text-rendering: auto;
                line-height: inherit;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .fa-fw, .fa-fw:before, .mdi-fw:before {
                width: 1.25em;
                text-align: center;
            }
        </style>

        <title>Bookstore</title>
    </head>
    <body>
        <div class="page-layout">
            <div class="sidebar-overlay"></div>
            <aside class="sidebar">
                <nav>
                    <ul>
                        <li class="<?= application()->router->currentRoute->name === 'home' ? 'active' : '' ?>">
                            <a href="/home">
                                <i class="fa fa-fw fa-home" aria-hidden="true"></i>Home
                            </a>
                        </li>
                        <li class="<?= application()->router->currentRoute->name === 'borrowed' ? 'active' : '' ?>">
                            <a href="/borrowed">
                                <i class="fa fa-fw fa-bookmark" aria-hidden="true"></i>Borrowed
                            </a>
                        </li>
                    </ul>
                </nav>
                <nav style="margin-top: auto;">
                    <ul>
                        <li>
                            <a id="import-button">
                                <i class="fa fa-fw fa-plus-circle" aria-hidden="true"></i>Import Book
                            </a>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="fa fa-fw fa-sign-out" aria-hidden="true"></i>Log Out
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
            <main>
                <toolbar>
                    <button class="button-primary sidebar-toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    
    <header>Home</header>

                </toolbar>
                <div class="container">
                    
    <h1>Greetings, <?php echo application()->user->getUsername() ?>!</h1>

    <div class="grid">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card book" style="margin-bottom: 1rem;">
                        <div class="card-body">
                            <?= $book->getFilename() ?>
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

                </div>
            </main>
        </div>
        <template id="import-form">
            <form action="/import" enctype="multipart/form-data" method="POST">
                <input type="file" id="resource" name="resource[]" class="input-dropzone"
                       accept="application/pdf"
                       max="5"
                       multiple
                >
            </form>
        </template>
        <script type="module" src="assets/js/main.js"></script>
        
    <script type="module" src="assets/js/home.js"></script>

    </body>
</html>







