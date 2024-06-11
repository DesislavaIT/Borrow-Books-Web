import { fromHTML } from './common.js';

/**
 * @property {HTMLInputElement} _element
 * @property {Array<String>} accepted
 * @property {Number} max
 * @property {DataTransfer} data
 */
export class Dropzone
{
    constructor(element, options = {})
    {
        this._element = element;

        this.accepted = String(element.getAttribute('accept')).split(',');
        this.max      = parseInt(element.getAttribute('max'));

        this.data = new DataTransfer();

        this._create();
    }

    _create()
    {
        const self = this;

        const $rendered = fromHTML(`
            <div class="dropzone">
                <div class="dropzone-area">
                    <span style="text-align: center;">
                        Click to select or drag & drop file(s).<br>
                        (Maximum of ${self.max} files.)
                    </span>
                    <img src="assets/images/upload-file.png" alt="Upload Icon" class="upload-icon"/>
                </div>
                <ul class="dropzone-list"></ul>
            </div>
        `);

        const $area = $rendered.querySelector('.dropzone-area');

        $area.addEventListener('click', () => {
            self._element.querySelector('input[type="file"]').click();
        });
        $area.addEventListener('dragover', (event) => {
            event.preventDefault();
            $area.classList.add('hovered');
        });
        ['dragleave', 'dragend'].forEach((type) => {
            $area.addEventListener(type, () => $area.classList.remove('hovered'));
        });
        $area.addEventListener('drop', (event) => {
            event.preventDefault();

            if (event.dataTransfer.files.length) {
                self._handleFiles(event.dataTransfer.files);
            }

            $area.classList.remove('hovered');
        });
        self._element.addEventListener('change', (event) => {
            if (event.target.files.length) {
                self._handleFiles(event.target.files);
            }
        });

        this._element.parentNode.insertBefore($rendered, this._element.nextSibling);
        $rendered.prepend(this._element);

        self._element = $rendered;
    }

    _refresh()
    {
        const self = this;

        const $list = self._element.querySelector('.dropzone-list');

        $list.innerHTML = '';

        Array.from(self.data.files).forEach((file) => {
            const $item = fromHTML(`
                <li>
                    <i class="fa fa-fw fa-file"></i>
                    ${file.name}
                    <span class="size">${(file.size / 1024).toFixed(1)} KB</span>
                </li>
            `);

            $list.appendChild($item);
        });
    }

    _handleFiles(files)
    {
        const self = this;

        const $input = self._element.querySelector('input[type="file"]');

        Array.from(files).forEach((file) => {
            if (!self.accepted.includes(file.type)) {
                alert(`Invalid file type: ${file.name}`);
                return;
            }

            if (Array.from(self.data.files).some((f) => f.name === file.name && f.size === file.size)) {
                return;
            }

            if (self.data.items.length >= self.max) {
                return;
            }

            self.data.items.add(file);
        });

        $input.files = self.data.files;

        self._refresh();
    }
}
