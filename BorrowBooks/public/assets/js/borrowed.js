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

        return_button.addEventListener('click', (event) => {
            const book_id = parseInt(return_button.getAttribute('data-book-id'));

            fetch(`/book/${book_id}/return`, { method: 'POST' })
            .then((response) => response.json())
            .then(async (response) => {
                if (response.status >= 400) {
                    await Dialog.show({
                        title: 'Oops!',
                        message: response.error.message,
                        buttons: [
                            { text: 'OK', role: 'confirm' }
                        ]
                    })
                } else {
                    await Dialog.show({
                        title: 'Successfully returned book!',
                        buttons: [
                            { text: 'OK', role: 'confirm' }
                        ]
                    })
                    window.location.reload();
                }
            });

            event.stopPropagation();
            event.preventDefault();
        });
    });
});