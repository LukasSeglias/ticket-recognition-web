import {TicketText} from '/components/designer/ticket/TicketText.js';

export class TicketTextList  {
	
    constructor(element, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._element = element;
        this._selectListeners = [];
        this._disabled = false;

        /*
        this._drawingCanvas.addDrawableAddedListener((drawable) => {
            
            if(drawable instanceof TicketText) {
                console.log('DRAWABLE ADDED');
                this._addText(drawable);
            }
        });

        this._drawingCanvas.addDrawableRemovedListener((drawable) => {
            
            if(drawable instanceof TicketText) {
                console.log('DRAWABLE REMOVED');
                this._removeText(drawable);
            }
        });
        */

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
        console.log('set disabled to ' + disabled);
        this._disabled = disabled;
    }

    add(key) {

        if(!this.contains(key)) {

            console.log('addText: ' + key);

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
        console.log('removeText: ' + key);
        let content = this._element.querySelector(`li[data-text-key='${key}']`);
        this._element.removeChild(content);
    }

    contains(key) {
        return !!this._element.querySelector(`li[data-text-key='${key}']`);
    }

    /*
    _addText(drawable) {
        const key = this._drawingCanvas.calculateKey(drawable);

        let content = document.createElement('li');
        this._element.appendChild(content);
        content.outerHTML = `
            <li data-text-key='${key}' class="cursor-pointer list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                ${drawable.key() ||'test'}
            </li>
        `.trim();
        
        content.addEventListener('click', (event) => {
            console.log('clicked ' + key);
            // TODO: 
        });
    }

    _removeText(drawable) {
        const key = this._drawingCanvas.calculateKey(drawable);

        let content = this._element.querySelector(`li[data-text-key='${key}']`);
        this._element.removeChild(content);
    }
    */

}
