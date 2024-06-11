import { Button } from './lib/button.js';
import { Dialog } from './lib/dialog.js';
import { Dropzone } from './lib/dropzone.js';

document.addEventListener('DOMContentLoaded', () => {
    const page_layout = document.querySelector('.page-layout');
    const sidebar_overlay = document.querySelector('.sidebar-overlay');
    const sidebar_toggle = document.querySelector('.sidebar-toggle');
    const import_button = document.querySelector('#import-button');
    const import_form = document.querySelector('#import-form');

    sidebar_toggle.addEventListener('click', () => {
        page_layout.classList.toggle('sidebar-shown');
    });

    sidebar_overlay.addEventListener('click', () => {
        sidebar_toggle.click();
    });

    import_button.addEventListener('click', async () => {
        const dialog = await Dialog.show({
            title: 'Import Resource',
            content: import_form.innerHTML,
            buttons: [
                { text: 'Import', role: 'confirm' },
                { text: 'Cancel', role: 'cancel' }
            ],
            oncreated: (dialog) => {
                new Dropzone(dialog._element.querySelector('.input-dropzone'));
            },
            autoDismiss: false,
            static: true
        });

        if (dialog.role === 'confirm') {
            Button.loading(dialog.buttonPressed, 'Importing...');
            dialog.disable();

            try {
                const response = await fetch('/import', {
                    method: 'POST',
                    body: new FormData(dialog._element.querySelector('form'))
                });

                const responseData = await response.json();

                if (response.status >= 400) {
                    let message = '';
                    if (response.status === 409) {
                        const filenames = responseData.errors.map(filename => `<span style="color: red;">${filename}</span>`).join(', ');
                        message = `An error occurred. The following file(s) already exist in the database: ${filenames}`;
                    } else {
                        message = 'An error occurred. Please try again later.';
                    }
                    await dialog.dismiss();
                    await Dialog.show({
                        title: 'Error',
                        content: `<p>${message}</p>`,
                        buttons: [
                            { text: 'OK', role: 'cancel', class: 'button-primary' }
                        ]
                    });
                } else if (response.status === 200) {
                    await dialog.dismiss();
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                await dialog.dismiss();
                await Dialog.show({
                    title: 'Error',
                    content: '<p>An error occurred. Please try again later.</p>',
                    buttons: [
                        { text: 'OK', role: 'cancel', class: 'button-primary' }
                    ]
                });
            }
        } else {
            await dialog.dismiss();
        }
    });
});
