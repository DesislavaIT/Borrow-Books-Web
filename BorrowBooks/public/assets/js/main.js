import { Button } from './lib/button.js';
import { Dialog } from './lib/dialog.js';
import { Dropzone } from './lib/dropzone.js';

document.addEventListener('DOMContentLoaded', () => {
    const page_layout     = document.querySelector('.page-layout');
    const sidebar_overlay = document.querySelector('.sidebar-overlay');
    const sidebar_toggle  = document.querySelector('.sidebar-toggle');
    const import_button   = document.querySelector('#import-button');
    const import_form     = document.querySelector('#import-form');

    sidebar_toggle.addEventListener('click', () => {
        page_layout.classList.toggle('sidebar-shown');
    });

    sidebar_overlay.addEventListener('click', () => {
        sidebar_toggle.click();
    });

    import_button.addEventListener('click', () => {
        Dialog.show({
            title: 'Import Resource',
            // message:     'This is the contents inside the modal.',
            content: import_form.innerHTML,
            buttons: [
                { text: 'Import', role: 'confirm' },
                { text: 'Cancel', role: 'cancel' }
            ],
            oncreated: (dialog) => {
                (new Dropzone(dialog._element.querySelector('.input-dropzone')));
            },
            autoDismiss: false,
            static: true
        }).then(async (dialog) => {
            if (dialog.role === 'confirm') {
                Button.loading(dialog.buttonPressed, 'Importing...');
                dialog.disable();

                fetch('/import', {
                    method: 'POST',
                    body: (new FormData(dialog._element.querySelector('form')))
                })
                    .then((response) => response.json())
                    .then(async (response) => {
                        if (response.status >= 400) {
                            await Dialog.show({
                                title: 'Error',
                                message: 'Import failed. Please, try again in a few moments.',
                                buttons: [
                                    { text: 'OK', role: 'cancel', class: 'button-primary' }
                                ]
                            }).then(async () => {
                                await dialog.dismiss();
                            });
                        } else if (response.status === 200) {
                            await dialog.dismiss();
                            window.location.reload();
                        }
                    });
            } else {
                await dialog.dismiss();
            }
        });
    });
});
