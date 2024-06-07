import { Dialog } from './lib/dialog.js';

document.addEventListener('DOMContentLoaded', () => {
    const books = document.querySelectorAll('.book');

    books.forEach((book) => {
        const borrow_button = book.querySelector('button');

        borrow_button.addEventListener('click', (event) => {
            const book_id = parseInt(borrow_button.getAttribute('data-book-id'));

            fetch(`/book/${book_id}/borrow`, { method: 'POST' })
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
                        window.location.reload();
                    }
                })
            ;

            event.stopPropagation();
            event.preventDefault();
        });
    });
});
