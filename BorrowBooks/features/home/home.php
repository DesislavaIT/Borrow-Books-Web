<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>
        <link rel="stylesheet" href="home.css" />
	    <script type="module" src="home.js"></script>
    </head>
    <body>
        <section class="home-page">
            <nav class="sidebar">
                <ul>
                    <li><a href="#home.php">Home</a></li>
                    <li><a href="#borrowed-books.php">Borrowed Books</a></li>
                    <li><a href="#favourite-quotes.php">Favourite Quotes</a></li>
                    <li><a href="#statistics.php">Statistics</a></li>
                    <li><a href="#literary-reading.php">Literary Reading</a></li>
                    <li><a href="#logout.php">Logout</a></li>
                </ul>
                <section class="import-container">
                    <button class="import-button">
                        <img src="../../images/plus-icon.png" alt="Import">
                    </button>
                    <span class="import-text">Import Books</span>
                </section>
            </nav>
            <section class="content">
                <header>
                    <h1>Book Collection</h1>
                </header>
                <main>
                    <section class="book-grid">
                        <section class="book-item" data-title="Book Title" data-author="Author" data-description="In the far distance a helicopter skimmed down between the roofs, hovered for an instant like a bluebottle, and darted away again with a curving flight. It was the Police Patrol, snooping into people's windows. The patrols did not matter, however. Only the Thought Police mattered. This passage captures the ominous atmosphere of surveillance and control that permeates the world of "1984". If you need more text or have a specific request, feel free to let me know!" data-image="../../images/book.jpg">
                            <img src="../../images/book.jpg" alt="Book">
                            <h3>Book Title</h3>
                            <p>Author</p>
                        </section>
                        <!-- More books here -->
                    </section>
                </main>
            </section>
        </section>

        <section class="book-detail-card" id="bookDetailCard">
            <button class="close-btn" id="closeBtn">X</button>
            <img src="../../images/book.jpg" alt="Book Image" id="bookImage">
            <h2 id="bookTitle"></h2>
            <h3 id="bookAuthor"></h3>
            <p id="bookDescription"></p>
            <button class="borrow-btn" id="borrowBtn">Borrow Book</button>
        </section>
    </body>
</html>