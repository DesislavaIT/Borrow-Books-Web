import { Dialog } from './lib/dialog.js';

document.addEventListener('DOMContentLoaded', () => {
    const books = document.querySelectorAll('.book');
    const searchInput = document.getElementById('book-search');
    const bookItems = document.querySelectorAll('.book-item');
    const returnDates = document.querySelectorAll('.return-date');

    function updateCountdown() {
        returnDates.forEach(returnDateElement => {
            const returnDate = new Date(returnDateElement.dataset.returnDate);
            const countdownElement = returnDateElement.nextElementSibling;

            const now = new Date();
            const diffTime = returnDate - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                countdownElement.innerHTML = `<br>${diffDays} days remaining`;
            } else {
                countdownElement.innerHTML = '<br>Past due';
                countdownElement.style.color = 'red';
            }
        });
    }

    updateCountdown();
    setInterval(updateCountdown, 1000 * 60 * 60 * 24); // Update every day

    books.forEach((book) => {
        const read_button = book.querySelector('.button-read');
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
                        });
                    } else {
                        await Dialog.show({
                            title: 'Successfully returned book!',
                            buttons: [
                                { text: 'OK', role: 'confirm' }
                            ]
                        });
                        window.location.reload();
                    }
                });

            event.stopPropagation();
            event.preventDefault();
        });
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
