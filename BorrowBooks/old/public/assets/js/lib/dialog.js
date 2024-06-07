import { fromHTML, containerOpen, containerClose } from './common.js';

export class Dialog
{
    static _dialog_id = 0;

    static show(options = {})
    {
        return new Promise((resolve) => {
            const dialog = new Dialog(options);

            requestAnimationFrame(() => {
                dialog._element.addEventListener('didhide', () => resolve(dialog));
                dialog.present().then((dialog) => resolve(dialog));
            });
        });
    }

    constructor(options = {})
    {
        this._id      = (Dialog._dialog_id++);
        this._options = { autoDismiss: true, static: false, ...options };
        this._element = null;

        this.role          = 'cancel';
        this.buttonPressed = null;

        this._create();
    }

    _create()
    {
        const self       = this;
        const $rendered  = fromHTML(`
            <div class="modal" id="dialog-${self._id}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-overlay"></div>
                <div class="modal-container">
                    <div class="modal-header">
                        <header>${self._options.title}</header>
                        <button type="button" class="modal-close">
                            <i class="fa fa-fw fa-close"></i>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        `);
        const $container = $rendered.querySelector('.modal-container');

        if (self._options.message) {
            $rendered.querySelector('.modal-body').innerText = self._options.message;
        } else if (self._options.content) {
            $rendered.querySelector('.modal-body').innerHTML = self._options.content;
        } else {
            $rendered.querySelector('.modal-body').remove();
        }

        if (self._options.buttons && self._options.buttons.length > 0) {
            const $buttons = fromHTML('<div class="modal-buttons"></div>');

            self._options.buttons.forEach((button) => {
                let $button = fromHTML(`<button type="button">${button.text}</button>`);
                if (!button.class) {
                    if (button.role === 'confirm') {
                        $button.classList.add('button-primary');
                    }
                } else {
                    $button.classList.add(button.class);
                }
                $button.setAttribute('data-button-role', button.role);

                $buttons.appendChild($button);
            });

            $rendered.querySelector('.modal-footer').appendChild($buttons);
        } else {
            $rendered.querySelector('.modal-footer').remove();
        }

        $rendered.querySelector('.modal-overlay')
            .addEventListener('click', () => {
                if (!self._options.static) self._hide();
            });

        $rendered.querySelector('.modal-close')
            .addEventListener('click', () => self._hide());

        self._element = document.body.appendChild($rendered);

        if (self._options.oncreated) {
            self._options.oncreated(self);
        }
    }

    _show()
    {
        const $container = this._element.querySelector('.modal-container');

        containerOpen(this._element, () => {
            containerOpen($container, () => {
                let event = new CustomEvent('didshow');
                this._element.dispatchEvent(event);
            }, {
                class_open:    'show',
                class_opening: 'showing'
            });
        });
    }

    _hide()
    {
        const $container = this._element.querySelector('.modal-container');

        containerClose($container, () => {
            containerClose(this._element, () => {
                let event = new CustomEvent('didhide');
                this._element.dispatchEvent(event);
            });
        }, {
            class_open:    'show',
            class_opening: 'showing'
        });
    }

    present()
    {
        const self = this;

        const $container = self._element.querySelector('.modal-container');

        return new Promise((resolve) => {
            self._element.addEventListener('didshow', () => {
                self._element.querySelectorAll('.modal-buttons button').forEach((button) => {
                    button.addEventListener('click', () => {
                        self.role          = button.getAttribute('data-button-role');
                        self.buttonPressed = button;

                        if (self._options.autoDismiss) {
                            containerClose($container, () => {
                                containerClose(self._element, () => {
                                });
                            }, {
                                class_open:    'show',
                                class_opening: 'showing'
                            });
                        }

                        resolve(self);
                    });
                });
            }, { once: true });

            self._element.addEventListener('didhide', () => {
                self._element.remove();
            }, { once: true });

            requestAnimationFrame(() => self._show());
        });
    }

    dismiss()
    {
        const self = this;

        return new Promise((resolve) => {
            self._element.addEventListener('didhide', () => {
                self._element.remove();
                resolve();
            }, { once: true });

            self._hide();
        });
    }

    disable()
    {
        const self = this;

        self._element.querySelectorAll('.modal-buttons button').forEach((button) => {
            button.disabled = true;
        });
    }
}
