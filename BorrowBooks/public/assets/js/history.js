document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('book-search');
    const bookItems = document.querySelectorAll('.book-item');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase().trim();
        bookItems.forEach(bookItem => {
            const bookTitle = bookItem.querySelector('.book-title').textContent.toLowerCase();
            const bookAuthor = bookItem.querySelector('.book-author').textContent.toLowerCase();
            if (bookTitle.includes(query) || bookAuthor.includes(query)) {
                bookItem.style.display = '';
            } else {
                bookItem.style.display = 'none';
            }
        });
    });
});
