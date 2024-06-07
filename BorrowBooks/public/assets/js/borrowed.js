import { Dialog } from './lib/dialog.js';

document.addEventListener('DOMContentLoaded', () => {
    const books = document.querySelectorAll('.book');

    books.forEach((book) => {
        const read_button   = book.querySelector('.button-read');
        const return_button = book.querySelector('.button-return');

        read_button.addEventListener('click', (event) => {
            const id = parseInt(read_button.getAttribute('data-book-id'));

            window.open(`/book/${id}/read`, '_blank').focus();

            event.stopPropagation();
            event.preventDefault();
        });
    });
});
