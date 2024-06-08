import { Dialog } from './lib/dialog.js';

document.addEventListener('DOMContentLoaded', () => {
    const books = document.querySelectorAll('.book');
    const searchInput = document.getElementById('book-search');
    const bookItems = document.querySelectorAll('.book-item');

    books.forEach((book) => {
        const borrow_button = book.querySelector('.button-primary');
        const delete_button = book.querySelector('.close-button');

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
                });

            event.stopPropagation();
            event.preventDefault();
        });

        if(delete_button) {
        delete_button.addEventListener('click', async (event) => {
            const book_id = parseInt(delete_button.getAttribute('data-book-id'));

            const confirmDelete = await Dialog.show({
                title: 'Confirm Deletion',
                message: 'Are you sure you want to delete this book?',
                buttons: [
                    { text: 'Cancel', role: 'cancel' },
                    { text: 'Delete', role: 'confirm' }
                ]
            });

            if (confirmDelete.role === 'confirm') {
                fetch(`/book/${book_id}/delete`, { method: 'DELETE' })
                    .then((response) => response.json())
                    .then(async (response) => {
                        if (response.status >= 400) {
                            await Dialog.show({
                                title: 'Error',
                                message: response.message,
                                buttons: [
                                    { text: 'OK', role: 'confirm' }
                                ]
                            });
                        } else {
                            await Dialog.show({
                                title: 'Success',
                                message: 'Book deleted successfully.',
                                buttons: [
                                    { text: 'OK', role: 'confirm' }
                                ]
                            });
                            window.location.reload();
                        }
                    });
            }

            event.stopPropagation();
            event.preventDefault();
        });
    }
    });

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        bookItems.forEach(bookItem => {
            const bookTitle = bookItem.getAttribute('data-book-title').toLowerCase();
            if (bookTitle.includes(query)) {
                bookItem.style.display = '';
            } else {
                bookItem.style.display = 'none';
            }
        });
    });
});
