document.addEventListener("DOMContentLoaded", function() {
    const bookItems = document.querySelectorAll(".book-item");
    const bookDetailCard = document.getElementById("bookDetailCard");
    const closeBtn = document.getElementById("closeBtn");
    const homePage = document.querySelector(".home-page");

    bookItems.forEach(item => {
        item.addEventListener("click", function() {
            const image = this.getAttribute("data-image");
            const title = this.getAttribute("data-title");
            const author = this.getAttribute("data-author");
            const description = this.getAttribute("data-description");
            
            document.getElementById("bookImage").scr = image;
            document.getElementById("bookTitle").innerText = title;
            document.getElementById("bookAuthor").innerText = author;
            document.getElementById("bookDescription").innerText = description;

            bookDetailCard.style.display = "block";
            homePage.classList.add("blur");
            homePage.classList.add("blocked");
            document.body.classList.add("disable-scroll");
        });
    });

    function closeCard() {
        bookDetailCard.style.display = "none";
        homePage.classList.remove("blur");
        homePage.classList.remove("blocked");
        document.body.classList.remove("disable-scroll");
    }

    closeBtn.addEventListener("click", closeCard);

    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape") {
            closeCard();
        }
    });
});