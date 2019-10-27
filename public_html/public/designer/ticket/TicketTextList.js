import {TicketText} from '/public/designer/ticket/TicketText.js';

export class TicketTextList  {
	
    constructor(element, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._element = element;
        this._selectListeners = [];
        this._disabled = false;

        this._element.addEventListener('click', (event) => {

            if(!this._disabled) {

                let key = event.target ? event.target.getAttribute('data-text-key') : undefined;
                if(key) {
                    this._selectListeners.forEach((listener) => {
                        if(listener) listener(key);
                    });
                }
            }
        });
    }

    onSelect(fn) {
        if(fn) this._selectListeners.push(fn);
    }

    get disabled() {
        return this._disabled;
    }

    set disabled(disabled) {
        this._disabled = disabled;
    }

    set value(textDefinitions) {
        textDefinitions = textDefinitions || [];

        this.removeAll();
        textDefinitions.forEach((textDefinition) => {
            this.add(textDefinition.key);
        });
    }

    add(key) {

        if(!this.contains(key)) {

            let content = document.createElement('li');
            this._element.appendChild(content);
            content.outerHTML = `
                <li data-text-key='${key}' class="cursor-pointer list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    ${key}
                </li>
            `.trim();
        }
    }

    remove(key) {
        let content = this._element.querySelector(`li[data-text-key='${key}']`);
        this._element.removeChild(content);
    }

    removeAll() {
        this._element.innerHTML = '';
    }

    contains(key) {
        return !!this._element.querySelector(`li[data-text-key='${key}']`);
    }

}
