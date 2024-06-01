export const Button = {
    loading: function(button, text = 'Loading...') {
        button.setAttribute('data-original-text', button.innerHTML);
        button.disabled = true;
        button.innerHTML = (`
            <span class="spinner-border spinner-border-small" role="status" aria-hidden="true"></span> ${text}
        `);
    },

    reset: function(button) {
        button.innerHTML = button.getAttribute('data-original-text');
        button.disabled = false;
    }
};
