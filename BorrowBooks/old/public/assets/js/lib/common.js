/**
 * @param  {String}  html HTML representing a single element.
 * @param  {Boolean} trim Flag representing whether to trim input whitespace, defaults to true.
 *
 * @return {Element | HTMLCollection | null}
 */
export function fromHTML(html, trim = true)
{
    html = trim ? html.trim() : html;
    if (!html) {
        return null;
    }

    const template= document.createElement('template');
    template.innerHTML = html;

    const result= template.content.children;

    if (result.length === 1) {
        return result[0];
    }

    return result;
}

export function containerOpen(element, callback, options = { class_open: 'open', class_opening: 'opening' }) {
    element.classList.add(options.class_open);

    requestAnimationFrame(() => {
        element.addEventListener('transitionend', () => {
            requestAnimationFrame(callback);
        }, { once: true });
        element.classList.add(options.class_opening);
    });
}

export function containerClose(element, callback, options = { class_open: 'open', class_opening: 'opening' }) {
    element.addEventListener('transitionend', () => {
        element.classList.remove(options.class_open);
        requestAnimationFrame(callback);
    }, { once: true });
    element.classList.remove(options.class_opening);
}
