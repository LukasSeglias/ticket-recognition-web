import {TicketText} from '/public/designer/ticket/TicketText.js';

export class TextCreateMode {
			
    constructor(drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._lastMouse = undefined;
        this._mousedown = false;
        this._currentText = undefined;
        this._finishListeners = [];
    }

    onFinish(listener) {
        if(listener) {
            this._finishListeners.push(listener);
        }
    }

    mousedown(mouse) {
        this._lastMouse = mouse;
        this._mousedown = true;
        console.log('textcreate: mousedown');
    }

    mouseup(mouse) {
        this._mousedown = false;

        if(this._currentText) {
            
            this._notifyFinish(this._currentText);
            this._currentText = undefined;
        }
    }

    mousemove(mouse) {
        
        if (this._mousedown) {
            
            let newRectangle = this._drawingCanvas.drawableRectangle({
                x: Math.min(this._lastMouse.x, mouse.x),
                y: Math.min(this._lastMouse.y, mouse.y)
            },{
                x: Math.max(this._lastMouse.x, mouse.x),
                y: Math.max(this._lastMouse.y, mouse.y)
            });

            if(newRectangle) {
                let newText = new TicketText('', newRectangle);

                if(this._currentText) {
                    this._drawingCanvas.replace(this._currentText, newText);
                } else {
                    this._drawingCanvas.add(newText);
                }
                
                this._currentText = newText;
            }
        }
    }

    _notifyFinish(text) {
        this._finishListeners.forEach((listener) => {
            if(listener) listener.call(null, text);
        });
    }
}
