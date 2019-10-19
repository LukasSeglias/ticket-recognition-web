import {TicketText} from '/components/designer/ticket/TicketText.js';

export class TicketTextList  {
	
    constructor(element, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._element = element;

        this._drawingCanvas.addDrawableAddedListener((drawable) => {
            
            if(drawable instanceof TicketText) {
                this._addText(drawable);
            }
        });

        this._drawingCanvas.addDrawableRemovedListener((drawable) => {
            
            if(drawable instanceof TicketText) {
                this._removeText(drawable);
            }
        });
    }

    _addText(drawable) {
        const key = this._drawingCanvas.calculateKey(drawable);

        let content = document.createElement('li');
        this._element.appendChild(content);
        content.outerHTML = `<li data-text-key='${key}' class="list-group-item">${drawable.key() ||'test'}</li>`.trim();

        content.addEventListener('click', (event) => {
            console.log('clicked ' + key);
        });
        
    }

    _removeText(drawable) {
        const key = this._drawingCanvas.calculateKey(drawable);

        let content = this._element.querySelector(`li[data-text-key='${key}']`);
        this._element.removeChild(content);
    }
}
